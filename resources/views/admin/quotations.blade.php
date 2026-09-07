<x-admin-layout>
    <x-slot name="title">Manage Quotations - MaterialDeck Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Breadcrumb & Header -->
        <nav class="flex text-slate-400 text-xs gap-1.5 items-center mb-4">
            <a href="/admin/dashboard" class="hover:text-teal-600">Admin</a>
            <span>/</span>
            <span class="text-slate-700">Quotations</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-slate-900 mb-10">Manage Quotation Requests</h1>

        <!-- Quotations Table -->
        <div class="bg-white border rounded-2xl overflow-hidden shadow-sm">
            @if($quotations->isEmpty())
                <div class="text-center py-16">
                    <p class="text-slate-400 text-sm">No quotation requests found.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-slate-50 text-slate-500 font-semibold uppercase text-xs">
                                <th class="py-4 px-6">Requester</th>
                                <th class="py-4 px-6">Product Details</th>
                                <th class="py-4 px-6">Delivery Address</th>
                                <th class="py-4 px-6">Proposed Price</th>
                                <th class="py-4 px-6">Status Decision</th>
                                <th class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-xs">
                            @foreach($quotations as $quote)
                                <tr class="hover:bg-slate-50/50 transition align-top">
                                    <!-- Requester Info -->
                                    <td class="py-4 px-6 space-y-1">
                                        <span class="font-bold text-slate-800 text-sm block">{{ $quote->user->name }}</span>
                                        <span class="text-slate-500 block">Email: {{ $quote->user->email }}</span>
                                        <span class="text-slate-500 block">Phone: {{ $quote->user->phone }}</span>
                                        <span class="bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded text-[10px] uppercase font-semibold inline-block">{{ $quote->user->role }}</span>
                                    </td>

                                    <!-- Product Details -->
                                    <td class="py-4 px-6 space-y-1">
                                        <span class="font-semibold text-slate-800 text-sm block">{{ $quote->product->name ?? 'Product #' . $quote->product_id }}</span>
                                        <span class="text-slate-500 block">Required: <strong class="text-slate-800">{{ $quote->quantity }} boxes/units</strong></span>
                                        <span class="text-slate-400 block">Product Price: ₹{{ $quote->product->price ?? 0 }} | MRP: ₹{{ $quote->product->mrp ?? 0 }}</span>
                                        @if($quote->remarks)
                                            <span class="block text-slate-400 bg-slate-50 p-2 rounded border border-slate-100 mt-2"><strong>Notes:</strong> {{ $quote->remarks }}</span>
                                        @endif
                                    </td>

                                    <!-- Address -->
                                    <td class="py-4 px-6 max-w-xs whitespace-pre-line text-slate-500 leading-normal">
                                        {{ $quote->address }}
                                    </td>

                                    <!-- Proposed Price & Decision Form -->
                                    <form action="{{ route('admin.quotations.respond', $quote->id) }}" method="POST">
                                        @csrf
                                        
                                        <!-- Proposed Price -->
                                        <td class="py-4 px-6">
                                            <div class="space-y-2">
                                                <div class="relative">
                                                    <span class="absolute left-2.5 top-2.5 text-slate-400">₹</span>
                                                    <input type="number" name="proposed_price" step="0.01" value="{{ $quote->proposed_price }}" placeholder="Proposed price" class="w-32 pl-6 pr-2 py-1.5 border-slate-300 focus:border-teal-500 focus:ring-0 rounded-lg text-xs font-bold">
                                                </div>
                                                <textarea name="admin_remarks" placeholder="Admin remarks..." rows="2" class="w-32 p-1.5 border-slate-300 focus:border-teal-500 focus:ring-0 rounded-lg text-[10px] leading-snug">{{ $quote->admin_remarks }}</textarea>
                                            </div>
                                        </td>

                                        <!-- Status Decision selection -->
                                        <td class="py-4 px-6">
                                            <select name="status" class="border-slate-300 rounded-lg p-1.5 text-xs font-semibold focus:border-teal-500 focus:ring-0 w-28">
                                                <option value="pending" {{ $quote->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ $quote->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ $quote->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </td>

                                        <!-- Actions -->
                                        <td class="py-4 px-6 text-right">
                                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs px-3.5 py-1.5 rounded-lg shadow-sm transition">
                                                Respond
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
