<x-admin-layout>
    <x-slot name="title">Quotation #{{ $quote->quote_number }} - Pristo Admin</x-slot>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Navigation -->
        <nav class="flex text-slate-400 text-xs gap-1.5 items-center mb-4">
            <a href="/admin/dashboard" class="hover:text-teal-600">Admin</a>
            <span>/</span>
            <a href="{{ route('admin.ai-quotes.index') }}" class="hover:text-teal-600">AI Quotations</a>
            <span>/</span>
            <span class="text-slate-700 font-medium">#{{ $quote->quote_number }}</span>
        </nav>

        <!-- Top Header & Status -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Quotation #{{ $quote->quote_number }}</h1>
                    @if($quote->status === 'draft_pending')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                            Draft - Pending Review
                        </span>
                    @elseif($quote->status === 'approved')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-teal-100 text-teal-800 border border-teal-200">
                            Approved & Ready to Send
                        </span>
                    @elseif($quote->status === 'sent')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 border border-indigo-200">
                            Dispatched to Customer
                        </span>
                    @elseif($quote->status === 'rejected')
                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200">
                            Rejected
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 mt-1">
                    Generated via <strong>{{ ucfirst($quote->channel) }} AI Sales Assistant</strong> on {{ $quote->created_at->format('d M Y, h:i A') }}
                </p>
            </div>

            <!-- Back Action -->
            <a href="{{ route('admin.ai-quotes.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-3.5 py-2 rounded-xl transition shadow-sm">
                ← Back to Quotations
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 p-4 rounded-xl bg-sky-50 border border-sky-200 text-sky-800 text-xs font-medium">
                {{ session('info') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-medium">
                {{ session('warning') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-medium">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
            <!-- Left 2 Cols: Items & Pricing Form -->
            <div class="lg:col-span-2 space-y-6">
                <form action="{{ route('admin.ai-quotes.approve', $quote->id) }}" method="POST">
                    @csrf
                    
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700">Line Items & Pricing</h2>
                            <span class="text-[11px] text-slate-500">Unit prices can be adjusted before approval</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-xs text-left border-collapse">
                                <thead>
                                    <tr class="border-b bg-slate-50/50 text-slate-500 font-semibold uppercase text-[10px]">
                                        <th class="py-3 px-5">Product</th>
                                        <th class="py-3 px-5">Unit Type</th>
                                        <th class="py-3 px-5">Quantity</th>
                                        <th class="py-3 px-5">Unit Price (₹)</th>
                                        <th class="py-3 px-5 text-right">Total Price (₹)</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($quote->items as $item)
                                        <tr class="hover:bg-slate-50/40 transition">
                                            <td class="py-3.5 px-5">
                                                <div class="font-bold text-slate-800">{{ $item->product_name }}</div>
                                                <div class="text-[11px] text-slate-400">SKU: {{ $item->sku }} | GST: {{ $item->gst_percent }}%</div>
                                            </td>
                                            <td class="py-3.5 px-5 text-slate-600 font-medium">
                                                {{ ucfirst($item->unit_type) }}
                                            </td>
                                            <td class="py-3.5 px-5 font-bold text-slate-800">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="py-3.5 px-5">
                                                @if($quote->status === 'draft_pending')
                                                    <div class="relative w-28">
                                                        <span class="absolute left-2.5 top-2 text-slate-400 font-medium">₹</span>
                                                        <input type="number" step="0.01" min="0" 
                                                               name="item_prices[{{ $item->id }}]" 
                                                               value="{{ $item->unit_price }}" 
                                                               class="w-full pl-6 pr-2 py-1.5 border border-slate-300 rounded-lg text-xs font-bold text-slate-800 focus:border-teal-500 focus:ring-0">
                                                    </div>
                                                @else
                                                    <span class="font-bold text-slate-800">₹{{ number_format($item->unit_price, 2) }}</span>
                                                @endif
                                            </td>
                                            <td class="py-3.5 px-5 text-right font-extrabold text-slate-900">
                                                ₹{{ number_format($item->total_price, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Totals Breakdown -->
                        <div class="p-6 bg-slate-50/70 border-t border-slate-100 flex flex-col items-end space-y-2">
                            <div class="flex justify-between w-64 text-xs text-slate-600">
                                <span>Subtotal:</span>
                                <span class="font-bold text-slate-800">₹{{ number_format($quote->subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between w-64 text-xs text-slate-600">
                                <span>Estimated GST (included):</span>
                                <span class="font-medium text-slate-700">₹{{ number_format($quote->tax_total, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center w-64 text-xs text-slate-600">
                                <span>Discount:</span>
                                @if($quote->status === 'draft_pending')
                                    <div class="relative w-28">
                                        <span class="absolute left-2.5 top-1.5 text-slate-400 font-medium">₹</span>
                                        <input type="number" step="0.01" min="0" name="discount_total" value="{{ $quote->discount_total }}" 
                                               class="w-full pl-6 pr-2 py-1 border border-slate-300 rounded-lg text-xs font-bold text-slate-800 focus:border-teal-500 focus:ring-0">
                                    </div>
                                @else
                                    <span class="font-bold text-rose-600">-₹{{ number_format($quote->discount_total, 2) }}</span>
                                @endif
                            </div>
                            <div class="flex justify-between w-64 pt-2 border-t border-slate-200 text-sm font-black text-slate-900">
                                <span>Grand Total:</span>
                                <span class="text-teal-700">₹{{ number_format($quote->grand_total, 2) }}</span>
                            </div>
                        </div>

                        <!-- Notes & Approval Submission -->
                        @if($quote->status === 'draft_pending')
                            <div class="p-6 border-t border-slate-100 bg-white space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 mb-1">Staff Authorization Remarks (Optional)</label>
                                    <textarea name="admin_notes" rows="2" placeholder="e.g. Special 5% contractor discount applied; valid for 7 days."
                                              class="w-full p-2.5 border border-slate-300 rounded-xl text-xs focus:border-teal-500 focus:ring-0">{{ $quote->admin_notes }}</textarea>
                                </div>
                                <div class="flex items-center justify-end gap-3">
                                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs shadow-sm transition">
                                        ✓ Approve & Finalize Pricing
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </form>

                <!-- Action: Official Send Button (Strictly Enforced: Only after Approval) -->
                @if($quote->status === 'approved')
                    <div class="bg-gradient-to-r from-teal-50 to-emerald-50 border border-teal-200 rounded-2xl p-6 shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h3 class="text-sm font-extrabold text-teal-900">Authorized & Ready for Customer Dispatch</h3>
                                <p class="text-xs text-teal-700 mt-0.5">Approved by {{ $quote->approvedBy->name ?? 'Admin Staff' }} on {{ $quote->approved_at?->format('d M Y, h:i A') }}.</p>
                            </div>
                            <form action="{{ route('admin.ai-quotes.send', $quote->id) }}" method="POST" onsubmit="return confirm('Officially dispatch this quotation to {{ $quote->customer_name }} ({{ $quote->customer_phone }})?');">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs shadow-md transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                    Send Officially to {{ ucfirst($quote->channel) }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Action: Reject Form -->
                @if($quote->status === 'draft_pending')
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-rose-700 mb-2">Reject Quotation</h3>
                        <form action="{{ route('admin.ai-quotes.reject', $quote->id) }}" method="POST">
                            @csrf
                            <div class="space-y-3">
                                <textarea name="rejection_reason" rows="2" required placeholder="Specify reason for rejecting this quotation request (e.g. out of service area, discontinued item, duplicate)..."
                                          class="w-full p-2.5 border border-slate-300 rounded-xl text-xs focus:border-rose-500 focus:ring-0"></textarea>
                                <div class="text-right">
                                    <button type="submit" class="px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-sm transition">
                                        Reject Draft
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Right Col: Customer & Audit Info -->
            <div class="space-y-6">
                <!-- Customer Card -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 border-b border-slate-100 pb-2">Customer Profile</h2>
                    
                    <div class="space-y-2 text-xs">
                        <div>
                            <span class="text-slate-400 block text-[11px]">Full Name:</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $quote->customer_name }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[11px]">Phone / WhatsApp:</span>
                            <span class="font-bold text-teal-600">{{ $quote->customer_phone }}</span>
                        </div>
                        @if($quote->customer_email)
                            <div>
                                <span class="text-slate-400 block text-[11px]">Email:</span>
                                <span class="font-medium text-slate-700">{{ $quote->customer_email }}</span>
                            </div>
                        @endif
                        <div>
                            <span class="text-slate-400 block text-[11px]">Customer Classification:</span>
                            <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-100 text-slate-700">
                                {{ $quote->customer_type }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Destination -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 border-b border-slate-100 pb-2">Delivery Destination</h2>
                    
                    <div class="text-xs space-y-1.5">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 font-bold text-[11px] border border-emerald-200">
                                PIN: {{ $quote->pincode }} (Bangalore)
                            </span>
                        </div>
                        <p class="text-slate-600 leading-relaxed whitespace-pre-line bg-slate-50 p-3 rounded-xl border border-slate-100">
                            {{ $quote->delivery_address }}
                        </p>
                    </div>

                    @if($quote->customer_notes)
                        <div class="pt-2 text-xs">
                            <span class="text-slate-400 block text-[11px] font-semibold">Customer Requirements & Notes:</span>
                            <p class="text-slate-600 mt-1 italic bg-amber-50/50 p-2.5 rounded-lg border border-amber-100">
                                "{{ $quote->customer_notes }}"
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Audit Log Card -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-3">
                    <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 border-b border-slate-100 pb-2">Audit & Traceability</h2>
                    
                    <div class="text-xs space-y-2 text-slate-600">
                        <div>
                            <span class="text-slate-400 block text-[11px]">Created At:</span>
                            <span class="font-medium">{{ $quote->created_at->format('d M Y, h:i:s A') }}</span>
                        </div>
                        @if($quote->approved_at)
                            <div>
                                <span class="text-slate-400 block text-[11px]">Reviewed / Actioned By:</span>
                                <span class="font-bold text-slate-800">{{ $quote->approvedBy->name ?? 'Admin #' . $quote->approved_by_user_id }}</span>
                                <span class="text-slate-400 block text-[10px]">{{ $quote->approved_at->format('d M Y, h:i:s A') }}</span>
                            </div>
                        @endif
                        @if($quote->admin_notes)
                            <div>
                                <span class="text-slate-400 block text-[11px]">Admin Remarks:</span>
                                <span class="text-slate-700 block bg-slate-50 p-2 rounded border border-slate-100">{{ $quote->admin_notes }}</span>
                            </div>
                        @endif
                        @if($quote->rejection_reason)
                            <div>
                                <span class="text-rose-500 block text-[11px] font-bold">Rejection Reason:</span>
                                <span class="text-rose-700 block bg-rose-50 p-2 rounded border border-rose-100">{{ $quote->rejection_reason }}</span>
                            </div>
                        @endif
                        @if($quote->dispatch_status)
                            <div>
                                <span class="text-slate-400 block text-[11px]">Dispatch Tracking Status:</span>
                                <span class="font-bold text-slate-800">{{ $quote->dispatch_status }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
