<x-admin-layout>
    <x-slot name="title">Manage Users - Admin</x-slot>

    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Top Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <nav class="flex text-slate-400 text-xs gap-1.5 items-center mb-1">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-teal-600">Admin</a>
                    <span>/</span>
                    <span class="text-slate-700 font-semibold">Users</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Registered Users</h1>
                <p class="text-xs text-slate-500 mt-0.5">Manage all registered users, including B2B professionals and admins.</p>
            </div>
        </div>

        <!-- Users Table -->
        <div class="bg-white border border-slate-200/80 rounded-2xl overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-wider">
                            <th class="py-4 px-6">Name</th>
                            <th class="py-4 px-6">Contact</th>
                            <th class="py-4 px-6">Role</th>
                            <th class="py-4 px-6">Company/GST</th>
                            <th class="py-4 px-6">Joined Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs text-slate-700 font-medium">
                        @forelse($users as $user)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900">{{ $user->name }}</div>
                                    <div class="text-[10px] text-slate-400">ID: {{ $user->id }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-slate-900">{{ $user->email }}</div>
                                    @if($user->phone)
                                        <div class="text-[10px] text-slate-500">{{ $user->phone }}</div>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($user->role == 'admin')
                                        <span class="bg-rose-100 text-rose-800 px-2.5 py-1 rounded-md text-[10px] font-bold">Admin</span>
                                    @elseif($user->role == 'professional')
                                        <span class="bg-indigo-100 text-indigo-800 px-2.5 py-1 rounded-md text-[10px] font-bold">Professional (B2B)</span>
                                    @else
                                        <span class="bg-slate-100 text-slate-800 px-2.5 py-1 rounded-md text-[10px] font-bold">Homeowner</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    @if($user->company_name)
                                        <div class="font-bold text-slate-900">{{ $user->company_name }}</div>
                                        @if($user->gst_number)
                                            <div class="text-[10px] text-slate-500">GST: {{ $user->gst_number }}</div>
                                        @endif
                                    @else
                                        <span class="text-slate-300">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-slate-500">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 px-6 text-center text-slate-400 font-medium">
                                    No users found in the system.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($users->hasPages())
                <div class="p-4 border-t border-slate-100 bg-slate-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
