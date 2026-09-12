<x-admin-layout>
    <x-slot name="title">Admin Command Center - Pristo Enterprises</x-slot>

    <div class="space-y-8">
        <!-- Main Header -->
        <div class="flex justify-between items-center border-b pb-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Admin Command Center</h1>
                <p class="text-slate-500 text-sm">Dashboard Management Center (Pristo Luxury Surfaces)</p>
            </div>
        </div>

        <!-- KPI Dashboard Indicators Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Revenue Card -->
            <div class="bg-white border rounded-2xl p-6 shadow-sm flex items-center justify-between relative overflow-hidden">
                <div class="space-y-1">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Total Revenue (Paid)</span>
                    <span class="text-2xl font-black text-slate-900">₹{{ number_format($totalRevenue, 0) }}</span>
                </div>
                <div class="w-16 h-10 bg-teal-50 text-teal-600 rounded-xl flex items-center justify-center font-bold text-lg">
                    📈
                </div>
            </div>

            <!-- New Orders Card -->
            <div class="bg-white border rounded-2xl p-6 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">New Orders</span>
                    <span class="text-2xl font-black text-slate-900">{{ $totalOrdersCount }}</span>
                </div>
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-600 text-lg">
                    🛒
                </div>
            </div>

            <!-- Pending Quotations Card -->
            <div class="bg-white border rounded-2xl p-6 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Pending Quotations</span>
                    <span class="text-2xl font-black text-slate-900">{{ $pendingQuotationsCount }}</span>
                </div>
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-600 text-lg">
                    📄
                </div>
            </div>

            <!-- Professional Verifications Card -->
            <div class="bg-white border rounded-2xl p-6 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Professional Verifications Pending</span>
                    <span class="text-2xl font-black text-slate-900">{{ \App\Models\User::where('role', 'professional')->where('is_gst_verified', false)->count() }}</span>
                </div>
                <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center text-slate-600 text-lg">
                    👤
                </div>
            </div>
        </div>

        <!-- Product CRUD & Quotations Manager Row -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Product CRUD Interface Card (2/3 width) -->
            <div class="lg:col-span-2 bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-6">
                <div class="flex justify-between items-center border-b pb-4">
                    <h3 class="font-extrabold text-slate-800 text-lg">Product CRUD Interface (Manage Products)</h3>
                    <a href="{{ route('admin.products.create') }}" class="bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition">Add New Product</a>
                </div>

                <!-- Product search / filters mockup -->
                <div class="flex gap-2 flex-wrap text-xs">
                    <input type="text" placeholder="Search..." class="border border-slate-200 rounded-lg px-3 py-1.5 w-40 text-xs">
                    <select class="border border-slate-200 rounded-lg p-1.5 text-[10px] w-24"><option>Brand</option></select>
                    <select class="border border-slate-200 rounded-lg p-1.5 text-[10px] w-24"><option>Category</option></select>
                    <select class="border border-slate-200 rounded-lg p-1.5 text-[10px] w-24"><option>Room</option></select>
                </div>

                <!-- Product Table -->
                <div class="overflow-x-auto text-[11px] font-semibold text-slate-600">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-slate-50 text-slate-400">
                                <th class="py-2.5 px-4">Product</th>
                                <th class="py-2.5 px-4">SKU</th>
                                <th class="py-2.5 px-4">Stock</th>
                                <th class="py-2.5 px-4">Price</th>
                                <th class="py-2.5 px-4">Active Variant</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Product::take(5)->get() as $p)
                                <tr class="border-b hover:bg-slate-50/50 transition">
                                    <td class="py-3 px-4 font-extrabold text-slate-800">{{ $p->name }}</td>
                                    <td class="py-3 px-4 font-mono">{{ $p->sku }}</td>
                                    <td class="py-3 px-4">{{ $p->stock }}</td>
                                    <td class="py-3 px-4 text-teal-700">₹{{ $p->price }}/sq.ft.</td>
                                    <td class="py-3 px-4">1</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right: Quotations Manager focus card (1/3 width) -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-6">
                <div class="border-b pb-4">
                    <h3 class="font-extrabold text-slate-800 text-lg">Quotations Manager</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Pending Admin Response</p>
                </div>

                <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2">
                    @foreach($recentQuotations as $quote)
                        <div class="border rounded-xl p-4 space-y-2.5 text-xs">
                            <div class="flex justify-between items-center font-bold">
                                <span class="text-slate-800">Q-{{ 10000 + $quote->id }}</span>
                                <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full text-[9px] tracking-wider uppercase">Pending</span>
                            </div>
                            <div class="text-slate-500 font-semibold space-y-1">
                                <p>Requested: {{ $quote->created_at->format('d/m/Y') }}</p>
                                <p>Customer: {{ $quote->user->name }}</p>
                                <p class="line-clamp-1">Product: {{ $quote->product->name }}</p>
                            </div>
                            <a href="/admin/quotations" class="block w-full bg-teal-600 hover:bg-teal-700 text-white font-bold text-center py-2 rounded-xl text-[10px] shadow-sm transition">Create and Send PDF</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Fulfillment Queue & Order Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Order fulfillment queue (2/3 width) -->
            <div class="lg:col-span-2 bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-6">
                <div class="flex justify-between items-center border-b pb-4">
                    <h3 class="font-extrabold text-slate-800 text-lg">Order Fulfillment Queue</h3>
                    <div class="flex items-center gap-1.5 text-xs text-slate-500">
                        <span>Sort by</span>
                        <select class="border rounded px-2 py-1 text-xs"><option>Pending</option></select>
                    </div>
                </div>

                <div class="overflow-x-auto text-[11px] font-semibold text-slate-600">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-slate-50 text-slate-400">
                                <th class="py-2.5 px-4">by ID</th>
                                <th class="py-2.5 px-4">Customer</th>
                                <th class="py-2.5 px-4">Date</th>
                                <th class="py-2.5 px-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $o)
                                <tr class="border-b hover:bg-slate-50/50 transition">
                                    <td class="py-3 px-4 font-mono font-bold text-slate-800">
                                        <a href="{{ route('admin.orders.show', $o->id) }}" class="text-teal-700 hover:text-teal-900 hover:underline">
                                            {{ $o->order_number }}
                                        </a>
                                    </td>
                                    <td class="py-3 px-4">{{ $o->name }}</td>
                                    <td class="py-3 px-4">{{ $o->created_at->format('d/M/Y') }}</td>
                                    <td class="py-3 px-4">
                                        <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded text-[9px] tracking-wider uppercase font-bold">{{ $o->order_status }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right: Order Details popup card (1/3 width) -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-6">
                <div class="border-b pb-3 flex justify-between items-center">
                    <h3 class="font-extrabold text-slate-800 text-sm">Latest Order Preview</h3>
                    <a href="{{ route('admin.orders') }}" class="text-xs text-teal-600 hover:underline font-bold">View All ➔</a>
                </div>

                @if($recentOrders->count() > 0)
                    @php $firstOrder = $recentOrders->first(); @endphp
                    <div class="space-y-4 text-xs font-semibold text-slate-600">
                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-100 space-y-1 font-mono">
                            <p class="text-slate-900 font-bold text-sm">{{ $firstOrder->order_number }}</p>
                            <p class="text-[10px]">Customer: {{ $firstOrder->name }}</p>
                            <p class="text-[10px]">Payment: {{ strtoupper($firstOrder->payment_method) }}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Product List</p>
                            @foreach($firstOrder->items as $item)
                                <div class="flex justify-between items-center bg-slate-50/50 p-2.5 rounded border">
                                    <span class="text-slate-800 leading-tight font-extrabold">{{ $item->product->name ?? ($item->product_name ?? 'Product #' . $item->product_id) }} <strong class="text-slate-900">x{{ $item->quantity }}</strong></span>
                                    <span class="font-bold text-slate-900">₹{{ number_format($item->total, 0) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-2 flex gap-2">
                            <a href="{{ route('admin.orders.show', $firstOrder->id) }}" class="flex-1 bg-[#0d2238] hover:bg-slate-800 text-white text-center py-2 rounded-xl text-[11px] font-bold transition">
                                View Details
                            </a>
                            <a href="{{ route('admin.orders.invoice', $firstOrder->id) }}" target="_blank" class="bg-amber-50 border border-amber-300 text-amber-900 hover:bg-amber-100 text-center px-3 py-2 rounded-xl text-[11px] font-bold transition">
                                🖨️ Invoice
                            </a>
                        </div>
                    </div>
                @else
                    <p class="text-slate-400 text-xs py-4 text-center">No orders found.</p>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
