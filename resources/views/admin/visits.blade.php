<x-admin-layout>
    <x-slot name="title">Manage Showroom Visits - MaterialDeck Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Breadcrumb & Header -->
        <nav class="flex text-slate-400 text-xs gap-1.5 items-center mb-4">
            <a href="/admin/dashboard" class="hover:text-teal-600">Admin</a>
            <span>/</span>
            <span class="text-slate-700">Visits</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-slate-900 mb-10">Manage Showroom Bookings</h1>

        <!-- Visits Table -->
        <div class="bg-white border rounded-2xl overflow-hidden shadow-sm">
            @if($visits->isEmpty())
                <div class="text-center py-16">
                    <p class="text-slate-400 text-sm">No showroom bookings found.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-slate-50 text-slate-500 font-semibold uppercase text-xs">
                                <th class="py-4 px-6">Visitor Details</th>
                                <th class="py-4 px-6">Scheduled Date &amp; Time</th>
                                <th class="py-4 px-6">Status Decision</th>
                                <th class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($visits as $visit)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <!-- Visitor Details -->
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-slate-800 text-sm block">{{ $visit->name }}</span>
                                        <span class="text-xs text-slate-500 block">Mobile: {{ $visit->mobile }}</span>
                                        <span class="text-[10px] {{ $visit->role === 'professional' ? 'bg-indigo-50 text-indigo-700' : 'bg-teal-50 text-teal-700' }} px-1.5 py-0.5 rounded-full mt-1 inline-block capitalize">{{ $visit->role }}</span>
                                        @if($visit->purpose)
                                            <span class="text-[10px] bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded mt-1 inline-block">Purpose: {{ ucwords(str_replace('_', ' ', $visit->purpose)) }}</span>
                                        @endif
                                        @if($visit->user)
                                            <span class="text-[10px] bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded font-mono mt-1 inline-block">Registered User: {{ $visit->user->email }}</span>
                                        @else
                                            <span class="text-[10px] bg-amber-50 text-amber-700 px-1.5 py-0.5 rounded font-mono mt-1 inline-block">Guest Visitor</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Date & Time -->
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-slate-900 block">{{ $visit->visit_date->format('M d, Y') }}</span>
                                        <span class="text-xs text-slate-500 block">Slot: {{ $visit->visit_time }}</span>
                                    </td>

                                    <!-- Status modifier form -->
                                    <form action="{{ route('admin.visits.status', $visit->id) }}" method="POST">
                                        @csrf
                                        <td class="py-4 px-6">
                                            <select name="status" class="text-xs font-semibold border-slate-300 rounded-lg p-1.5 focus:border-teal-500 focus:ring-0 w-36">
                                                <option value="pending" {{ $visit->status === 'pending' ? 'selected' : '' }}>Pending Confirmation</option>
                                                <option value="confirmed" {{ $visit->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="completed" {{ $visit->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ $visit->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </td>
                                        
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
