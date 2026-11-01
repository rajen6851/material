<x-app-layout>
    <x-slot name="title">{{ $package->name }} - Bathroom Package - Pristo Enterprises</x-slot>

    @php
        $whatsappMsg = "Hi Pristo, I am interested in " . $package->name;
        if ($package->brand) {
            $whatsappMsg .= " (" . $package->brand->name . ")";
        }
        if ($package->price) {
            $whatsappMsg .= " priced at Rs. " . number_format($package->price);
        }
        $whatsappMsg .= ". Please provide quotation and delivery availability.";

        $basinItems = $package->items->filter(fn($i) => str_contains(strtolower($i->area), 'basin'));
        $wcItems = $package->items->filter(fn($i) => str_contains(strtolower($i->area), 'wc') || str_contains(strtolower($i->area), 'toilet'));
        $showerItems = $package->items->filter(fn($i) => str_contains(strtolower($i->area), 'shower'));
        $otherItems = $package->items->reject(fn($i) => 
            str_contains(strtolower($i->area), 'basin') || 
            str_contains(strtolower($i->area), 'wc') || 
            str_contains(strtolower($i->area), 'toilet') || 
            str_contains(strtolower($i->area), 'shower')
        );

        $hasAreaDivision = $basinItems->isNotEmpty() || $wcItems->isNotEmpty() || $showerItems->isNotEmpty();
    @endphp

    <div class="bg-[#171615] text-[#f7f4ef] py-14 border-b border-[#2b2825]">
        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-[#a39e97] text-xs gap-2 items-center mb-4">
                <a href="/" class="hover:text-[#c09b5a] transition">Home</a>
                <span>/</span>
                <a href="{{ route('packages.index') }}" class="hover:text-[#c09b5a] transition">Bathroom Packages</a>
                <span>/</span>
                <span class="text-[#c09b5a] font-semibold">{{ $package->name }}</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    @if($package->brand)
                        <span class="text-[10px] uppercase font-bold tracking-[0.28em] text-[#c09b5a] block mb-2">{{ $package->brand->name }} PACKAGE</span>
                    @endif
                    <h1 class="font-serif-pristo text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight leading-tight">
                        {{ $package->name }}
                    </h1>
                    @if($package->tagline)
                        <p class="text-sm text-[#a39e97] mt-2">{{ $package->tagline }}</p>
                    @endif
                </div>

                <div class="flex items-center gap-4 flex-wrap">
                    @if($package->price)
                        <div class="text-right">
                            <span class="text-xs text-[#a39e97] block">Complete Package Price</span>
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl sm:text-3xl font-black text-[#c09b5a]">₹{{ number_format($package->price) }}</span>
                                @if($package->mrp && $package->mrp > $package->price)
                                    <span class="text-xs text-[#736c64] line-through">MRP ₹{{ number_format($package->mrp) }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                    <a href="https://wa.me/916362346660?text={{ urlencode($whatsappMsg) }}" 
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#20ba59] text-white text-xs font-bold uppercase tracking-wider px-6 py-3 rounded-full transition shadow-md">
                        <span>Get Instant Quote</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-[#faf8f5] py-12 md:py-16">
        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            @if($hasAreaDivision)
                <!-- 3-ZONE BROCHURE CONFIGURATION: Basin Area, WC Area, Shower Area -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between border-b border-[#eee9e0] pb-4">
                        <div>
                            <h3 class="font-serif-pristo text-2xl font-bold text-[#171615] flex items-center gap-2">
                                <span>📦 Bathroom Configuration &amp; Components</span>
                            </h3>
                            <p class="text-xs text-[#8c8275] mt-1">Complete set divided into dedicated functional zones as per configuration brochure.</p>
                        </div>
                        <span class="text-xs font-bold text-[#8c8275] bg-white px-3 py-1 rounded-full border border-[#eee9e0]">
                            {{ $package->items->count() }} Total Products
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                        
                        <!-- 1. BASIN AREA COLUMN -->
                        <div class="bg-white rounded-3xl border border-[#e8e4dc] p-6 shadow-xs space-y-4">
                            <div class="flex items-center justify-between border-b border-sky-100 pb-3">
                                <h4 class="font-bold text-base text-[#171615] flex items-center gap-2">
                                    <span class="text-sky-600">💧</span>
                                    <span>Basin Area</span>
                                </h4>
                                <span class="text-[11px] font-bold text-sky-800 bg-sky-50 px-2.5 py-0.5 rounded-full border border-sky-100">
                                    {{ $basinItems->count() }} Items
                                </span>
                            </div>

                            <div class="space-y-3.5">
                                @forelse($basinItems as $item)
                                    <div class="bg-[#faf8f5] hover:bg-white border border-[#eee9e0] hover:border-sky-300 rounded-2xl p-3.5 transition group flex gap-3.5 items-center">
                                        <div class="w-16 h-16 bg-white border border-[#e8e4dc] rounded-xl p-1 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                            @if($item->display_image)
                                                <img src="{{ $item->display_image }}" class="w-full h-full object-contain group-hover:scale-105 transition">
                                            @else
                                                <span class="text-2xl text-slate-300">💧</span>
                                            @endif
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            @if($item->cat_no)
                                                <span class="text-[10px] font-mono font-bold text-[#8c8275] bg-white border border-[#e8e4dc] px-1.5 py-0.5 rounded inline-block mb-0.5">
                                                    Cat: {{ $item->cat_no }}
                                                </span>
                                            @endif
                                            <h5 class="text-xs font-bold text-[#171615] leading-snug line-clamp-2">{{ $item->name }}</h5>
                                            @if($item->description)
                                                <p class="text-[11px] text-[#736c64] line-clamp-1 mt-0.5">{{ $item->description }}</p>
                                            @endif
                                            @if($item->price)
                                                <span class="text-[11px] font-extrabold text-[#171615] block mt-1">₹{{ number_format($item->price) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 py-6 text-center italic">No items assigned to Basin Area</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- 2. WC AREA COLUMN -->
                        <div class="bg-white rounded-3xl border border-[#e8e4dc] p-6 shadow-xs space-y-4">
                            <div class="flex items-center justify-between border-b border-purple-100 pb-3">
                                <h4 class="font-bold text-base text-[#171615] flex items-center gap-2">
                                    <span class="text-purple-600">🚽</span>
                                    <span>WC Area</span>
                                </h4>
                                <span class="text-[11px] font-bold text-purple-800 bg-purple-50 px-2.5 py-0.5 rounded-full border border-purple-100">
                                    {{ $wcItems->count() }} Items
                                </span>
                            </div>

                            <div class="space-y-3.5">
                                @forelse($wcItems as $item)
                                    <div class="bg-[#faf8f5] hover:bg-white border border-[#eee9e0] hover:border-purple-300 rounded-2xl p-3.5 transition group flex gap-3.5 items-center">
                                        <div class="w-16 h-16 bg-white border border-[#e8e4dc] rounded-xl p-1 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                            @if($item->display_image)
                                                <img src="{{ $item->display_image }}" class="w-full h-full object-contain group-hover:scale-105 transition">
                                            @else
                                                <span class="text-2xl text-slate-300">🚽</span>
                                            @endif
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            @if($item->cat_no)
                                                <span class="text-[10px] font-mono font-bold text-[#8c8275] bg-white border border-[#e8e4dc] px-1.5 py-0.5 rounded inline-block mb-0.5">
                                                    Cat: {{ $item->cat_no }}
                                                </span>
                                            @endif
                                            <h5 class="text-xs font-bold text-[#171615] leading-snug line-clamp-2">{{ $item->name }}</h5>
                                            @if($item->description)
                                                <p class="text-[11px] text-[#736c64] line-clamp-1 mt-0.5">{{ $item->description }}</p>
                                            @endif
                                            @if($item->price)
                                                <span class="text-[11px] font-extrabold text-[#171615] block mt-1">₹{{ number_format($item->price) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 py-6 text-center italic">No items assigned to WC Area</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- 3. SHOWER AREA COLUMN -->
                        <div class="bg-white rounded-3xl border border-[#e8e4dc] p-6 shadow-xs space-y-4">
                            <div class="flex items-center justify-between border-b border-amber-100 pb-3">
                                <h4 class="font-bold text-base text-[#171615] flex items-center gap-2">
                                    <span class="text-amber-600">🚿</span>
                                    <span>Shower Area</span>
                                </h4>
                                <span class="text-[11px] font-bold text-amber-800 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-100">
                                    {{ $showerItems->count() }} Items
                                </span>
                            </div>

                            <div class="space-y-3.5">
                                @forelse($showerItems as $item)
                                    <div class="bg-[#faf8f5] hover:bg-white border border-[#eee9e0] hover:border-amber-300 rounded-2xl p-3.5 transition group flex gap-3.5 items-center">
                                        <div class="w-16 h-16 bg-white border border-[#e8e4dc] rounded-xl p-1 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                            @if($item->display_image)
                                                <img src="{{ $item->display_image }}" class="w-full h-full object-contain group-hover:scale-105 transition">
                                            @else
                                                <span class="text-2xl text-slate-300">🚿</span>
                                            @endif
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            @if($item->cat_no)
                                                <span class="text-[10px] font-mono font-bold text-[#8c8275] bg-white border border-[#e8e4dc] px-1.5 py-0.5 rounded inline-block mb-0.5">
                                                    Cat: {{ $item->cat_no }}
                                                </span>
                                            @endif
                                            <h5 class="text-xs font-bold text-[#171615] leading-snug line-clamp-2">{{ $item->name }}</h5>
                                            @if($item->description)
                                                <p class="text-[11px] text-[#736c64] line-clamp-1 mt-0.5">{{ $item->description }}</p>
                                            @endif
                                            @if($item->price)
                                                <span class="text-[11px] font-extrabold text-[#171615] block mt-1">₹{{ number_format($item->price) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-slate-400 py-6 text-center italic">No items assigned to Shower Area</p>
                                @endforelse
                            </div>
                        </div>

                    </div>

                    <!-- Other Items (if any) -->
                    @if($otherItems->isNotEmpty())
                        <div class="bg-white rounded-3xl border border-[#e8e4dc] p-6 shadow-xs space-y-4 mt-6">
                            <h4 class="font-bold text-base text-[#171615] flex items-center gap-2 border-b border-[#eee9e0] pb-3">
                                <span>📦 Additional Accessories &amp; Items</span>
                                <span class="text-[11px] font-bold text-[#8c8275] bg-[#faf8f5] px-2.5 py-0.5 rounded-full border border-[#eee9e0]">
                                    {{ $otherItems->count() }} Items
                                </span>
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($otherItems as $item)
                                    <div class="bg-[#faf8f5] hover:bg-white border border-[#eee9e0] rounded-2xl p-3 flex items-center gap-3">
                                        <div class="w-12 h-12 bg-white border border-[#e8e4dc] rounded-lg p-1 flex-shrink-0 flex items-center justify-center">
                                            @if($item->display_image)
                                                <img src="{{ $item->display_image }}" class="w-full h-full object-contain">
                                            @else
                                                <span class="text-lg text-slate-300">📦</span>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <h6 class="text-xs font-bold text-[#171615] truncate">{{ $item->name }}</h6>
                                            @if($item->cat_no)
                                                <span class="text-[10px] font-mono text-[#8c8275]">Cat: {{ $item->cat_no }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            @else
                <!-- Full Items Grid (Fallback when no areas specified) -->
                <div class="bg-white rounded-3xl border border-[#e8e4dc] p-6 md:p-8 shadow-xs">
                    <div class="flex items-center justify-between border-b border-[#eee9e0] pb-4 mb-6">
                        <h3 class="font-serif-pristo text-xl font-bold text-[#171615] flex items-center gap-2">
                            <span>📦 Products Included in this Package</span>
                        </h3>
                        <span class="text-xs font-bold text-[#8c8275] bg-[#faf8f5] px-3 py-1 rounded-full border border-[#eee9e0]">
                            {{ $package->items->count() }} Items
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                        @forelse($package->items as $item)
                            <div class="bg-[#faf8f5] hover:bg-white border border-[#eee9e0] hover:border-[#c09b5a]/50 rounded-2xl p-4 transition flex flex-col justify-between group">
                                <div>
                                    <div class="w-full h-40 bg-white border border-[#e8e4dc] rounded-xl p-2 flex items-center justify-center overflow-hidden mb-3">
                                        @if($item->display_image)
                                            <img src="{{ $item->display_image }}" class="w-full h-full object-contain group-hover:scale-105 transition">
                                        @else
                                            <span class="text-4xl text-slate-300">📦</span>
                                        @endif
                                    </div>
                                    @if($item->cat_no)
                                        <span class="text-[10px] font-mono font-bold text-[#8c8275] bg-white border border-[#e8e4dc] px-2 py-0.5 rounded block mb-1">
                                            Cat No: {{ $item->cat_no }}
                                        </span>
                                    @endif
                                    <h4 class="text-xs font-bold text-[#171615] mt-1">{{ $item->name }}</h4>
                                    @if($item->description)
                                        <p class="text-[11px] text-[#736c64] mt-0.5 line-clamp-2">{{ $item->description }}</p>
                                    @endif
                                </div>

                                <div class="mt-3 pt-2.5 border-t border-[#eee9e0] flex items-center justify-between text-xs">
                                    @if($item->price)
                                        <span class="font-extrabold text-[#171615]">₹{{ number_format($item->price) }}</span>
                                    @else
                                        <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">Included</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 py-8 text-center col-span-full">No products listed in this package yet.</p>
                        @endforelse
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
