<x-app-layout>
    <x-slot name="title">{{ $category->name }} - BuildMart</x-slot>

    <!-- Header Section -->
    <div class="bg-slate-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-slate-400 text-xs gap-1.5 items-center mb-4">
                <a href="/" class="hover:text-teal-400">Home</a>
                <span>/</span>
                <a href="/products" class="hover:text-teal-400">Products</a>
                <span>/</span>
                <span class="text-teal-300">{{ $category->name }}</span>
            </nav>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">{{ $category->name }}</h1>
            <p class="text-slate-400 text-sm mt-2 max-w-xl">Explore subcategories and find the perfect materials under {{ $category->name }}.</p>
            <a href="/products?category={{ $category->slug }}" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white font-bold px-5 py-2.5 rounded-xl text-sm mt-6 shadow-md transition">
                View All {{ $category->name }} Products
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>

    <!-- Main Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($subCategories->isEmpty())
            <div class="bg-white border rounded-2xl p-16 text-center max-w-xl mx-auto shadow-sm">
                <h3 class="text-xl font-bold text-slate-800 mb-2">No Subcategories Yet</h3>
                <p class="text-sm text-slate-500 mb-6">Browse all products available under {{ $category->name }}.</p>
                <a href="/products?category={{ $category->slug }}" class="inline-block bg-teal-600 hover:bg-teal-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition">View All {{ $category->name }} Products</a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($subCategories as $sub)
                    <a href="/products?category={{ $category->slug }}&subcategory={{ $sub->slug }}" class="group bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:border-teal-500 transition duration-300 flex flex-col">
                        <div class="aspect-square bg-slate-50 relative overflow-hidden">
                            @if($sub->image)
                                <img src="{{ asset($sub->image) }}" alt="{{ $sub->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#0f2439] to-[#17324d]">
                                    <span class="text-5xl font-black text-[#2dd4bf]">{{ strtoupper(substr($sub->name, 0, 1)) }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="bg-[#0f2439] text-white py-3 px-2 text-center text-xs font-bold tracking-wide group-hover:bg-[#008080] transition duration-300">
                            {{ $sub->name }}
                        </div>
                        <div class="text-center text-[10px] font-semibold text-slate-400 py-2 border-t border-slate-100">
                            {{ $counts[$sub->name] ?? 0 }} products
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
