<x-admin-layout>
    <x-slot name="title">Manage Orders & Fulfillment - Pristo Admin</x-slot>

    <div class="space-y-8">
        <!-- Breadcrumb & Top Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <nav class="flex text-slate-400 text-xs gap-1.5 items-center mb-1">
                    <a href="/admin/dashboard" class="hover:text-teal-600">Admin</a>
                    <span>/</span>
                    <span class="text-slate-700 font-semibold">Orders &amp; Fulfillment</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Order Fulfillment Queue</h1>
                <p class="text-xs text-slate-500 mt-0.5">Manage customer orders, inspect ordered items, print GST tax invoices, and update shipping progress.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="/admin/dashboard" class="bg-white border border-slate-200 hover:border-slate-300 text-slate-700 text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-xs">
                    Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-xs">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Metric KPI Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-xs">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">Total Orders</span>
                <span class="text-2xl font-black text-slate-900">{{ $counts['all'] }}</span>
            </div>
            <div class="bg-white border border-amber-200 rounded-2xl p-5 shadow-xs bg-amber-50/30">
                <span class="text-[10px] text-amber-700 font-bold uppercase tracking-wider block mb-1">Pending Packing</span>
                <span class="text-2xl font-black text-amber-900">{{ $counts['pending'] }}</span>
            </div>
            <div class="bg-white border border-blue-200 rounded-2xl p-5 shadow-xs bg-blue-50/30">
                <span class="text-[10px] text-blue-700 font-bold uppercase tracking-wider block mb-1">In Transit (Shipped)</span>
                <span class="text-2xl font-black text-blue-900">{{ $counts['shipped'] }}</span>
            </div>
            <div class="bg-white border border-emerald-200 rounded-2xl p-5 shadow-xs bg-emerald-50/30">
                <span class="text-[10px] text-emerald-700 font-bold uppercase tracking-wider block mb-1">Total Paid Revenue</span>
                <span class="text-2xl font-black text-emerald-900">₹{{ number_format($counts['total_revenue'], 0) }}</span>
            </div>
        </div>

        <!-- Filter Tabs & Search Bar -->
        <div class="bg-white border border-slate-200 rounded-2xl p-4 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Status Tabs -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0 scrollbar-none text-xs font-bold">
                <a href="{{ route('admin.orders', ['status' => 'all', 'search' => $search]) }}" 
                   class="px-3.5 py-2 rounded-xl transition {{ (!$status || $status === 'all') ? 'bg-[#0d2238] text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    All ({{ $counts['all'] }})
                </a>
                <a href="{{ route('admin.orders', ['status' => 'pending', 'search' => $search]) }}" 
                   class="px-3.5 py-2 rounded-xl transition {{ $status === 'pending' ? 'bg-amber-500 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    Pending ({{ $counts['pending'] }})
                </a>
                <a href="{{ route('admin.orders', ['status' => 'packed', 'search' => $search]) }}" 
                   class="px-3.5 py-2 rounded-xl transition {{ $status === 'packed' ? 'bg-indigo-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    Packed ({{ $counts['packed'] }})
                </a>
                <a href="{{ route('admin.orders', ['status' => 'shipped', 'search' => $search]) }}" 
                   class="px-3.5 py-2 rounded-xl transition {{ $status === 'shipped' ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    Shipped ({{ $counts['shipped'] }})
                </a>
                <a href="{{ route('admin.orders', ['status' => 'delivered', 'search' => $search]) }}" 
                   class="px-3.5 py-2 rounded-xl transition {{ $status === 'delivered' ? 'bg-emerald-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    Delivered ({{ $counts['delivered'] }})
                </a>
                <a href="{{ route('admin.orders', ['status' => 'cancelled', 'search' => $search]) }}" 
                   class="px-3.5 py-2 rounded-xl transition {{ $status === 'cancelled' ? 'bg-rose-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                    Cancelled ({{ $counts['cancelled'] }})
                </a>
            </div>

            <!-- Search Form -->
            <form action="{{ route('admin.orders') }}" method="GET" class="flex items-center gap-2">
                @if($status)
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif
                <input type="text" 
                       name="search" 
                       value="{{ $search }}" 
                       placeholder="Search by Order #, Name, Phone..." 
                       class="border border-slate-300 focus:border-teal-500 rounded-xl px-3.5 py-2 text-xs w-full sm:w-64 focus:outline-none">
                <button type="submit" class="bg-[#0d2238] hover:bg-slate-800 text-white font-bold px-4 py-2 rounded-xl text-xs transition">
                    Filter
                </button>
                @if($search || ($status && $status !== 'all'))
                    <a href="{{ route('admin.orders') }}" class="text-xs text-slate-400 hover:text-slate-600 underline">Reset</a>
                @endif
            </form>
        </div>

        <!-- Orders Listing Table -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
            @if($orders->isEmpty())
                <div class="text-center py-20 space-y-3">
                    <span class="text-4xl">📦</span>
                    <h3 class="text-base font-bold text-slate-800">No orders found</h3>
                    <p class="text-xs text-slate-400">There are currently no customer orders matching your selected filter.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50/80 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                                <th class="py-4 px-5">Order Reference</th>
                                <th class="py-4 px-5">Customer &amp; Destination</th>
                                <th class="py-4 px-5">Ordered Items</th>
                                <th class="py-4 px-5">Amount (INR)</th>
                                <th class="py-4 px-5">Fulfillment Status</th>
                                <th class="py-4 px-5">Payment</th>
                                <th class="py-4 px-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($orders as $order)
                                <tr class="hover:bg-slate-50/70 transition">
                                    <!-- Order Info -->
                                    <td class="py-4 px-5 space-y-1 align-top">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="font-bold text-slate-900 font-mono text-sm hover:text-teal-600 transition block">
                                            {{ $order->order_number }}
                                        </a>
                                        <span class="text-[11px] text-slate-400 block">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $order->payment_method === 'cod' ? 'bg-amber-100 text-amber-800' : 'bg-teal-100 text-teal-800' }}">
                                            {{ strtoupper($order->payment_method) }}
                                        </span>
                                    </td>

                                    <!-- Customer Details -->
                                    <td class="py-4 px-5 space-y-1 align-top">
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-bold text-slate-900">{{ $order->name }}</span>
                                            @if($order->user && $order->user->isProfessional())
                                                <span class="bg-amber-100 text-amber-900 border border-amber-300 text-[9px] px-1.5 py-0.5 rounded font-bold uppercase">B2B Trade</span>
                                            @endif
                                        </div>
                                        <span class="text-slate-500 block">📞 {{ $order->phone }}</span>
                                        <span class="text-slate-400 block truncate max-w-xs">{{ $order->email }}</span>
                                        @if($order->gst_number)
                                            <span class="inline-block bg-purple-50 text-purple-700 border border-purple-200 px-1.5 py-0.5 rounded font-mono text-[9px] font-bold mt-0.5">
                                                GST: {{ $order->gst_number }}
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Ordered Items Summary -->
                                    <td class="py-4 px-5 space-y-1.5 align-top">
                                        <span class="font-bold text-slate-800 block text-[11px]">
                                            {{ $order->items->sum('quantity') }} items ({{ $order->items->count() }} product{{ $order->items->count() > 1 ? 's' : '' }})
                                        </span>
                                        <div class="space-y-1 max-w-xs">
                                            @foreach($order->items->take(2) as $item)
                                                <div class="flex items-center gap-2 text-[11px] text-slate-600 bg-slate-50 p-1.5 rounded-lg border border-slate-100">
                                                    @if($item->product && $item->product->featured_image)
                                                        <img src="{{ asset($item->product->featured_image) }}" alt="Thumbnail" class="w-6 h-6 object-contain rounded bg-white flex-shrink-0">
                                                    @endif
                                                    <span class="truncate flex-1 font-medium">{{ $item->product->name ?? 'Product #' . $item->product_id }}</span>
                                                    <span class="font-bold text-slate-900 flex-shrink-0">x{{ $item->quantity }}</span>
                                                </div>
                                            @endforeach
                                            @if($order->items->count() > 2)
                                                <span class="text-[10px] text-teal-600 font-bold block pl-1">+ {{ $order->items->count() - 2 }} more item(s)</span>
                                            @endif
                                        </div>
                                    </td>

                                    <!-- Total Amount -->
                                    <td class="py-4 px-5 space-y-0.5 align-top">
                                        <span class="font-black text-slate-900 text-sm block">₹{{ number_format($order->total, 2) }}</span>
                                        <span class="text-[10px] text-slate-400 block">Tax: ₹{{ number_format($order->tax, 2) }}</span>
                                        <span class="text-[10px] text-amber-700 font-bold block">Shipping: At Actuals</span>
                                    </td>

                                    <!-- Inline Status Form -->
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                        @csrf
                                        
                                        <!-- Order Status -->
                                        <td class="py-4 px-5 align-top">
                                            <select name="order_status" onchange="this.form.submit()" class="text-xs font-bold rounded-lg border-slate-300 p-1.5 focus:border-teal-500 focus:ring-0
                                                {{ $order->order_status === 'pending' ? 'text-amber-700 bg-amber-50/50' : '' }}
                                                {{ $order->order_status === 'packed' ? 'text-indigo-700 bg-indigo-50/50' : '' }}
                                                {{ $order->order_status === 'shipped' ? 'text-blue-700 bg-blue-50/50' : '' }}
                                                {{ $order->order_status === 'delivered' ? 'text-emerald-700 bg-emerald-50/50' : '' }}
                                                {{ $order->order_status === 'cancelled' ? 'text-rose-700 bg-rose-50/50' : '' }}
                                            ">
                                                <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="packed" {{ $order->order_status === 'packed' ? 'selected' : '' }}>Packed</option>
                                                <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </td>

                                        <!-- Payment Status -->
                                        <td class="py-4 px-5 align-top">
                                            <select name="payment_status" onchange="this.form.submit()" class="text-xs font-bold rounded-lg border-slate-300 p-1.5 focus:border-teal-500 focus:ring-0
                                                {{ $order->payment_status === 'pending' ? 'text-amber-700 bg-amber-50/50' : '' }}
                                                {{ $order->payment_status === 'paid' ? 'text-emerald-700 bg-emerald-50/50' : '' }}
                                                {{ $order->payment_status === 'failed' ? 'text-rose-700 bg-rose-50/50' : '' }}
                                                {{ $order->payment_status === 'refunded' ? 'text-purple-700 bg-purple-50/50' : '' }}
                                            ">
                                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                                                <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                            </select>
                                        </td>
                                    </form>

                                    <!-- Actions: Details & Invoice -->
                                    <td class="py-4 px-5 text-right space-y-2 align-top whitespace-nowrap">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" 
                                           class="inline-flex items-center gap-1.5 bg-[#0d2238] hover:bg-slate-800 text-white font-bold text-[11px] px-3 py-1.5 rounded-lg shadow-xs transition">
                                            <span>Details</span>
                                            <span>➔</span>
                                        </a>
                                        <a href="{{ route('admin.orders.invoice', $order->id) }}" 
                                           target="_blank" 
                                           class="inline-flex items-center gap-1 bg-amber-50 border border-amber-300 hover:bg-amber-100 text-amber-900 font-bold text-[11px] px-2.5 py-1.5 rounded-lg transition shadow-xs">
                                            <span>🖨️ Invoice</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($orders->hasPages())
                    <div class="p-4 border-t border-slate-200">
                        {{ $orders->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-admin-layout>
