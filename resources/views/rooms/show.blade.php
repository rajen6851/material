<x-app-layout>
    <x-slot name="title">{{ $room->name }} Collections & Subcategories - Pristo</x-slot>

    <!-- Room Hero Banner -->
    <div class="bg-[#171615] text-[#f7f4ef] py-12 md:py-16 border-b border-[#2b2825]">
        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-[#a39e97] text-xs gap-2 items-center mb-4">
                <a href="/" class="hover:text-[#c09b5a] transition">Home</a>
                <span>/</span>
                <a href="/products" class="hover:text-[#c09b5a] transition">Spaces</a>
                <span>/</span>
                <span class="text-[#c09b5a] font-semibold">{{ $room->name }}</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-2 max-w-2xl">
                    <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#c09b5a] block">DESIGN YOUR SPACE</span>
                    <h1 class="font-serif-pristo text-3xl sm:text-4xl lg:text-5xl font-bold text-white tracking-tight">
                        {{ $room->name }} Collections
                    </h1>
                    <p class="text-xs sm:text-sm text-[#a39e97] leading-relaxed pt-1">
                        Select a subcategory below to explore complete solutions, luxury fittings, sanitaryware, and architectural surfaces engineered for your {{ strtolower($room->name) }}.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="/products?room={{ $room->slug }}" 
                       class="inline-flex items-center gap-2 bg-[#c09b5a] hover:bg-[#a48043] text-white font-bold px-5 py-3 rounded-xl text-xs uppercase tracking-wider shadow-md transition">
                        <span>View All {{ $room->name }} Products ({{ $totalProductsCount }})</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Container with Category -> Subcategory Flow -->
    <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 space-y-16" x-data="{ selectedCategory: 'all' }">
        
        <!-- Category Filter Pills -->
        @if($groupedByCategory->count() > 1)
            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none border-b border-[#ded7cd]">
                <button type="button" 
                        @click="selectedCategory = 'all'" 
                        :class="selectedCategory === 'all' ? 'bg-[#171615] text-white' : 'bg-white text-[#55504a] hover:bg-[#f5f0ea] border border-[#ded7cd]'"
                        class="px-4 py-2 rounded-full text-xs font-bold transition flex items-center gap-2 flex-shrink-0">
                    <span>All Subcategories</span>
                    <span class="text-[10px] px-2 py-0.5 rounded-full" :class="selectedCategory === 'all' ? 'bg-[#c09b5a] text-white' : 'bg-slate-100 text-slate-600'">
                        {{ $subCategories->count() }}
                    </span>
                </button>

                @foreach($groupedByCategory as $grp)
                    @if($grp['category'])
                        <button type="button" 
                                @click="selectedCategory = '{{ $grp['category']->slug }}'" 
                                :class="selectedCategory === '{{ $grp['category']->slug }}' ? 'bg-[#171615] text-white' : 'bg-white text-[#55504a] hover:bg-[#f5f0ea] border border-[#ded7cd]'"
                                class="px-4 py-2 rounded-full text-xs font-bold transition flex items-center gap-2 flex-shrink-0">
                            <span>{{ $grp['category']->name }}</span>
                            <span class="text-[10px] px-2 py-0.5 rounded-full" :class="selectedCategory === '{{ $grp['category']->slug }}' ? 'bg-[#c09b5a] text-white' : 'bg-slate-100 text-slate-600'">
                                {{ count($grp['subcategories']) }}
                            </span>
                        </button>
                    @endif
                @endforeach
            </div>
        @endif

        <!-- Subcategories Grouped by Category -->
        <div class="space-y-12">
            @foreach($groupedByCategory as $group)
                @php
                    $catSlug = $group['category']->slug ?? 'other';
                    $catName = $group['category']->name ?? 'Other';
                @endphp
                <div x-show="selectedCategory === 'all' || selectedCategory === '{{ $catSlug }}'" class="space-y-6" x-cloak>
                    
                    <!-- Category Header -->
                    <div class="flex items-center justify-between border-b border-[#ded7cd] pb-3">
                        <div class="flex items-center gap-3">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#c09b5a]"></span>
                            <h2 class="font-serif-pristo text-xl sm:text-2xl font-bold text-[#171615]">
                                {{ $catName }}
                            </h2>
                            <span class="text-xs font-medium text-[#736c63]">
                                ({{ $group['count'] }} {{ Str::plural('Product', $group['count']) }})
                            </span>
                        </div>
                        <a href="/products?room={{ $room->slug }}&category={{ $catSlug }}" 
                           class="text-xs font-bold text-[#171615] hover:text-[#c09b5a] transition flex items-center gap-1">
                            <span>View All {{ $catName }}</span> ➔
                        </a>
                    </div>

                    <!-- Subcategories Grid for this Category -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($group['subcategories'] as $sub)
                            @php
                                $targetUrl = url('/products?room=' . $room->slug . '&category=' . urlencode($sub['category_slug']) . '&subcategory=' . urlencode($sub['slug']));
                            @endphp
                            <a href="{{ $targetUrl }}" 
                               class="group bg-white border border-[#ded7cd] hover:border-[#c09b5a] rounded-2xl overflow-hidden shadow-xs hover:shadow-lg transition duration-300 flex flex-col h-full">
                                
                                <!-- Image Box -->
                                <div class="aspect-[4/3] bg-[#f5f1eb] relative overflow-hidden flex items-center justify-center p-4">
                                    @if(!empty($sub['sample_image']))
                                        <img src="{{ asset($sub['sample_image']) }}" 
                                             alt="{{ $sub['name'] }}" 
                                             class="w-full h-full object-contain group-hover:scale-105 transition duration-500">
                                    @else
                                        <div class="w-16 h-16 rounded-full bg-[#171615] text-[#c09b5a] flex items-center justify-center text-xl font-bold font-serif-pristo">
                                            {{ substr($sub['name'], 0, 1) }}
                                        </div>
                                    @endif

                                    <!-- Product Count Badge -->
                                    <span class="absolute top-3 right-3 bg-[#171615]/85 backdrop-blur-xs text-white text-[10px] font-bold px-2.5 py-1 rounded-full border border-[#333]">
                                        {{ $sub['count'] }} {{ Str::plural('Product', $sub['count']) }}
                                    </span>
                                </div>

                                <!-- Card Details -->
                                <div class="p-5 flex flex-col flex-grow justify-between bg-white border-t border-[#f0ebe1]">
                                    <div>
                                        <span class="text-[10px] uppercase font-bold tracking-wider text-[#c09b5a] block">
                                            {{ $catName }}
                                        </span>
                                        <h3 class="font-bold text-base text-[#171615] group-hover:text-[#c09b5a] transition duration-200 mt-0.5">
                                            {{ $sub['name'] }}
                                        </h3>
                                        @if($sub['min_price'] > 0)
                                            <p class="text-xs font-semibold text-slate-500 mt-1">
                                                Starting from ₹{{ number_format($sub['min_price'], 2) }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-[#f5f0ea] flex items-center justify-between text-xs font-semibold text-[#c09b5a]">
                                        <span class="text-[11px] uppercase tracking-wider font-bold group-hover:translate-x-0.5 transition duration-200">
                                            Browse Products
                                        </span>
                                        <div class="w-7 h-7 rounded-full bg-[#f5f0ea] group-hover:bg-[#c09b5a] text-[#171615] group-hover:text-white flex items-center justify-center text-xs transition">
                                            ➔
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Featured Highlights in this Space -->
        @if($previewProducts->isNotEmpty())
            <div class="pt-8 border-t border-[#ded7cd]">
                <div class="border-b border-[#ded7cd] pb-4 mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-2">
                    <div>
                        <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#736c63]">SPOTLIGHT</span>
                        <h2 class="font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615] mt-1">
                            Popular in {{ $room->name }}
                        </h2>
                    </div>
                    <a href="/products?room={{ $room->slug }}" class="text-xs font-bold text-[#171615] hover:text-[#c09b5a] transition inline-flex items-center gap-1">
                        View All {{ $totalProductsCount }} Products ➔
                    </a>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                    @foreach($previewProducts as $prod)
                        <a href="{{ route('products.show', $prod->slug) }}" 
                           class="group bg-white border border-[#ded7cd] hover:border-[#c09b5a] rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition duration-300 flex flex-col">
                            <div class="aspect-square bg-[#f5f1eb] relative p-4 flex items-center justify-center">
                                <img src="{{ asset($prod->featured_image) }}" alt="{{ $prod->name }}" class="max-h-full max-w-full object-contain group-hover:scale-105 transition duration-300">
                                @if($prod->discount > 0)
                                    <span class="absolute top-2 left-2 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                                        {{ round($prod->discount) }}% OFF
                                    </span>
                                @endif
                            </div>
                            <div class="p-4 flex flex-col flex-grow justify-between bg-white border-t border-[#f0ebe1]">
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#c09b5a]">
                                        {{ $prod->brand->name ?? 'Pristo' }}
                                    </span>
                                    <h3 class="font-bold text-xs text-[#171615] group-hover:text-[#c09b5a] transition line-clamp-1 mt-0.5">
                                        {{ $prod->name }}
                                    </h3>
                                    @if($prod->sub_category)
                                        <span class="text-[10px] text-[#8c857b] block mt-0.5">{{ $prod->sub_category }}</span>
                                    @endif
                                </div>
                                <div class="mt-3 flex items-baseline justify-between">
                                    <span class="text-sm font-black text-[#171615]">
                                        ₹{{ number_format($prod->price, 2) }}
                                    </span>
                                    @if($prod->mrp > $prod->price)
                                        <span class="text-[10px] text-[#a8a29e] line-through">
                                            ₹{{ number_format($prod->mrp, 2) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-app-layout>
