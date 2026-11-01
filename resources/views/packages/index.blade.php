<x-app-layout>
    <x-slot name="title">Bathroom Packages &amp; Configurations - Pristo Enterprises</x-slot>

    <!-- Hero Header -->
    <div class="bg-[#171615] text-[#f7f4ef] py-14 md:py-20 border-b border-[#2b2825]">
        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-[#a39e97] text-xs gap-2 items-center mb-4">
                <a href="/" class="hover:text-[#c09b5a] transition">Home</a>
                <span>/</span>
                <span class="text-[#c09b5a] font-semibold">Bathroom Packages</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-3 max-w-3xl">
                    <span class="text-[10px] uppercase font-bold tracking-[0.28em] text-[#c09b5a] block">CURATED COMBO PACKAGES</span>
                    <h1 class="font-serif-pristo text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white tracking-tight leading-tight">
                        Complete Bathroom Packages
                    </h1>
                    <p class="text-xs sm:text-sm text-[#a39e97] leading-relaxed pt-1">
                        Explore our complete bathroom combo packages designed with matching sanitaryware, CP brassware fittings, and wellness showers. Get the complete suite together at special discounted package rates.
                    </p>
                </div>

                <div class="flex items-center gap-3 flex-wrap">
                    <a href="https://wa.me/916362346660?text={{ urlencode('Hi Pristo, I would like to inquire about Bathroom Package configurations.') }}" 
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-[#25D366] hover:bg-[#20ba59] text-white text-xs font-bold uppercase tracking-wider px-5 py-3 rounded-full transition shadow-md">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.353.101.173.448.74 0.963 1.2 0.662.591 1.221.774 1.394.86.173.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087.159.058 1.011.477 1.184.564.173.087.289.13.332.203.043.072.043.419-.101.824z"/></svg>
                        <span>Custom Package Quote</span>
                    </a>
                </div>
            </div>

            <!-- Brand Filter Tabs -->
            <div class="mt-8 pt-6 border-t border-[#2b2825] flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
                <a href="{{ route('packages.index') }}" 
                   class="px-4 py-2 rounded-full text-xs font-bold transition whitespace-nowrap {{ !$brandSlug ? 'bg-[#c09b5a] text-white shadow-sm' : 'bg-[#242220] text-[#a39e97] hover:text-white hover:bg-[#2e2b28]' }}">
                    All Packages
                </a>
                @foreach($brands as $b)
                    <a href="{{ route('packages.index', ['brand' => $b->slug]) }}" 
                       class="px-4 py-2 rounded-full text-xs font-bold transition whitespace-nowrap {{ $brandSlug == $b->slug ? 'bg-[#c09b5a] text-white shadow-sm' : 'bg-[#242220] text-[#a39e97] hover:text-white hover:bg-[#2e2b28]' }}">
                        {{ $b->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Main Packages Listing Section -->
    <div class="bg-[#faf8f5] py-12 md:py-16">
        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

            @forelse($packages as $pkg)
                @php
                    $whatsappMsg = "Hi Pristo, I am interested in " . $pkg->name;
                    if ($pkg->brand) {
                        $whatsappMsg .= " (" . $pkg->brand->name . ")";
                    }
                    if ($pkg->price) {
                        $whatsappMsg .= " priced at Rs. " . number_format($pkg->price);
                    }
                    $whatsappMsg .= ". Please provide the complete quotation and delivery details.";

                    $basinItems = $pkg->items->filter(fn($i) => str_contains(strtolower($i->area), 'basin'));
                    $wcItems = $pkg->items->filter(fn($i) => str_contains(strtolower($i->area), 'wc') || str_contains(strtolower($i->area), 'toilet'));
                    $showerItems = $pkg->items->filter(fn($i) => str_contains(strtolower($i->area), 'shower'));
                    $otherItems = $pkg->items->reject(fn($i) => 
                        str_contains(strtolower($i->area), 'basin') || 
                        str_contains(strtolower($i->area), 'wc') || 
                        str_contains(strtolower($i->area), 'toilet') || 
                        str_contains(strtolower($i->area), 'shower')
                    );
                    $hasAreas = $basinItems->isNotEmpty() || $wcItems->isNotEmpty() || $showerItems->isNotEmpty();
                @endphp

                <!-- Package Card -->
                <div class="bg-white rounded-3xl border border-[#e8e4dc] shadow-sm overflow-hidden hover:shadow-md transition">
                    
                    <!-- Card Top Header -->
                    <div class="p-6 md:p-8 bg-gradient-to-r from-[#fbf9f6] via-[#f7f3ed] to-white border-b border-[#e8e4dc] flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-3 flex-wrap">
                                <a href="{{ route('packages.show', $pkg->slug) }}" class="group">
                                    <h2 class="font-serif-pristo text-2xl md:text-3xl font-bold text-[#171615] group-hover:text-[#c09b5a] transition">
                                        {{ $pkg->name }}
                                    </h2>
                                </a>
                                @if($pkg->brand)
                                    <span class="bg-[#171615] text-[#c09b5a] text-xs font-extrabold tracking-wider uppercase px-3 py-1 rounded-full border border-[#c09b5a]/30">
                                        {{ $pkg->brand->name }}
                                    </span>
                                @endif
                                <span class="bg-[#f4eeea] text-[#736c64] text-xs font-bold px-3 py-1 rounded-full border border-[#e8e4dc]">
                                    📦 {{ $pkg->items->count() }} Products Included
                                </span>
                                @php
                                    $pkgMrp = $pkg->effective_mrp;
                                    $discountPct = $pkg->discount_percent;
                                    $savingsAmt = $pkg->savings_amount;
                                @endphp
                                @if($discountPct > 0)
                                    <span class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-xs font-black px-3.5 py-1 rounded-full uppercase tracking-wider shadow-xs flex items-center gap-1.5">
                                        <span>🔥</span>
                                        <span>{{ $discountPct }}% OFF</span>
                                    </span>
                                @endif
                            </div>
                            @if($pkg->tagline)
                                <p class="text-xs sm:text-sm text-[#736c64] font-medium">
                                    {{ $pkg->tagline }}
                                </p>
                            @endif

                            @if($hasAreas)
                                <div class="flex items-center gap-2 pt-1 flex-wrap text-[11px] font-bold">
                                    @if($basinItems->isNotEmpty())
                                        <span class="bg-sky-50 text-sky-800 border border-sky-200 px-2.5 py-0.5 rounded-full">
                                            💧 {{ $basinItems->count() }} Basin Items
                                        </span>
                                    @endif
                                    @if($wcItems->isNotEmpty())
                                        <span class="bg-purple-50 text-purple-800 border border-purple-200 px-2.5 py-0.5 rounded-full">
                                            🚽 {{ $wcItems->count() }} WC Items
                                        </span>
                                    @endif
                                    @if($showerItems->isNotEmpty())
                                        <span class="bg-amber-50 text-amber-800 border border-amber-200 px-2.5 py-0.5 rounded-full">
                                            🚿 {{ $showerItems->count() }} Shower Items
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Price & Quote CTA -->
                        <div class="flex items-center gap-4 flex-wrap">
                            @if($pkg->price)
                                <div class="text-left md:text-right">
                                    <span class="text-[10px] uppercase font-bold text-[#8c8275] tracking-wider block">Special Combo Price</span>
                                    <div class="flex items-baseline gap-2 flex-wrap">
                                        <span class="text-2xl md:text-3xl font-black text-[#171615]">₹{{ number_format($pkg->price) }}</span>
                                        @if($pkgMrp && $pkgMrp > $pkg->price)
                                            <span class="text-sm text-[#9c9489] line-through font-medium">MRP ₹{{ number_format($pkgMrp) }}</span>
                                        @endif
                                        @if($discountPct > 0)
                                            <span class="inline-flex items-center gap-1 text-xs bg-emerald-100 text-emerald-800 border border-emerald-300 font-black px-2.5 py-0.5 rounded-full shadow-2xs">
                                                <span>🔥 {{ $discountPct }}% OFF</span>
                                            </span>
                                        @endif
                                    </div>
                                    @if($savingsAmt > 0)
                                        <span class="text-[11px] font-bold text-[#0d9488] block mt-0.5">
                                            You Save ₹{{ number_format($savingsAmt) }} ({{ $discountPct }}% Savings on Package)
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="flex items-center gap-2">
                                <a href="{{ route('packages.show', $pkg->slug) }}" 
                                   class="inline-flex items-center gap-1.5 bg-[#f4eeea] hover:bg-[#eae3d8] text-[#171615] text-xs font-bold px-4 py-3 rounded-xl transition">
                                    <span>Details &rarr;</span>
                                </a>
                                <a href="https://wa.me/916362346660?text={{ urlencode($whatsappMsg) }}" 
                                   target="_blank"
                                   class="inline-flex items-center gap-2 bg-[#171615] hover:bg-[#c09b5a] text-white text-xs font-bold uppercase tracking-wider px-5 py-3 rounded-xl transition duration-300 shadow-sm">
                                    <svg class="w-4 h-4 fill-[#25D366]" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.353.101.173.448.74 0.963 1.2 0.662.591 1.221.774 1.394.86.173.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087.159.058 1.011.477 1.184.564.173.087.289.13.332.203.043.072.043.419-.101.824z"/></svg>
                                    <span>Get Quote</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    @if($discountPct > 0)
                        <div class="px-6 py-2.5 bg-gradient-to-r from-emerald-50 via-teal-50/50 to-white border-b border-emerald-100/70 flex flex-wrap items-center justify-between gap-2 text-xs font-bold text-emerald-950">
                            <div class="flex items-center gap-2">
                                <span class="text-sm">🏷️</span>
                                <span>Complete Combo Special: <strong class="text-emerald-700 font-extrabold">{{ $discountPct }}% DISCOUNT</strong> applied on this complete package!</span>
                            </div>
                            @if($savingsAmt > 0)
                                <span class="bg-white text-emerald-700 text-[11px] font-black px-2.5 py-0.5 rounded-full border border-emerald-200">
                                    Instant Savings ₹{{ number_format($savingsAmt) }}
                                </span>
                            @endif
                        </div>
                    @endif

                    <!-- Products in this Package -->
                    <div class="p-6 md:p-8 bg-white space-y-6">

                        @if($hasAreas)
                            <!-- 3 BROCHURE AREA COLUMNS: Basin Area, WC Area, Shower Area -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                                
                                <!-- 1. Basin Area -->
                                <div class="bg-[#faf8f5] rounded-2xl p-5 border border-[#eee9e0] space-y-3 overflow-hidden">
                                    <div class="flex items-center justify-between border-b border-sky-100 pb-2.5">
                                        <h4 class="font-bold text-sm text-[#171615] flex items-center gap-1.5">
                                            <span class="text-sky-600">💧</span>
                                            <span>Basin Area</span>
                                        </h4>
                                        <span class="text-[10px] font-bold text-sky-800 bg-sky-50 px-2 py-0.5 rounded-full border border-sky-200">
                                            {{ $basinItems->count() }}
                                        </span>
                                    </div>

                                    <div class="space-y-3">
                                        @forelse($basinItems as $item)
                                            <div class="bg-white rounded-2xl p-3.5 border border-[#e8e4dc] flex items-start gap-3.5 overflow-hidden shadow-2xs hover:shadow-xs transition">
                                                <div class="w-14 h-14 rounded-xl bg-white p-1 flex-shrink-0 flex items-center justify-center overflow-hidden border border-[#eee9e0]">
                                                    @if($item->display_image)
                                                        <img src="{{ $item->display_image }}" class="w-full h-full object-contain">
                                                    @else
                                                        <span class="text-xl text-slate-300">💧</span>
                                                    @endif
                                                </div>
                                                <div class="flex-grow min-w-0 overflow-hidden">
                                                    @if($item->cat_no)
                                                        <span class="text-[10px] font-mono font-bold text-[#8c8275] bg-[#faf8f5] px-1.5 py-0.5 rounded border border-[#eee9e0] inline-block mb-1">Cat: {{ $item->cat_no }}</span>
                                                    @endif
                                                    <h5 class="text-xs sm:text-[13px] font-bold text-[#171615] leading-snug line-clamp-2 break-words" title="{{ $item->name }}">{{ $item->name }}</h5>
                                                    @php
                                                        $itemPrice = $item->effective_price;
                                                        $itemMrp = $item->effective_mrp;
                                                        $itemDisc = $item->discount_percent;
                                                    @endphp
                                                    @if($itemPrice)
                                                        <div class="mt-2 space-y-0.5 leading-tight">
                                                            <span class="text-sm font-black text-[#171615] block">₹{{ number_format($itemPrice) }}</span>
                                                            @if($itemMrp && $itemMrp > $itemPrice)
                                                                <span class="text-[11px] text-slate-400 line-through block">₹{{ number_format($itemMrp) }}</span>
                                                            @endif
                                                            @if($itemDisc && $itemDisc > 0)
                                                                <span class="text-[11px] font-bold text-[#0d9488] block">Discount {{ $itemDisc }}%</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-xs text-slate-400 py-3 text-center italic">No items</p>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- 2. WC Area -->
                                <div class="bg-[#faf8f5] rounded-2xl p-5 border border-[#eee9e0] space-y-3 overflow-hidden">
                                    <div class="flex items-center justify-between border-b border-purple-100 pb-2.5">
                                        <h4 class="font-bold text-sm text-[#171615] flex items-center gap-1.5">
                                            <span class="text-purple-600">🚽</span>
                                            <span>WC Area</span>
                                        </h4>
                                        <span class="text-[10px] font-bold text-purple-800 bg-purple-50 px-2 py-0.5 rounded-full border border-purple-200">
                                            {{ $wcItems->count() }}
                                        </span>
                                    </div>

                                    <div class="space-y-3">
                                        @forelse($wcItems as $item)
                                            <div class="bg-white rounded-2xl p-3.5 border border-[#e8e4dc] flex items-start gap-3.5 overflow-hidden shadow-2xs hover:shadow-xs transition">
                                                <div class="w-14 h-14 rounded-xl bg-white p-1 flex-shrink-0 flex items-center justify-center overflow-hidden border border-[#eee9e0]">
                                                    @if($item->display_image)
                                                        <img src="{{ $item->display_image }}" class="w-full h-full object-contain">
                                                    @else
                                                        <span class="text-xl text-slate-300">🚽</span>
                                                    @endif
                                                </div>
                                                <div class="flex-grow min-w-0 overflow-hidden">
                                                    @if($item->cat_no)
                                                        <span class="text-[10px] font-mono font-bold text-[#8c8275] bg-[#faf8f5] px-1.5 py-0.5 rounded border border-[#eee9e0] inline-block mb-1">Cat: {{ $item->cat_no }}</span>
                                                    @endif
                                                    <h5 class="text-xs sm:text-[13px] font-bold text-[#171615] leading-snug line-clamp-2 break-words" title="{{ $item->name }}">{{ $item->name }}</h5>
                                                    @php
                                                        $itemPrice = $item->effective_price;
                                                        $itemMrp = $item->effective_mrp;
                                                        $itemDisc = $item->discount_percent;
                                                    @endphp
                                                    @if($itemPrice)
                                                        <div class="mt-2 space-y-0.5 leading-tight">
                                                            <span class="text-sm font-black text-[#171615] block">₹{{ number_format($itemPrice) }}</span>
                                                            @if($itemMrp && $itemMrp > $itemPrice)
                                                                <span class="text-[11px] text-slate-400 line-through block">₹{{ number_format($itemMrp) }}</span>
                                                            @endif
                                                            @if($itemDisc && $itemDisc > 0)
                                                                <span class="text-[11px] font-bold text-[#0d9488] block">Discount {{ $itemDisc }}%</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-xs text-slate-400 py-3 text-center italic">No items</p>
                                        @endforelse
                                    </div>
                                </div>

                                <!-- 3. Shower Area -->
                                <div class="bg-[#faf8f5] rounded-2xl p-5 border border-[#eee9e0] space-y-3 overflow-hidden">
                                    <div class="flex items-center justify-between border-b border-amber-100 pb-2.5">
                                        <h4 class="font-bold text-sm text-[#171615] flex items-center gap-1.5">
                                            <span class="text-amber-600">🚿</span>
                                            <span>Shower Area</span>
                                        </h4>
                                        <span class="text-[10px] font-bold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                                            {{ $showerItems->count() }}
                                        </span>
                                    </div>

                                    <div class="space-y-3">
                                        @forelse($showerItems as $item)
                                            <div class="bg-white rounded-2xl p-3.5 border border-[#e8e4dc] flex items-start gap-3.5 overflow-hidden shadow-2xs hover:shadow-xs transition">
                                                <div class="w-14 h-14 rounded-xl bg-white p-1 flex-shrink-0 flex items-center justify-center overflow-hidden border border-[#eee9e0]">
                                                    @if($item->display_image)
                                                        <img src="{{ $item->display_image }}" class="w-full h-full object-contain">
                                                    @else
                                                        <span class="text-xl text-slate-300">🚿</span>
                                                    @endif
                                                </div>
                                                <div class="flex-grow min-w-0 overflow-hidden">
                                                    @if($item->cat_no)
                                                        <span class="text-[10px] font-mono font-bold text-[#8c8275] bg-[#faf8f5] px-1.5 py-0.5 rounded border border-[#eee9e0] inline-block mb-1">Cat: {{ $item->cat_no }}</span>
                                                    @endif
                                                    <h5 class="text-xs sm:text-[13px] font-bold text-[#171615] leading-snug line-clamp-2 break-words" title="{{ $item->name }}">{{ $item->name }}</h5>
                                                    @php
                                                        $itemPrice = $item->effective_price;
                                                        $itemMrp = $item->effective_mrp;
                                                        $itemDisc = $item->discount_percent;
                                                    @endphp
                                                    @if($itemPrice)
                                                        <div class="mt-2 space-y-0.5 leading-tight">
                                                            <span class="text-sm font-black text-[#171615] block">₹{{ number_format($itemPrice) }}</span>
                                                            @if($itemMrp && $itemMrp > $itemPrice)
                                                                <span class="text-[11px] text-slate-400 line-through block">₹{{ number_format($itemMrp) }}</span>
                                                            @endif
                                                            @if($itemDisc && $itemDisc > 0)
                                                                <span class="text-[11px] font-bold text-[#0d9488] block">Discount {{ $itemDisc }}%</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-xs text-slate-400 py-3 text-center italic">No items</p>
                                        @endforelse
                                    </div>
                                </div>

                            </div>
                        @else
                            <!-- Fallback Grid when no areas are assigned -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 md:gap-5">
                                @forelse($pkg->items as $item)
                                    <div class="bg-[#faf8f5] hover:bg-white border border-[#eee9e0] hover:border-[#c09b5a]/50 rounded-2xl p-4 transition duration-200 flex flex-col justify-between group">
                                        <div>
                                            <div class="w-full h-36 bg-white border border-[#e8e4dc] rounded-xl p-2 flex items-center justify-center overflow-hidden mb-3">
                                                @if($item->display_image)
                                                    <img src="{{ $item->display_image }}" alt="{{ $item->name }}" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                                                @else
                                                    <span class="text-4xl text-slate-300">📦</span>
                                                @endif
                                            </div>
                                            @if($item->cat_no)
                                                <span class="inline-block text-[10px] font-mono font-bold text-[#8c8275] bg-white border border-[#e8e4dc] px-2 py-0.5 rounded-md mb-1.5">
                                                    Cat No: {{ $item->cat_no }}
                                                </span>
                                            @endif
                                            <h4 class="text-xs font-bold text-[#171615] leading-snug line-clamp-2">
                                                {{ $item->name }}
                                            </h4>
                                            @if($item->description)
                                                <p class="text-[11px] text-[#736c64] mt-1 font-normal leading-normal line-clamp-2">
                                                    {{ $item->description }}
                                                </p>
                                            @endif
                                        </div>

                                        <div class="mt-3 pt-2.5 border-t border-[#eee9e0] flex items-end justify-between">
                                            @php
                                                $itemPrice = $item->effective_price;
                                                $itemMrp = $item->effective_mrp;
                                                $itemDisc = $item->discount_percent;
                                            @endphp
                                            @if($itemPrice)
                                                <div class="space-y-0.5 leading-tight">
                                                    <span class="text-sm font-black text-[#171615] block">₹{{ number_format($itemPrice) }}</span>
                                                    @if($itemMrp && $itemMrp > $itemPrice)
                                                        <span class="text-[11px] text-slate-400 line-through block">₹{{ number_format($itemMrp) }}</span>
                                                    @endif
                                                    @if($itemDisc && $itemDisc > 0)
                                                        <span class="text-[11px] font-bold text-[#0d9488] block">Discount {{ $itemDisc }}%</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded">Included</span>
                                            @endif
                                            @if($item->quantity && $item->quantity > 1)
                                                <span class="text-[11px] font-bold text-[#8c8275] bg-[#faf8f5] px-2 py-0.5 rounded border border-[#eee9e0]">Qty: {{ $item->quantity }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-full py-10 text-center text-xs text-slate-400">
                                        No products listed in this package yet.
                                    </div>
                                @endforelse
                            </div>
                        @endif

                    </div>

                    <!-- Card Bottom Action Bar -->
                    <div class="p-5 md:px-8 bg-[#faf8f5] border-t border-[#eee9e0] flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-xs text-[#736c64] flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#c09b5a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Includes complete package set as listed above with standard manufacturer warranty</span>
                        </div>

                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <a href="{{ route('packages.show', $pkg->slug) }}" class="w-full sm:w-auto text-center px-5 py-2.5 rounded-xl border border-[#171615] text-xs font-bold text-[#171615] hover:bg-[#171615] hover:text-white transition">
                                View Full Configuration
                            </a>
                            <a href="https://wa.me/916362346660?text={{ urlencode($whatsappMsg) }}" 
                               target="_blank"
                               class="w-full sm:w-auto text-center inline-flex items-center justify-center gap-2 bg-[#c09b5a] hover:bg-[#a48043] text-white text-xs font-bold uppercase tracking-wider px-6 py-2.5 rounded-xl transition shadow-xs">
                                <span>Inquire on WhatsApp</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>

                </div>
            @empty
                <div class="py-20 text-center bg-white rounded-3xl border border-[#e8e4dc] p-8 max-w-xl mx-auto">
                    <span class="text-5xl block mb-4">🛁</span>
                    <h3 class="font-serif-pristo text-2xl font-bold text-[#171615]">No Bathroom Packages Found</h3>
                    <p class="text-xs text-[#736c64] mt-2">
                        Configurations are currently being prepared. Check back soon or contact our design desk for custom recommendations.
                    </p>
                    <a href="/contact" class="mt-6 inline-block bg-[#171615] text-white text-xs font-bold px-6 py-3 rounded-full hover:bg-[#c09b5a] transition">
                        Contact Design Desk
                    </a>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
