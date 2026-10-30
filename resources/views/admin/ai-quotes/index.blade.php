<x-admin-layout>
    <x-slot name="title">AI Quotations Drafts & Approvals - Pristo Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Breadcrumb & Header -->
        <nav class="flex text-slate-400 text-xs gap-1.5 items-center mb-4">
            <a href="/admin/dashboard" class="hover:text-teal-600">Admin</a>
            <span>/</span>
            <span class="text-slate-700 font-medium">AI Quotations</span>
        </nav>
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">AI Sales Quotations</h1>
                <p class="text-xs text-slate-500 mt-1">Review, adjust pricing, authorize and dispatch draft quotations prepared by the AI Sales Agent.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    AI Engine Active
                </span>
            </div>
        </div>

        <!-- Filter Badges -->
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ route('admin.ai-quotes.index', ['status' => 'all']) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition border {{ $status === 'all' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-600 hover:bg-slate-50 border-slate-200' }}">
                All ({{ $counts['all'] }})
            </a>
            <a href="{{ route('admin.ai-quotes.index', ['status' => 'draft_pending']) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition border {{ $status === 'draft_pending' ? 'bg-amber-500 text-white border-amber-500' : 'bg-white text-amber-700 hover:bg-amber-50 border-amber-200' }}">
                Pending Review ({{ $counts['draft_pending'] }})
            </a>
            <a href="{{ route('admin.ai-quotes.index', ['status' => 'approved']) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition border {{ $status === 'approved' ? 'bg-teal-600 text-white border-teal-600' : 'bg-white text-teal-700 hover:bg-teal-50 border-teal-200' }}">
                Approved ({{ $counts['approved'] }})
            </a>
            <a href="{{ route('admin.ai-quotes.index', ['status' => 'sent']) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition border {{ $status === 'sent' ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-indigo-700 hover:bg-indigo-50 border-indigo-200' }}">
                Dispatched ({{ $counts['sent'] }})
            </a>
            <a href="{{ route('admin.ai-quotes.index', ['status' => 'rejected']) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-semibold transition border {{ $status === 'rejected' ? 'bg-rose-600 text-white border-rose-600' : 'bg-white text-rose-700 hover:bg-rose-50 border-rose-200' }}">
                Rejected ({{ $counts['rejected'] }})
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-teal-50 border border-teal-200 text-teal-800 text-xs font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-medium">
                {{ session('warning') }}
            </div>
        @endif

        <!-- Table Container -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
            @if($quotations->isEmpty())
                <div class="text-center py-20">
                    <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-slate-500 font-medium text-sm mt-3">No AI quotation drafts match the current filter.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-slate-50 text-slate-500 font-semibold uppercase tracking-wider text-[11px]">
                                <th class="py-3.5 px-5">Quote Ref & Date</th>
                                <th class="py-3.5 px-5">Customer & Channel</th>
                                <th class="py-3.5 px-5">Items Summary</th>
                                <th class="py-3.5 px-5">Delivery Location</th>
                                <th class="py-3.5 px-5">Estimated Total</th>
                                <th class="py-3.5 px-5">Status</th>
                                <th class="py-3.5 px-5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($quotations as $quote)
                                <tr class="hover:bg-slate-50/60 transition align-top">
                                    <!-- Ref & Date -->
                                    <td class="py-4 px-5 space-y-1">
                                        <a href="{{ route('admin.ai-quotes.show', $quote->id) }}" class="font-bold text-teal-600 hover:text-teal-700 text-sm block">
                                            #{{ $quote->quote_number }}
                                        </a>
                                        <span class="text-slate-400 block">{{ $quote->created_at->format('d M Y, h:i A') }}</span>
                                    </td>

                                    <!-- Customer & Channel -->
                                    <td class="py-4 px-5 space-y-1">
                                        <span class="font-bold text-slate-800 text-sm block">{{ $quote->customer_name }}</span>
                                        <span class="text-slate-500 block">{{ $quote->customer_phone }}</span>
                                        @if($quote->customer_email)
                                            <span class="text-slate-400 block text-[11px]">{{ $quote->customer_email }}</span>
                                        @endif
                                        <div class="pt-1 flex items-center gap-1.5">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold uppercase {{ $quote->channel === 'whatsapp' ? 'bg-emerald-100 text-emerald-800' : 'bg-sky-100 text-sky-800' }}">
                                                {{ $quote->channel }}
                                            </span>
                                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold uppercase bg-slate-100 text-slate-600">
                                                {{ $quote->customer_type }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Items Summary -->
                                    <td class="py-4 px-5 space-y-1 max-w-xs">
                                        <div class="font-semibold text-slate-700">
                                            {{ $quote->items->count() }} line item(s):
                                        </div>
                                        <ul class="text-slate-500 space-y-0.5 text-[11px]">
                                            @foreach($quote->items->take(3) as $item)
                                                <li class="truncate">• {{ $item->quantity }}x {{ $item->product_name }}</li>
                                            @endforeach
                                            @if($quote->items->count() > 3)
                                                <li class="text-slate-400 italic">+{{ $quote->items->count() - 3 }} more...</li>
                                            @endif
                                        </ul>
                                    </td>

                                    <!-- Delivery -->
                                    <td class="py-4 px-5 space-y-1 text-slate-600 max-w-xs">
                                        <span class="font-semibold text-slate-800 block">PIN: {{ $quote->pincode }}</span>
                                        <span class="text-slate-500 text-[11px] line-clamp-2">{{ $quote->delivery_address }}</span>
                                    </td>

                                    <!-- Grand Total -->
                                    <td class="py-4 px-5">
                                        <div class="text-sm font-extrabold text-slate-900">
                                            ₹{{ number_format($quote->grand_total, 2) }}
                                        </div>
                                        <div class="text-[10px] text-slate-400">
                                            Incl. GST ₹{{ number_format($quote->tax_total, 2) }}
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="py-4 px-5">
                                        @if($quote->status === 'draft_pending')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">
                                                Pending Review
                                            </span>
                                        @elseif($quote->status === 'approved')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-teal-100 text-teal-800">
                                                Approved
                                            </span>
                                        @elseif($quote->status === 'sent')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-indigo-100 text-indigo-800">
                                                Dispatched
                                            </span>
                                        @elseif($quote->status === 'rejected')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-800">
                                                Rejected
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-4 px-5 text-right whitespace-nowrap">
                                        <a href="{{ route('admin.ai-quotes.show', $quote->id) }}" 
                                           class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-teal-600 hover:bg-teal-700 shadow-sm transition">
                                            Review & Action
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 border-t border-slate-100">
                    {{ $quotations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
