<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * View the Cart Page.
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        $totals = $this->calculateTotals($cartItems);

        return view('cart.index', array_merge(
            ['cartItems' => $cartItems],
            $totals
        ));
    }

    /**
     * Add an item to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $request->input('product_id');
        $qty = $request->input('quantity');
        $product = Product::findOrFail($productId);

        // Determine the quantity already in the cart for this product
        $existingQty = 0;
        if (auth()->check()) {
            $existingQty = (int) CartItem::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->value('quantity');
        } else {
            $cart = session()->get('cart', []);
            $existingQty = isset($cart[$productId]) ? (int) $cart[$productId]['quantity'] : 0;
        }

        // Stock validation
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Sorry, "'.$product->name.'" is currently out of stock.');
        }
        if ($existingQty + $qty > $product->stock) {
            return redirect()->back()->with('error', 'Only '.$product->stock.' sq.ft of "'.$product->name.'" is available in stock.');
        }

        if (auth()->check()) {
            // Logged in: DB storage
            $cartItem = CartItem::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $qty;
                $cartItem->save();
            } else {
                CartItem::create([
                    'user_id' => auth()->id(),
                    'product_id' => $productId,
                    'quantity' => $qty
                ]);
            }
        } else {
            // Guest: Session storage
            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $qty;
            } else {
                $cart[$productId] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => (float)$product->price,
                    'gst_percent' => (float)$product->gst_percent,
                    'featured_image' => $product->featured_image,
                    'quantity' => $qty
                ];
            }
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update quantity of an item.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $request->input('product_id');
        $qty = $request->input('quantity');

        if (auth()->check()) {
            $cartItem = CartItem::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->first();

            if ($cartItem) {
                $cartItem->quantity = $qty;
                $cartItem->save();
            }
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $qty;
                session()->put('cart', $cart);
            }
        }

        return redirect()->back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $productId = $request->input('product_id');

        if (auth()->check()) {
            CartItem::where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $cart = session()->get('cart', []);
            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                session()->put('cart', $cart);
            }
        }

        return redirect()->back()->with('success', 'Item removed from cart!');
    }

    /**
     * Buy Now: add the item to the cart (with selected quantity), then go straight to checkout.
     */
    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $this->add($request);

        return redirect()->route('checkout.index')->with('success', 'Proceeding to checkout.');
    }

    /**
     * Apply a coupon.
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $code = strtoupper($request->input('code'));
        $coupon = Coupon::where('code', $code)->where('is_active', true)->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'Invalid or expired coupon code.');
        }

        session()->put('coupon_code', $code);
        return redirect()->back()->with('success', 'Coupon code applied successfully!');
    }

    /**
     * Checkout form view.
     */
    public function checkout()
    {
        // Require auth
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to continue checkout.');
        }

        $cartItems = $this->getCartItems();
        if (count($cartItems) === 0) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        $totals = $this->calculateTotals($cartItems);

        $addresses = Address::where('user_id', auth()->id())->get();

        return view('cart.checkout', array_merge(
            ['cartItems' => $cartItems, 'addresses' => $addresses],
            $totals
        ));
    }

    /**
     * Place order processing.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'address_id' => 'required_without:new_address|nullable|exists:addresses,id',
            'new_address' => 'required_without:address_id|nullable|array',
            'payment_method' => 'required|string|in:cod,card'
        ]);

        $cartItems = $this->getCartItems();
        if (count($cartItems) === 0) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty.');
        }

        // Bangalore-only delivery check: only these PIN codes can receive orders.
        $allowedPincodes = config('delivery.pincodes', []);
        $deliveryPincode = $request->filled('address_id')
            ? (string) Address::where('id', $request->input('address_id'))
                ->where('user_id', auth()->id())
                ->value('postal_code')
            : (string) $request->input('new_address.postal_code', '');

        if (! in_array($deliveryPincode, $allowedPincodes, true)) {
            return redirect()->back()->with('error', 'Sorry, we currently deliver only within Bangalore city. Please enter a valid Bangalore PIN code (e.g. 560001, 560034, 560103).');
        }

        // Get shipping address details
        if ($request->filled('address_id')) {
            $address = Address::where('id', $request->input('address_id'))
                ->where('user_id', auth()->id())
                ->firstOrFail();
            $shippingText = sprintf(
                "%s\n%s, %s\n%s, %s - %s\nCountry: %s\nPhone: %s",
                $address->name,
                $address->address_line_1,
                $address->address_line_2,
                $address->city,
                $address->state,
                $address->postal_code,
                $address->country,
                $address->phone
            );
            $orderName = $address->name;
            $orderPhone = $address->phone;
        } else {
            // Create new address
            $newAddr = $request->input('new_address');
            $address = Address::create([
                'user_id' => auth()->id(),
                'name' => $newAddr['name'],
                'phone' => $newAddr['phone'],
                'address_line_1' => $newAddr['address_line_1'],
                'address_line_2' => $newAddr['address_line_2'] ?? null,
                'city' => $newAddr['city'],
                'state' => $newAddr['state'],
                'postal_code' => $newAddr['postal_code'],
                'country' => $newAddr['country'] ?? 'India',
                'type' => $newAddr['type'] ?? 'home'
            ]);

            $shippingText = sprintf(
                "%s\n%s, %s\n%s, %s - %s\nCountry: %s\nPhone: %s",
                $address->name,
                $address->address_line_1,
                $address->address_line_2,
                $address->city,
                $address->state,
                $address->postal_code,
                $address->country,
                $address->phone
            );
            $orderName = $address->name;
            $orderPhone = $address->phone;
        }

        // Calculate checkout totals
        $totals = $this->calculateTotals($cartItems);
        $subtotal = $totals['subtotal'];
        $totalTax = $totals['totalTax'];
        $discount = $totals['discount'];
        $shipping = $totals['shipping'];
        $total = $totals['total'];

        // Create Order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'MD-' . strtoupper(Str::random(10)),
            'name' => $orderName,
            'email' => auth()->user()->email,
            'phone' => $orderPhone,
            'gst_number' => auth()->user()->gst_number, // Pass Professional GST if present
            'shipping_address' => $shippingText,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'tax' => $totalTax,
            'shipping' => $shipping,
            'total' => $total,
            'payment_method' => $request->input('payment_method'),
            'payment_status' => $request->input('payment_method') === 'cod' ? 'pending' : 'paid',
            'order_status' => 'pending'
        ]);

        // Create Order Items
        foreach ($cartItems as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $itemTax = $itemTotal - ($itemTotal / (1 + ($item['gst_percent'] / 100)));

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'tax' => $itemTax,
                'total' => $itemTotal
            ]);
        }

        // Clear Cart
        if (auth()->check()) {
            CartItem::where('user_id', auth()->id())->delete();
        }
        session()->forget('cart');
        session()->forget('coupon_code');

        return redirect()->route('checkout.success', $order->id)->with('success', 'Order placed successfully!');
    }

    /**
     * Checkout Success.
     */
    public function success($id)
    {
        $order = Order::with('items.product')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('cart.success', compact('order'));
    }

    /**
     * Retrieve items from DB or Session.
     */
    private function getCartItems(): array
    {
        if (auth()->check()) {
            $dbItems = CartItem::where('user_id', auth()->id())->with('product')->get();
            $items = [];
            foreach ($dbItems as $dbItem) {
                if ($dbItem->product) {
                    $items[$dbItem->product_id] = [
                        'id' => $dbItem->product_id,
                        'name' => $dbItem->product->name,
                        'slug' => $dbItem->product->slug,
                        'price' => (float)$dbItem->product->price,
                        'gst_percent' => (float)$dbItem->product->gst_percent,
                        'featured_image' => $dbItem->product->featured_image,
                        'quantity' => $dbItem->quantity
                    ];
                }
            }
            return $items;
        }

        return session()->get('cart', []);
    }

    /**
     * Compute shared cart/order totals (subtotal, GST, coupon, shipping, grand total).
     * Invalid coupons (expired / below minimum) are automatically cleared.
     */
    private function calculateTotals(array $cartItems): array
    {
        $subtotal = 0;
        $totalTax = 0;

        foreach ($cartItems as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $subtotal += $itemTotal;
            // GST component included in price: Price - (Price / (1 + GST%/100))
            $totalTax += $itemTotal - ($itemTotal / (1 + ($item['gst_percent'] / 100)));
        }

        $couponCode = session()->get('coupon_code');
        $discount = 0;
        $coupon = null;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)->first();
            if ($coupon && $coupon->isValidForAmount($subtotal)) {
                $discount = $coupon->calculateDiscount($subtotal);
            } else {
                session()->forget('coupon_code');
            }
        }

        $shipping = 0; // Freight and delivery charges applicable at actuals upon dispatch
        $total = max(0, $subtotal - $discount);

        return compact('subtotal', 'totalTax', 'discount', 'shipping', 'total', 'coupon');
    }
}
