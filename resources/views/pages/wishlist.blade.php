<x-app-layout>
    <x-slot name="title">My Wishlist - BuildMart</x-slot>

    <div class="bg-slate-50 py-12 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">My Wishlist</h1>
                    <p class="text-sm text-slate-500 mt-2">Saved products for later.</p>
                </div>
                @if(count($products) > 0)
                <form action="{{ route('wishlist.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-600 font-bold text-sm bg-red-50 px-4 py-2 rounded-xl transition">Clear All</button>
                </form>
                @endif
            </div>

            @if(count($products) == 0)
                <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center shadow-sm">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-2">Your wishlist is empty</h3>
                    <p class="text-slate-500 mb-6 max-w-md mx-auto">Browse our catalog and save your favorite items here.</p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-teal-600 hover:bg-teal-700 text-white font-bold px-8 py-3.5 rounded-xl transition shadow-sm">Browse Products</a>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition group relative">
                            <!-- Remove Button -->
                            <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                                @csrf
                                <button type="submit" class="w-8 h-8 bg-white/90 backdrop-blur rounded-full flex items-center justify-center text-slate-400 hover:text-red-500 shadow-sm transition" title="Remove">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </form>
                            
                            <a href="{{ route('products.show', $product->slug) }}" class="block">
                                <div class="aspect-square bg-slate-50 relative overflow-hidden">
                                    <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-4 group-hover:scale-105 transition duration-500">
                                </div>
                                <div class="p-4">
                                    <h3 class="font-bold text-slate-900 text-sm mb-1 line-clamp-1">{{ $product->name }}</h3>
                                    <div class="font-black text-teal-700">₹{{ number_format(round($product->price)) }}</div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
