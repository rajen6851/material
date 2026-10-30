<x-admin-layout>
    <x-slot name="title">Reports & Analytics - Admin Command Center</x-slot>

    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Top Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <nav class="flex text-slate-400 text-xs gap-1.5 items-center mb-1">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-teal-600">Admin</a>
                    <span>/</span>
                    <span class="text-slate-700 font-semibold">Reports & Analytics</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">System Analytics</h1>
                <p class="text-xs text-slate-500 mt-0.5">Key performance indicators, traffic insights, and business metrics.</p>
            </div>
        </div>

                <!-- Key Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Total Revenue -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Revenue</h3>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900">₹{{ number_format($data['total_revenue']) }}</div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Orders</h3>
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900">{{ number_format($data['total_orders']) }}</div>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pending Orders</h3>
                    <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900">{{ number_format($data['pending_orders']) }}</div>
            </div>

            <!-- Total Products -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Products</h3>
                    <div class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900">{{ number_format($data['total_products']) }}</div>
            </div>

            <!-- Total Users -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Users</h3>
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5m10 0H7m5-10a3 3 0 110-6 3 3 0 010 6z"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900">{{ number_format($data['total_users']) }}</div>
            </div>

            <!-- B2B Users -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">B2B Users</h3>
                    <div class="w-8 h-8 rounded-lg bg-cyan-50 text-cyan-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900">{{ number_format($data['b2b_users']) }}</div>
            </div>

            <!-- Quotations -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Quotations</h3>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900">{{ number_format($data['total_quotations']) }}</div>
            </div>

            <!-- Showroom Visits -->
            <div class="bg-white border border-slate-200/80 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Showroom Visits</h3>
                    <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                </div>
                <div class="text-3xl font-black text-slate-900">{{ number_format($data['total_visits']) }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Panel: Recent Orders -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-sm">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider">Recent Orders</h2>
                        <a href="{{ route('admin.orders') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700">View All</a>
                    </div>
                    <div class="p-0">
                        @if($data['recent_orders']->count() > 0)
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-white border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-wider">
                                        <th class="py-3 px-6">Order ID</th>
                                        <th class="py-3 px-6">Date</th>
                                        <th class="py-3 px-6">Total Amount</th>
                                        <th class="py-3 px-6">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 text-xs text-slate-700 font-medium">
                                    @foreach($data['recent_orders'] as $order)
                                        <tr class="hover:bg-slate-50 transition">
                                            <td class="py-4 px-6 font-bold text-slate-900">#{{ $order->order_number }}</td>
                                            <td class="py-4 px-6 text-slate-500">{{ $order->created_at->format('M d, Y') }}</td>
                                            <td class="py-4 px-6 font-black text-slate-900">₹{{ number_format($order->total, 2) }}</td>
                                            <td class="py-4 px-6">
                                                @if($order->order_status == 'pending')
                                                    <span class="bg-amber-100 text-amber-800 px-2.5 py-1 rounded-md text-[10px] font-bold">Pending</span>
                                                @elseif($order->order_status == 'processing')
                                                    <span class="bg-blue-100 text-blue-800 px-2.5 py-1 rounded-md text-[10px] font-bold">Processing</span>
                                                @elseif($order->order_status == 'shipped')
                                                    <span class="bg-indigo-100 text-indigo-800 px-2.5 py-1 rounded-md text-[10px] font-bold">Shipped</span>
                                                @elseif($order->order_status == 'delivered')
                                                    <span class="bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded-md text-[10px] font-bold">Delivered</span>
                                                @else
                                                    <span class="bg-red-100 text-red-800 px-2.5 py-1 rounded-md text-[10px] font-bold">{{ ucfirst($order->order_status) }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-8 text-center text-slate-500 text-sm">
                                No recent orders to display.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Panel: Contact Inquiries Summary -->
            <div class="space-y-6">
                <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm flex flex-col justify-between" style="min-height: 200px;">
                    <div>
                        <h2 class="text-sm font-black text-slate-900 uppercase tracking-wider mb-2">Total Contact Inquiries</h2>
                        <p class="text-xs text-slate-500 mb-6">Inquiries received from the Contact Us page.</p>
                        <div class="flex items-end gap-3">
                            <span class="text-5xl font-black text-slate-900">{{ number_format($data['total_inquiries']) }}</span>
                            <span class="text-sm font-bold text-teal-500 bg-teal-50 px-2 py-1 rounded-lg mb-1">+ All time</span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <a href="/admin/inquiries" class="block w-full text-center bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 rounded-xl transition text-xs">
                            View Inquiries
                        </a>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-teal-900 to-slate-900 border border-teal-800 rounded-2xl p-6 shadow-sm text-white">
                    <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center mb-4">
                        <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                    <h2 class="text-sm font-black uppercase tracking-wider mb-2">More Analytics Coming Soon</h2>
                    <p class="text-xs text-slate-300 leading-relaxed mb-4">
                        We are currently preparing detailed charts and advanced sales metrics for your dashboard.
                    </p>
                    <div class="w-full bg-slate-800 h-1.5 rounded-full overflow-hidden">
                        <div class="bg-teal-400 w-2/3 h-full rounded-full"></div>
                    </div>
                    <p class="text-[10px] text-teal-400 font-bold mt-2 text-right">65% complete</p>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
