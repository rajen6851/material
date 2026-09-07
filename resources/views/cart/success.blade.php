<x-app-layout>
    <x-slot name="title">Order Confirmed - MaterialDeck</x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center space-y-10">
        <!-- Success Icon -->
        <div class="w-20 h-20 bg-teal-100 rounded-full flex items-center justify-center mx-auto text-teal-600 shadow-sm">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
        </div>

        <div class="space-y-3">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Thank you for your order!</h1>
            <p class="text-slate-500 text-sm max-w-md mx-auto">Your order has been received and is being processed by our partner brands.</p>
        </div>

        <!-- Order Information Card -->
        <div class="bg-white border rounded-2xl p-6 text-left shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row justify-between sm:items-center border-b pb-4 gap-2">
                <div>
                    <span class="text-slate-400 text-xs font-semibold block uppercase">Order Number</span>
                    <span class="font-bold text-slate-800 text-base font-mono">{{ $order->order_number }}</span>
                </div>
                <div>
                    <span class="text-slate-400 text-xs font-semibold block uppercase">Payment Method</span>
                    <span class="font-bold text-slate-800 text-sm uppercase">{{ $order->payment_method }} ({{ $order->payment_status }})</span>
                </div>
            </div>

            <!-- Shipping Address Details -->
            <div>
                <span class="text-slate-400 text-xs font-semibold block uppercase mb-1">Shipping Details</span>
                <p class="text-sm text-slate-600 whitespace-pre-line leading-relaxed bg-slate-50 p-4 rounded-xl font-medium">{{ $order->shipping_address }}</p>
            </div>

            <!-- Order Items -->
            <div>
                <span class="text-slate-400 text-xs font-semibold block uppercase mb-2">Items Summary</span>
                <div class="divide-y text-sm">
                    @foreach($order->items as $item)
                        <div class="py-3 flex justify-between">
                            <span class="text-slate-600">{{ $item->product->name ?? ($item->product_name ?? 'Product #' . $item->product_id) }} <strong class="text-slate-900">x{{ $item->quantity }}</strong></span>
                            <span class="font-bold text-slate-900">₹{{ number_format($item->total, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Totals -->
            <div class="border-t pt-4 space-y-2 text-sm text-slate-600">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->discount > 0)
                    <div class="flex justify-between text-red-600 font-medium">
                        <span>Discount</span>
                        <span>-₹{{ number_format($order->discount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between">
                    <span>Shipping</span>
                    <span>₹{{ number_format($order->shipping, 2) }}</span>
                </div>
                <div class="flex justify-between text-slate-900 font-extrabold text-base pt-2 border-t">
                    <span>Total Paid</span>
                    <span>₹{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-4 justify-center">
            <a href="/products" class="bg-slate-900 hover:bg-slate-800 text-white font-bold px-8 py-3.5 rounded-xl transition text-sm">Continue Shopping</a>
            <a href="/dashboard" class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold px-8 py-3.5 rounded-xl transition text-sm">Track in Dashboard</a>
        </div>
    </div>
</x-app-layout>
