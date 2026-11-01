<x-admin-layout>
    <x-slot name="title">Bathroom Packages & Configurations - Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
        <!-- Top Title & Action Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-3">
                    <span>📦 Bathroom Packages &amp; Combos</span>
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    Manage multi-item bathroom configurations (Basin, WC, Shower areas) as seen in brand brochures (e.g. CERA Configurations).
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('packages.index') }}" target="_blank" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-4 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span>View Public Page</span>
                </a>
                <a href="{{ route('admin.packages.create') }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Add New Package</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-center justify-between gap-4">
            <form action="{{ route('admin.packages.index') }}" method="GET" class="w-full md:w-auto flex flex-wrap items-center gap-3">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, tagline..." class="border border-slate-300 focus:border-teal-500 rounded-xl px-4 py-2 text-xs w-64">
                
                <select name="brand_id" class="border border-slate-300 focus:border-teal-500 rounded-xl px-3 py-2 text-xs">
                    <option value="">All Brands</option>
                    @foreach($brands as $b)
                        <option value="{{ $b->id }}" {{ request('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>

                <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold px-4 py-2 rounded-xl transition">
                    Filter
                </button>
                @if(request('search') || request('brand_id'))
                    <a href="{{ route('admin.packages.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">Clear</a>
                @endif
            </form>

            <span class="text-xs text-slate-500">Total: <strong>{{ $packages->total() }}</strong> packages</span>
        </div>

        <!-- Packages Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600">
                    <thead class="bg-slate-50 text-slate-700 uppercase font-bold text-[11px] tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3.5 px-4">Order</th>
                            <th class="py-3.5 px-4">Package</th>
                            <th class="py-3.5 px-4">Brand</th>
                            <th class="py-3.5 px-4">Area Items</th>
                            <th class="py-3.5 px-4">Package Price</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($packages as $pkg)
                            @php
                                $grouped = $pkg->items->groupBy('area');
                            @endphp
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-4 px-4 font-bold text-slate-400">#{{ $pkg->sort_order }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        @if($pkg->image)
                                            <img src="{{ asset($pkg->image) }}" alt="{{ $pkg->name }}" class="w-12 h-12 rounded-lg object-cover border border-slate-200 bg-slate-50">
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center font-bold border border-teal-100 text-xs">
                                                PKG
                                            </div>
                                        @endif
                                        <div>
                                            <span class="font-extrabold text-slate-900 text-sm block">{{ $pkg->name }}</span>
                                            @if($pkg->tagline)
                                                <span class="text-[11px] text-slate-400">{{ Str::limit($pkg->tagline, 45) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    @if($pkg->brand)
                                        <span class="bg-indigo-50 text-indigo-700 font-bold px-2.5 py-1 rounded-md text-[11px]">
                                            {{ $pkg->brand->name }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">--</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center gap-1.5 bg-indigo-50 text-indigo-700 font-extrabold px-3 py-1 rounded-full text-xs border border-indigo-100">
                                        <span>📦 {{ $pkg->items->count() }} Products Included</span>
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    @if($pkg->price)
                                        <span class="font-extrabold text-slate-900 text-sm">₹{{ number_format($pkg->price, 2) }}</span>
                                        @php
                                            $dispMrp = $pkg->effective_mrp;
                                            $dispDisc = $pkg->discount_percent;
                                        @endphp
                                        @if($dispMrp && $dispMrp > $pkg->price)
                                            <div class="flex items-center gap-1.5 flex-wrap">
                                                <span class="text-[11px] text-slate-400 line-through">₹{{ number_format($dispMrp, 2) }}</span>
                                                @if($dispDisc > 0)
                                                    <span class="text-[10px] bg-emerald-100 text-emerald-800 font-black px-1.5 py-0.2 rounded">
                                                        {{ $dispDisc }}% OFF
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-slate-400 italic">Custom Quote</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    <form action="{{ route('admin.packages.toggle', $pkg->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-extrabold transition {{ $pkg->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                                            {{ $pkg->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="py-4 px-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.packages.edit', $pkg->id) }}" class="bg-teal-50 hover:bg-teal-100 text-teal-700 font-bold px-3 py-1.5 rounded-lg text-xs transition flex items-center gap-1">
                                            <span>Manage Items / Edit</span>
                                        </a>
                                        <form action="{{ route('admin.packages.destroy', $pkg->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this package configuration?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-rose-500 hover:bg-rose-50 rounded-lg transition" title="Delete Package">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-slate-400">
                                    <svg class="w-12 h-12 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    <p class="text-sm font-semibold text-slate-600">No bathroom packages found.</p>
                                    <p class="text-xs text-slate-400 mt-1">Get started by creating Configuration 1 or other bathroom package combos.</p>
                                    <a href="{{ route('admin.packages.create') }}" class="mt-4 inline-block bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition">
                                        + Create First Package
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($packages->hasPages())
                <div class="p-4 border-t border-slate-200">
                    {{ $packages->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

