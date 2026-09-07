<x-app-layout>
    <x-slot name="title">Shopping Cart - MaterialDeck</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h1 class="text-3xl font-extrabold text-slate-900 mb-10">Shopping Cart</h1>

        @if(count($cartItems) === 0)
            <div class="bg-white border rounded-2xl p-16 text-center max-w-xl mx-auto shadow-sm">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Your Cart is Empty</h3>
                <p class="text-slate-500 text-sm">Add premium materials, tiles, and sanitary items from our catalog to get started.</p>
                <a href="/products" class="inline-block bg-teal-600 hover:bg-teal-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition mt-6 shadow-sm">Browse Products</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
                
                <!-- Left: Items list -->
                <div class="lg:col-span-2 space-y-6">
                    @foreach($cartItems as $item)
                        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm flex flex-col sm:flex-row items-center gap-6">
                            <!-- Image -->
                            <div class="w-24 h-20 sm:w-28 sm:h-24 flex-shrink-0 bg-slate-50 rounded-xl overflow-hidden flex items-center justify-center p-2 border">
                                <img src="{{ asset($item['featured_image']) }}" alt="{{ $item['name'] }}" class="max-h-full object-contain rounded">
                            </div>

                            <!-- Name & Price -->
                            <div class="flex-grow text-center sm:text-left space-y-1.5">
                                <a href="/products/{{ $item['slug'] }}" class="font-bold text-slate-800 hover:text-teal-600 text-base line-clamp-1 transition">{{ $item['name'] }}</a>
                                <p class="text-xs text-slate-400">Includes GST ({{ $item['gst_percent'] }}%)</p>
                                <div class="text-sm font-extrabold text-slate-900">₹{{ number_format($item['price'], 2) }} <span class="text-xs text-slate-400 font-light">/ box</span></div>
                            </div>

                            <!-- Quantity Form -->
                            <div class="flex items-center gap-2">
                                <form action="/cart/update" method="POST" class="flex items-center border rounded-xl overflow-hidden h-10 bg-slate-50">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                    <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}" {{ $item['quantity'] <= 1 ? 'disabled' : '' }} class="px-3 text-slate-500 hover:bg-slate-100 h-full font-bold transition disabled:opacity-40">&minus;</button>
                                    <input type="number" class="w-12 border-none text-center bg-transparent focus:ring-0 font-bold text-slate-800 text-sm" value="{{ $item['quantity'] }}" readonly>
                                    <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}" class="px-3 text-slate-500 hover:bg-slate-100 h-full font-bold transition">&plus;</button>
                                </form>

                                <!-- Delete Form -->
                                <form action="/cart/remove" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>

                            <!-- Subtotal -->
                            <div class="text-right font-extrabold text-slate-900 text-base sm:w-28">
                                ₹{{ number_format($item['price'] * $item['quantity'], 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Right: Summary Sidebar -->
                <div class="space-y-6">
                    <!-- Coupon Card -->
                    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm space-y-4">
                        <h3 class="font-extrabold text-slate-900 text-sm">Have a Coupon?</h3>
                        
                        @if($coupon)
                            <div class="bg-teal-50 border border-teal-100 p-3 rounded-xl flex items-center justify-between text-teal-800 text-xs font-semibold">
                                <span>Applied Coupon: <strong class="text-teal-950 font-bold">{{ $coupon->code }}</strong></span>
                                <span class="bg-teal-200 text-teal-900 px-2 py-0.5 rounded">Active</span>
                            </div>
                        @endif

                        <form action="/cart/coupon" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="code" placeholder="WELCOME10" required class="flex-grow border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm px-3.5 py-2.5">
                            <button type="submit" class="bg-slate-950 hover:bg-teal-600 text-white font-bold px-4 rounded-xl text-sm transition">Apply</button>
                        </form>
                        <p class="text-[10px] text-slate-400">Try coupon <strong class="text-slate-600">WELCOME10</strong> for 10% discount on orders above ₹1,000.</p>
                    </div>

                    <!-- Summary Card -->
                    <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm space-y-6">
                        <h3 class="font-extrabold text-slate-900 text-base border-b pb-4">Order Summary</h3>
                        
                        <div class="space-y-3.5 text-sm text-slate-600">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span class="font-semibold text-slate-800">₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                            
                            @if($discount > 0)
                                <div class="flex justify-between text-red-600 font-medium">
                                    <span>Coupon Discount</span>
                                    <span>-₹{{ number_format($discount, 2) }}</span>
                                </div>
                            @endif

                            <div class="flex justify-between">
                                <span>Shipping Fee</span>
                                @if($shipping === 0)
                                    <span class="font-bold text-teal-600 uppercase text-xs">Free Delivery</span>
                                @else
                                    <span class="font-semibold text-slate-800">₹{{ number_format($shipping, 2) }}</span>
                                @endif
                            </div>

                            <div class="flex justify-between text-xs text-slate-400 pt-2 border-t">
                                <span>Incl. GST (Est.)</span>
                                <span>₹{{ number_format($totalTax, 2) }}</span>
                            </div>
                        </div>

                        <div class="border-t pt-4 flex justify-between items-baseline">
                            <span class="font-extrabold text-slate-900 text-base">Grand Total</span>
                            <span class="font-black text-slate-900 text-2xl">₹{{ number_format($total, 2) }}</span>
                        </div>

                        <a href="/checkout" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold h-14 rounded-xl shadow-lg hover:shadow-teal-500/20 transition flex items-center justify-center gap-2">
                            <span>Proceed to Checkout</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        <p class="text-center text-[10px] text-slate-400">Free delivery on orders above ₹5,000.</p>
                    </div>
                </div>

            </div>
        @endif
    </div>
</x-app-layout>
