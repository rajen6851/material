<x-admin-layout>
    <x-slot name="title">Order #{{ $order->order_number }} - Pristo Admin</x-slot>

    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Top Navigation & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <nav class="flex text-slate-400 text-xs gap-1.5 items-center mb-1">
                    <a href="/admin/dashboard" class="hover:text-teal-600">Admin</a>
                    <span>/</span>
                    <a href="{{ route('admin.orders') }}" class="hover:text-teal-600">Orders</a>
                    <span>/</span>
                    <span class="text-slate-700 font-semibold font-mono">{{ $order->order_number }}</span>
                </nav>
                <div class="flex items-center gap-3 mt-1">
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Order #{{ $order->order_number }}</h1>
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                        {{ $order->order_status === 'pending' ? 'bg-amber-100 text-amber-900 border border-amber-300' : '' }}
                        {{ $order->order_status === 'packed' ? 'bg-indigo-100 text-indigo-900 border border-indigo-300' : '' }}
                        {{ $order->order_status === 'shipped' ? 'bg-blue-100 text-blue-900 border border-blue-300' : '' }}
                        {{ $order->order_status === 'delivered' ? 'bg-emerald-100 text-emerald-900 border border-emerald-300' : '' }}
                        {{ $order->order_status === 'cancelled' ? 'bg-rose-100 text-rose-900 border border-rose-300' : '' }}
                    ">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>
                <p class="text-xs text-slate-400 mt-1">Placed on {{ $order->created_at->format('l, F d, Y \a\t h:i A') }}</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.orders.invoice', $order->id) }}" 
                   target="_blank" 
                   style="background-color: #c09b5a; color: #ffffff;"
                   class="inline-flex items-center gap-2 hover:opacity-90 font-bold px-5 py-3 rounded-xl text-xs uppercase tracking-wider shadow-md transition">
                    <span>🖨️ Print GST Tax Invoice</span>
                </a>
                <a href="{{ route('admin.orders') }}" class="bg-white border border-slate-200 hover:border-slate-300 text-slate-700 text-xs font-bold px-4 py-3 rounded-xl transition shadow-xs">
                    Back to Orders
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Main Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left 8 cols: Ordered Products & Financials -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Ordered Products Card -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <h2 class="font-extrabold text-slate-900 text-lg">Purchased Products &amp; Slabs</h2>
                            <p class="text-xs text-slate-400">Total of {{ $order->items->sum('quantity') }} unit(s) across {{ $order->items->count() }} line item(s)</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-200 bg-slate-50 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                                    <th class="py-3 px-4">Item Details</th>
                                    <th class="py-3 px-4 text-right">Unit Price</th>
                                    <th class="py-3 px-4 text-center">Qty / Boxes</th>
                                    <th class="py-3 px-4 text-right">Tax (GST)</th>
                                    <th class="py-3 px-4 text-right">Total (INR)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($order->items as $item)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="py-4 px-4 flex items-center gap-3.5">
                                            @if($item->product && $item->product->featured_image)
                                                <img src="{{ asset($item->product->featured_image) }}" 
                                                     alt="Thumb" 
                                                     class="w-12 h-12 object-contain rounded-xl border border-slate-200 bg-white p-1 flex-shrink-0">
                                            @else
                                                <div class="w-12 h-12 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-400 font-bold flex-shrink-0">
                                                    📦
                                                </div>
                                            @endif
                                            <div class="space-y-0.5">
                                                <span class="font-extrabold text-slate-900 text-sm block">
                                                    {{ $item->product->name ?? 'Product #' . $item->product_id }}
                                                </span>
                                                @if($item->product && $item->product->sku)
                                                    <span class="text-[10px] text-slate-400 font-mono block">SKU: {{ $item->product->sku }}</span>
                                                @endif
                                                @if($item->product && $item->product->category)
                                                    <span class="text-[10px] text-[#c09b5a] font-semibold block">{{ $item->product->category->name }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-4 px-4 text-right font-semibold text-slate-700">
                                            ₹{{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="py-4 px-4 text-center font-bold text-slate-900">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="py-4 px-4 text-right text-slate-500">
                                            ₹{{ number_format($item->tax, 2) }}
                                        </td>
                                        <td class="py-4 px-4 text-right font-black text-slate-900 text-sm">
                                            ₹{{ number_format($item->total, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Financial Calculation Breakdown -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs">
                    <h3 class="font-extrabold text-slate-900 text-base border-b border-slate-100 pb-3 mb-4">Financial Summary</h3>
                    
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between items-center text-slate-600">
                            <span>Materials Subtotal:</span>
                            <span class="font-semibold text-slate-900">₹{{ number_format($order->subtotal, 2) }}</span>
                        </div>

                        @if($order->discount > 0)
                            <div class="flex justify-between items-center text-emerald-700">
                                <span>Promotional Discount:</span>
                                <span class="font-semibold">- ₹{{ number_format($order->discount, 2) }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between items-center text-slate-600">
                            <span>Applicable Taxes (GST 18%):</span>
                            <span class="font-semibold text-slate-900">₹{{ number_format($order->tax, 2) }}</span>
                        </div>

                        <div class="flex justify-between items-center text-slate-600">
                            <span>Shipping &amp; Pallet Freight:</span>
                            <span class="font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                Charges Applicable (At Actuals)
                            </span>
                        </div>

                        <div class="pt-3 border-t border-slate-200 flex justify-between items-center text-base font-black text-slate-900">
                            <span>Grand Total Amount:</span>
                            <span class="text-xl text-[#c09b5a]">₹{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right 4 cols: Customer, Shipping & Status Control -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Status Control Box -->
                <div class="bg-[#0d2238] text-white rounded-3xl p-6 shadow-md space-y-5">
                    <h3 class="font-bold text-sm text-teal-400 uppercase tracking-wider">Fulfillment &amp; Payment Action</h3>
                    
                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="space-y-1.5">
                            <label class="block text-[10px] uppercase font-bold text-slate-400">Order Progress</label>
                            <select name="order_status" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-teal-400">
                                <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending (Received)</option>
                                <option value="packed" {{ $order->order_status === 'packed' ? 'selected' : '' }}>Packed &amp; Palletized</option>
                                <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped / Out for Delivery</option>
                                <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered Successfully</option>
                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[10px] uppercase font-bold text-slate-400">Payment Status</label>
                            <select name="payment_status" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2.5 text-xs text-white focus:outline-none focus:border-teal-400">
                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending (Unpaid)</option>
                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid (Payment Confirmed)</option>
                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                                <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-teal-500 hover:bg-teal-600 text-white font-bold py-3 rounded-xl text-xs uppercase tracking-wider transition shadow-md">
                            Update Order Progress
                        </button>
                    </form>
                </div>

                <!-- Customer Details Card -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs space-y-4">
                    <span class="text-[10px] uppercase font-bold tracking-wider text-[#c09b5a] block">CUSTOMER PROFILE</span>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="font-extrabold text-slate-900 text-sm">{{ $order->name }}</span>
                            @if($order->user && $order->user->isProfessional())
                                <span class="bg-amber-100 text-amber-900 border border-amber-300 text-[9px] px-2 py-0.5 rounded-full font-bold uppercase">B2B Trade</span>
                            @else
                                <span class="bg-slate-100 text-slate-600 text-[9px] px-2 py-0.5 rounded-full font-bold uppercase">Homeowner</span>
                            @endif
                        </div>

                        <p class="text-slate-600">
                            <strong>Email:</strong> <a href="mailto:{{ $order->email }}" class="text-teal-600 hover:underline">{{ $order->email }}</a>
                        </p>
                        <p class="text-slate-600">
                            <strong>Phone:</strong> <a href="tel:{{ $order->phone }}" class="text-teal-600 hover:underline font-bold">{{ $order->phone }}</a>
                        </p>

                        @if($order->gst_number)
                            <div class="pt-2 border-t border-slate-100">
                                <span class="text-[10px] text-slate-400 uppercase font-bold block">Tax GSTIN:</span>
                                <span class="font-mono font-bold text-indigo-700 text-xs">{{ $order->gst_number }}</span>
                            </div>
                        @endif

                        <div class="pt-2 border-t border-slate-100">
                            <span class="text-[10px] text-slate-400 uppercase font-bold block">Payment Option:</span>
                            <span class="font-bold text-slate-800 uppercase">{{ strtoupper($order->payment_method) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address Card -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs space-y-3">
                    <span class="text-[10px] uppercase font-bold tracking-wider text-[#c09b5a] block">SHIPPING DESTINATION</span>
                    <div class="text-xs text-slate-600 leading-relaxed whitespace-pre-line bg-slate-50 p-4 rounded-2xl border border-slate-100 font-mono">
                        {{ $order->shipping_address }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-admin-layout>
