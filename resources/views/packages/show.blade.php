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

                <div class="flex items-center gap-3">
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
            <!-- Full Items Grid -->
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
        </div>
    </div>
</x-app-layout>
