<x-admin-layout>
    <x-slot name="title">Manage Products - Admin Dashboard</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200/80 pb-6">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-teal-100 text-teal-800 border border-teal-200">Catalog Engine</span>
                    <span class="text-xs font-semibold text-slate-400">&bull; {{ $products->count() }} Items</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Products Inventory</h1>
                <p class="text-slate-500 text-xs mt-1">Manage tiles, sanitaryware, faucets, prices, and spec variants in real-time.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.products.import.form') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs px-5 py-3 rounded-2xl shadow-lg shadow-slate-900/10 hover:shadow-slate-900/20 transition-all flex items-center gap-2 group">
                    <div class="w-5 h-5 bg-teal-500/20 text-teal-400 rounded-lg flex items-center justify-center group-hover:scale-110 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </div>
                    <span>Bulk Import (CSV)</span>
                </a>
                
                <a href="{{ route('admin.products.create') }}" class="bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-700 hover:to-emerald-700 text-white font-bold text-xs px-5 py-3 rounded-2xl shadow-lg shadow-teal-600/20 transition-all flex items-center gap-2 group">
                    <svg class="w-4 h-4 group-hover:rotate-90 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    <span>Add New Product</span>
                </a>
            </div>
        </div>

        {{-- Flash Feedback Banner --}}
        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-900 p-4 rounded-2xl flex items-center gap-3 shadow-sm text-xs font-bold">
                <div class="w-7 h-7 bg-emerald-500 text-white rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Analytics & Summary Stat Widgets --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Stat 1 --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Products</span>
                    <div class="w-10 h-10 bg-teal-50 text-teal-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ number_format($products->count()) }}</span>
                    <span class="text-[11px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Active</span>
                </div>
            </div>

            {{-- Stat 2 --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">In Stock Items</span>
                    <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ number_format($products->where('stock', '>', 0)->count()) }}</span>
                    <span class="text-[11px] font-bold text-slate-500">Ready to ship</span>
                </div>
            </div>

            {{-- Stat 3 --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Featured Items</span>
                    <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">{{ number_format($products->where('is_featured', true)->count()) }}</span>
                    <span class="text-[11px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">Homepage</span>
                </div>
            </div>

            {{-- Stat 4 --}}
            <div class="bg-white border border-slate-200/80 rounded-3xl p-5 shadow-sm hover:shadow-md transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Avg Price / Sq.ft</span>
                    <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-3xl font-black text-slate-900">₹{{ number_format($products->avg('price') ?: 0, 1) }}</span>
                    <span class="text-[11px] font-bold text-slate-500">per sq.ft</span>
                </div>
            </div>
        </div>

        {{-- Main Table Container --}}
        <div class="bg-white border border-slate-200/80 rounded-3xl overflow-hidden shadow-sm">
            
            {{-- Search & Filter Toolbar --}}
            <div class="p-5 bg-slate-50/50 border-b border-slate-200/80 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="relative w-full md:w-96">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" id="adminProductSearch" placeholder="Search product name, SKU, category..." class="w-full bg-white border border-slate-200 pl-10 pr-4 py-2.5 rounded-xl text-xs font-semibold focus:border-teal-500 focus:ring-0 shadow-sm">
                </div>
                
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-500">
                    <span>Showing <strong class="text-slate-900" id="visibleRowCount">{{ $products->count() }}</strong> items</span>
                </div>
            </div>

            @if($products->isEmpty())
                <div class="py-16 text-center space-y-4">
                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-3xl flex items-center justify-center mx-auto">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <p class="text-slate-500 text-sm font-semibold">No products found in the inventory database.</p>
                    <div class="flex justify-center gap-3">
                        <a href="{{ route('admin.products.import.form') }}" class="bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition">Bulk Import (CSV)</a>
                        <a href="{{ route('admin.products.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition">+ Add Product</a>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse" id="adminProductsTable">
                        <thead>
                            <tr class="border-b border-slate-200 bg-slate-100/60 text-slate-500 font-extrabold text-[11px] uppercase tracking-wider">
                                <th class="py-4 px-6">Product Details</th>
                                <th class="py-4 px-6">SKU</th>
                                <th class="py-4 px-6">Category &amp; Room</th>
                                <th class="py-4 px-6">Pricing &amp; Stock</th>
                                <th class="py-4 px-6">Specifications</th>
                                <th class="py-4 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @foreach($products as $prod)
                                <tr class="hover:bg-teal-50/20 transition group search-target-row">
                                    {{-- Product Name & Image --}}
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-xl border border-slate-200 bg-slate-50 p-1 flex-shrink-0 relative overflow-hidden group-hover:scale-105 transition">
                                                <img src="{{ asset($prod->featured_image) }}" alt="img" class="w-full h-full object-contain">
                                            </div>
                                            <div>
                                                <a href="{{ route('admin.products.edit', $prod->id) }}" class="font-extrabold text-slate-900 hover:text-teal-600 text-sm block leading-tight transition">
                                                    {{ $prod->name }}
                                                </a>
                                                <div class="flex items-center gap-1.5 mt-1">
                                                    @if($prod->is_featured)
                                                        <span class="bg-amber-100 text-amber-800 text-[9px] font-bold px-2 py-0.5 rounded-md">⭐ Featured</span>
                                                    @endif
                                                    @if($prod->collection)
                                                        <span class="bg-slate-100 text-slate-600 text-[9px] font-bold px-2 py-0.5 rounded-md">{{ $prod->collection }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- SKU --}}
                                    <td class="py-4 px-6">
                                        <span class="font-mono font-bold text-slate-700 bg-slate-100 px-2.5 py-1 rounded-lg border border-slate-200/80 text-[11px] inline-block">
                                            {{ $prod->sku }}
                                        </span>
                                    </td>

                                    {{-- Category & Room --}}
                                    <td class="py-4 px-6 space-y-0.5">
                                        <span class="block font-bold text-slate-800 text-xs">{{ $prod->category->name ?? 'General Tiles' }}</span>
                                        <span class="inline-block text-[10px] font-semibold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md">{{ $prod->room->name ?? 'General' }}</span>
                                    </td>

                                    {{-- Price & Stock --}}
                                    <td class="py-4 px-6 space-y-1">
                                        <div class="flex items-baseline gap-1.5">
                                            <span class="font-black text-slate-900 text-sm">₹{{ number_format($prod->price, 2) }}</span>
                                            <span class="text-[10px] text-slate-400 font-semibold">/ sq.ft</span>
                                        </div>
                                        @if($prod->price_per_box > 0)
                                            <p class="text-[10px] text-slate-500 font-semibold">₹{{ number_format($prod->price_per_box, 0) }} / box</p>
                                        @endif
                                        <div class="pt-0.5">
                                            @if($prod->stock > 20)
                                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full inline-flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Stock: {{ $prod->stock }}
                                                </span>
                                            @elseif($prod->stock > 0)
                                                <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded-full inline-flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600"></span> Low Stock: {{ $prod->stock }}
                                                </span>
                                            @else
                                                <span class="bg-red-100 text-red-800 text-[10px] font-bold px-2 py-0.5 rounded-full inline-flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> Out of stock
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Specs --}}
                                    <td class="py-4 px-6 text-[11px] text-slate-500 space-y-1 font-semibold">
                                        <p><strong class="text-slate-700">Size:</strong> {{ $prod->size ?: '600x1200mm' }}</p>
                                        <p><strong class="text-slate-700">Finish:</strong> {{ $prod->finish ?: 'Glossy' }}</p>
                                        <p><strong class="text-slate-700">Type:</strong> {{ $prod->sub_category ?: 'GVT Tile' }}</p>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex justify-end items-center gap-2">
                                            <a href="{{ route('admin.products.edit', $prod->id) }}" class="bg-slate-100 hover:bg-teal-600 hover:text-white text-slate-700 font-bold px-3 py-1.5 rounded-xl transition shadow-xs flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                <span>Edit</span>
                                            </a>
                                            <form action="{{ route('admin.products.delete', $prod->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ addslashes($prod->name) }}?');">
                                                @csrf
                                                <button type="submit" class="bg-red-50 hover:bg-red-600 hover:text-white text-red-600 font-bold px-3 py-1.5 rounded-xl transition shadow-xs flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    <span>Delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- Live Search Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('adminProductSearch');
            const rows = document.querySelectorAll('.search-target-row');
            const countDisplay = document.getElementById('visibleRowCount');

            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const term = e.target.value.toLowerCase().trim();
                    let visible = 0;

                    rows.forEach(row => {
                        const text = row.innerText.toLowerCase();
                        if (text.includes(term)) {
                            row.style.display = '';
                            visible++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    if (countDisplay) countDisplay.textContent = visible;
                });
            }
        });
    </script>
</x-admin-layout>
