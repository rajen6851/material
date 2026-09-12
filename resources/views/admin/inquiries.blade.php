<x-admin-layout>
    <x-slot name="title">Contact Inquiries - Pristo Admin</x-slot>

    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Top Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <nav class="flex text-slate-400 text-xs gap-1.5 items-center mb-1">
                    <a href="/admin/dashboard" class="hover:text-teal-600">Admin</a>
                    <span>/</span>
                    <span class="text-slate-700 font-semibold">Client Inquiries</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Contact &amp; Trade Inquiries</h1>
                <p class="text-xs text-slate-500 mt-0.5">Review and respond to messages submitted via the Contact Us page and architectural trade desks.</p>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-xs bg-amber-100 text-amber-900 border border-amber-300 font-bold px-3 py-1 rounded-full">
                    {{ $unreadCount }} Unread
                </span>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl text-emerald-800 text-xs font-semibold shadow-xs">
                {{ session('success') }}
            </div>
        @endif

        <!-- Inquiries Table -->
        <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-xs">
            @if($inquiries->isEmpty())
                <div class="text-center py-20 space-y-3">
                    <span class="text-4xl">✉️</span>
                    <h3 class="text-base font-bold text-slate-800">No Inquiries Found</h3>
                    <p class="text-xs text-slate-400">All customer inquiries will be listed here.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-50 text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                                <th class="py-4 px-5">Date &amp; Sender</th>
                                <th class="py-4 px-5">Inquiry Type</th>
                                <th class="py-4 px-5">Subject &amp; Message</th>
                                <th class="py-4 px-5">Status</th>
                                <th class="py-4 px-5 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($inquiries as $inq)
                                <tr class="hover:bg-slate-50/70 transition align-top">
                                    <td class="py-4 px-5 space-y-1">
                                        <span class="font-bold text-slate-900 text-sm block">{{ $inq->name }}</span>
                                        <span class="text-slate-500 block">📞 <a href="tel:{{ $inq->phone }}" class="text-teal-600 hover:underline">{{ $inq->phone }}</a></span>
                                        <span class="text-slate-400 block">✉️ <a href="mailto:{{ $inq->email }}" class="hover:underline">{{ $inq->email }}</a></span>
                                        <span class="text-[10px] text-slate-400 block">{{ $inq->created_at->format('d M Y, h:i A') }}</span>
                                    </td>

                                    <td class="py-4 px-5">
                                        <span class="inline-block bg-slate-100 text-slate-800 text-[10px] font-bold px-2.5 py-1 rounded-md border border-slate-200 uppercase">
                                            {{ $inq->inquiry_type }}
                                        </span>
                                    </td>

                                    <td class="py-4 px-5 space-y-1.5 max-w-md">
                                        @if($inq->subject)
                                            <span class="font-bold text-slate-900 block text-xs">{{ $inq->subject }}</span>
                                        @endif
                                        <div class="text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100 whitespace-pre-line text-xs">
                                            {{ $inq->message }}
                                        </div>
                                    </td>

                                    <td class="py-4 px-5">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                            {{ $inq->status === 'unread' ? 'bg-amber-100 text-amber-900 border border-amber-300' : '' }}
                                            {{ $inq->status === 'replied' ? 'bg-emerald-100 text-emerald-900 border border-emerald-300' : '' }}
                                            {{ $inq->status === 'closed' ? 'bg-slate-100 text-slate-600 border border-slate-200' : '' }}
                                        ">
                                            {{ ucfirst($inq->status) }}
                                        </span>
                                    </td>

                                    <td class="py-4 px-5 text-right whitespace-nowrap">
                                        <form action="{{ route('admin.inquiries.status', $inq->id) }}" method="POST" class="inline-flex items-center gap-1.5">
                                            @csrf
                                            <select name="status" onchange="this.form.submit()" class="text-[11px] font-bold rounded-lg border-slate-300 p-1">
                                                <option value="unread" {{ $inq->status === 'unread' ? 'selected' : '' }}>Unread</option>
                                                <option value="replied" {{ $inq->status === 'replied' ? 'selected' : '' }}>Replied</option>
                                                <option value="closed" {{ $inq->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($inquiries->hasPages())
                    <div class="p-4 border-t border-slate-200">
                        {{ $inquiries->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-admin-layout>
