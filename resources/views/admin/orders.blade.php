<x-admin-layout>
    <x-slot name="title">Manage Orders - MaterialDeck Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Breadcrumb & Header -->
        <nav class="flex text-slate-400 text-xs gap-1.5 items-center mb-4">
            <a href="/admin/dashboard" class="hover:text-teal-600">Admin</a>
            <span>/</span>
            <span class="text-slate-700">Orders</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-slate-900 mb-10">Manage Orders</h1>

        <!-- Orders Table -->
        <div class="bg-white border rounded-2xl overflow-hidden shadow-sm">
            @if($orders->isEmpty())
                <div class="text-center py-16">
                    <p class="text-slate-400 text-sm">No orders found in the database.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-slate-50 text-slate-500 font-semibold uppercase text-xs">
                                <th class="py-4 px-6">Order Info</th>
                                <th class="py-4 px-6">Customer Details</th>
                                <th class="py-4 px-6">Amount</th>
                                <th class="py-4 px-6">Order Status</th>
                                <th class="py-4 px-6">Payment Status</th>
                                <th class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($orders as $order)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <!-- Order Info -->
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-slate-800 font-mono block">{{ $order->order_number }}</span>
                                        <span class="text-xs text-slate-400 block">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                                        <span class="text-[10px] bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded font-mono mt-1 inline-block">{{ strtoupper($order->payment_method) }}</span>
                                    </td>
                                    
                                    <!-- Customer Details -->
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-slate-800 block">{{ $order->name }}</span>
                                        <span class="text-xs text-slate-400 block">{{ $order->email }}</span>
                                        <span class="text-xs text-slate-500 block">Ph: {{ $order->phone }}</span>
                                        @if($order->gst_number)
                                            <span class="text-[10px] bg-indigo-50 text-indigo-700 px-1.5 py-0.5 rounded font-mono mt-1 inline-block">GST: {{ $order->gst_number }}</span>
                                        @endif
                                    </td>

                                    <!-- Amount -->
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-slate-900 block">₹{{ number_format($order->total, 2) }}</span>
                                        <span class="text-[10px] text-slate-400 block">Subtotal: ₹{{ number_format($order->subtotal, 2) }}</span>
                                    </td>

                                    <!-- Status Forms -->
                                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                        @csrf
                                        
                                        <!-- Order Status -->
                                        <td class="py-4 px-6">
                                            <select name="order_status" class="text-xs border-slate-300 rounded-lg p-1.5 focus:border-teal-500 focus:ring-0">
                                                <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="packed" {{ $order->order_status === 'packed' ? 'selected' : '' }}>Packed</option>
                                                <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                                <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                                <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </td>

                                        <!-- Payment Status -->
                                        <td class="py-4 px-6">
                                            <select name="payment_status" class="text-xs border-slate-300 rounded-lg p-1.5 focus:border-teal-500 focus:ring-0">
                                                <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                                                <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                                                <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                                            </select>
                                        </td>

                                        <!-- Submit -->
                                        <td class="py-4 px-6 text-right">
                                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs px-3.5 py-1.5 rounded-lg shadow-sm transition">
                                                Update
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
