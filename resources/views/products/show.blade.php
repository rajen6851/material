<x-app-layout>
    <x-slot name="title">{{ $product->name }} - BuildMart</x-slot>

    @php $isProfessional = auth()->check() && auth()->user()->isProfessional(); @endphp

    <!-- Breadcrumb (Exactly as mockup) -->
    <div class="bg-white border-b py-3 text-xs text-slate-500 font-semibold">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex gap-2 items-center">
                <a href="/" class="hover:text-teal-600">Home</a>
                <span>&gt;</span>
                <a href="/products?category={{ $product->category->slug ?? 'tiles' }}" class="hover:text-teal-600">{{ $product->category->name ?? 'Tiles' }}</a>
                <span>&gt;</span>
                <a href="/products?room={{ $product->room->slug ?? 'general' }}" class="hover:text-teal-600">{{ $product->room->name ?? 'General' }} Tiles</a>
                <span>&gt;</span>
                <span class="text-slate-800">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Showcase Block (Exactly as mockup) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{ 
        quantity: 1, 
        unitPrice: {{ (float) ($isProfessional && $product->wholesale_price ? $product->wholesale_price : $product->price) }},
        get totalTax() {
            return this.quantity * this.unitPrice;
        }
    }">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start bg-white border border-slate-200 rounded-3xl p-8 shadow-sm">
            
            <!-- Left: Big Product Image -->
            <div>
                <div class="bg-slate-50 rounded-2xl p-6 flex items-center justify-center border aspect-square">
                    <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain rounded-xl">
                </div>
            </div>

            <!-- Right: Details Grid -->
            <div class="space-y-6">
                <!-- Title & Brand -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <h1 class="text-2xl font-black text-slate-900">{{ $product->name }}</h1>
                        <span class="text-teal-700 font-bold text-sm tracking-wide uppercase">{{ $product->brand->name ?? 'Premium' }}</span>
                    </div>
                </div>

                <!-- Specs Grid -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-6 border-y py-4 text-xs font-semibold text-slate-500">
                    <div>
                        <span class="block text-slate-400 font-medium">Size</span>
                        <span class="text-slate-800 font-bold">{{ $product->size }} ({{ $product->size_inch ?: '24x48' }})</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 font-medium">Collection</span>
                        <span class="text-slate-800 font-bold">{{ $product->collection ?: 'Glossy' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 font-medium">Sub Category</span>
                        <span class="text-slate-800 font-bold">{{ $product->sub_category ?: 'GVT' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 font-medium">Finish</span>
                        <span class="text-slate-800 font-bold">{{ $product->finish ?: 'Glossy' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 font-medium">Thickness</span>
                        <span class="text-slate-800 font-bold">{{ $product->thickness ?: '9 mm' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 font-medium">Area / Tile</span>
                        <span class="text-slate-800 font-bold">{{ $product->area_tile_sqft ?: '8' }} sq.ft</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 font-medium">Pieces / Box</span>
                        <span class="text-slate-800 font-bold">{{ $product->pieces_per_box ?: '2' }} pcs</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 font-medium">Coverage / Box</span>
                        <span class="text-slate-800 font-bold">{{ $product->coverage_per_box_sqft ?: '16' }} sq.ft</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 font-medium">Weight / Box</span>
                        <span class="text-slate-800 font-bold">{{ $product->weight_per_box_kg ?: '30' }} kg</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 font-medium">Price / Box</span>
                        <span class="text-slate-800 font-bold">₹{{ $product->price_per_box ?: '880' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 font-medium">Edge Type</span>
                        <span class="text-slate-800 font-bold">{{ $product->edge_type ?: 'Square' }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 font-medium">Pattern Type</span>
                        <span class="text-slate-800 font-bold">{{ $product->pattern_type ?: 'Standard' }}</span>
                    </div>
                </div>

                <!-- Price and Stock -->
                <div class="flex items-baseline justify-between">
                    <div>
                        @if($isProfessional && $product->wholesale_price)
                            <div class="flex items-baseline gap-2">
                                <span class="text-2xl font-black text-indigo-700">₹{{ number_format($product->wholesale_price, 2) }} / sq.ft</span>
                            </div>
                            <p class="text-[10px] text-slate-400 font-medium">Trade / wholesale price (excl. applicable taxes)</p>
                        @else
                            <span class="text-2xl font-black text-slate-900">₹{{ number_format($product->price, 2) }} / sq.ft</span>
                            <p class="text-[10px] text-slate-400 font-medium">(inclusive of all taxes)</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <span class="text-emerald-600 font-bold text-xs">In Stock</span>
                        <p class="text-[10px] text-slate-400 font-medium">({{ $product->stock }} sq.ft available)</p>
                    </div>
                </div>

                @if($isProfessional)
                    <!-- Professional: Wholesale pricing + trade actions -->
                    @if($product->wholesale_price)
                        <div class="bg-indigo-50 border border-indigo-200 rounded-2xl p-4 space-y-2 text-xs font-semibold">
                            <div class="flex items-center justify-between">
                                <span class="text-indigo-700">Trade / Wholesale Rate</span>
                                <span class="text-slate-900 font-black text-sm">₹{{ number_format($product->wholesale_price, 2) }} / sq.ft</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-indigo-700">Retail Rate (MRP)</span>
                                <span class="text-slate-900 font-bold">₹{{ number_format($product->price, 2) }} / sq.ft</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-indigo-700">You Save on trade</span>
                                <span class="text-emerald-700 font-black">
                                    @php
                                        $saving = $product->price > 0 ? (($product->price - $product->wholesale_price) / $product->price) * 100 : 0;
                                    @endphp
                                    {{ number_format(max($saving, 0), 1) }}%
                                </span>
                            </div>
                        </div>
                    @endif

                    <!-- Quantity (in sq.ft) -->
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-slate-500">Quantity (sq.ft)</span>
                        <div class="flex items-center border border-slate-300 rounded-xl overflow-hidden h-10 bg-slate-50">
                            <button type="button" @click="quantity > 1 ? quantity-- : null" class="px-3 text-slate-600 font-bold hover:bg-slate-100 transition">&minus;</button>
                            <input type="number" x-model="quantity" class="w-12 border-none text-center bg-transparent focus:ring-0 font-bold text-slate-800 text-sm" readonly>
                            <button type="button" @click="quantity++" class="px-3 text-slate-600 font-bold hover:bg-slate-100 transition">&plus;</button>
                        </div>
                    </div>

                    <!-- Pro actions -->
                    <div class="space-y-3">
                        <a href="/quotation-requests/create?product_id={{ $product->id }}" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold h-12 rounded-xl transition text-sm flex items-center justify-center">
                            Request Bulk Quotation
                        </a>
                        <a href="{{ route('showroom.book') }}" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold h-12 rounded-xl transition text-sm flex items-center justify-center">
                            Book Trade Showroom Visit
                        </a>
                        <p class="text-[10px] text-slate-400 text-center">Bulk quotes are confirmed by our trade desk with final pricing.</p>
                    </div>

                    <!-- Price Summary Block -->
                    <div class="bg-slate-50 border p-5 rounded-2xl space-y-3 text-xs font-semibold text-slate-600">
                        <h4 class="font-bold text-slate-800 text-sm border-b pb-2">Trade Price Estimate</h4>
                        <div class="flex justify-between">
                            <span>Trade rate (1 sq.ft)</span>
                            <span class="text-slate-900 font-bold">₹{{ number_format($product->wholesale_price ?: $product->price, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Quantity</span>
                            <span class="text-slate-900 font-bold" x-text="quantity + ' sq.ft'">1 sq.ft</span>
                        </div>
                        <div class="flex justify-between border-t pt-2 text-slate-900 font-bold text-sm">
                            <span>Est. Total (excl. GST)</span>
                            <span class="text-indigo-700 font-black" x-text="'₹' + totalTax.toFixed(2)">₹0.00</span>
                        </div>
                    </div>
                @else
                    <!-- Homeowner / Guest: Retail actions -->

                    <!-- Quantity Form -->
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-bold text-slate-500">Quantity</span>
                        <div class="flex items-center border border-slate-300 rounded-xl overflow-hidden h-10 bg-slate-50">
                            <button type="button" @click="quantity > 1 ? quantity-- : null" class="px-3 text-slate-600 font-bold hover:bg-slate-100 transition">&minus;</button>
                            <input type="number" x-model="quantity" class="w-12 border-none text-center bg-transparent focus:ring-0 font-bold text-slate-800 text-sm" readonly>
                            <button type="button" @click="quantity++" class="px-3 text-slate-600 font-bold hover:bg-slate-100 transition">&plus;</button>
                        </div>
                    </div>

                    <!-- Buy Actions -->
                    <div class="flex gap-4">
                        <form action="/cart/add" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" :value="quantity">
                            <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold h-12 rounded-xl transition text-sm">
                                Add to Cart
                            </button>
                        </form>
                        <form action="/buy-now" method="POST" class="flex-1">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" :value="quantity">
                            <button type="submit" class="w-full bg-teal-700 hover:bg-teal-800 text-white font-bold h-12 rounded-xl transition text-sm">
                                Buy Now
                            </button>
                        </form>
                    </div>

                    <!-- Price Summary Block -->
                    <div class="bg-slate-50 border p-5 rounded-2xl space-y-3 text-xs font-semibold text-slate-600">
                        <h4 class="font-bold text-slate-800 text-sm border-b pb-2">Price Summary</h4>
                        <div class="flex justify-between">
                            <span>Price (1 sq.ft)</span>
                            <span class="text-slate-900 font-bold">₹{{ number_format($product->price, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Quantity</span>
                            <span class="text-slate-900 font-bold" x-text="quantity + ' sq.ft'">1 sq.ft</span>
                        </div>
                        <div class="flex justify-between border-t pt-2 text-slate-900 font-bold text-sm">
                            <span>Total (Incl. Tax)</span>
                            <span class="text-teal-700 font-black" x-text="'₹' + totalTax.toFixed(2)">₹60.00</span>
                        </div>
                    </div>

                    <!-- Proceed To Buy & Wishlist -->
                    <div class="space-y-4">
                        <form action="/buy-now" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" :value="quantity">
                            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold h-12 rounded-xl shadow-md transition flex items-center justify-center text-sm">
                                Proceed To Buy
                            </button>
                        </form>
                        
                        <div class="text-center">
                            <a href="/wishlist/add/{{ $product->id }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-red-500 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                <span>Add to Wishlist</span>
                            </a>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <!-- Description, Info & Reviews Tabs -->
        <div class="mt-12 bg-white border border-slate-200 rounded-3xl p-8" x-data="{ activeTab: 'desc' }">
            <div class="flex border-b text-sm font-bold text-slate-400 gap-6">
                <button @click="activeTab = 'desc'" :class="activeTab === 'desc' ? 'border-b-2 border-teal-600 text-teal-700 pb-3' : 'pb-3'" class="focus:outline-none">Description</button>
                <button @click="activeTab = 'info'" :class="activeTab === 'info' ? 'border-b-2 border-teal-600 text-teal-700 pb-3' : 'pb-3'" class="focus:outline-none">Additional Info</button>
                <button @click="activeTab = 'reviews'" :class="activeTab === 'reviews' ? 'border-b-2 border-teal-600 text-teal-700 pb-3' : 'pb-3'" class="focus:outline-none">Reviews (12)</button>
            </div>

            <div class="mt-6 text-sm text-slate-600 leading-relaxed">
                <div x-show="activeTab === 'desc'">
                    <p>{{ $product->description }}</p>
                </div>
                <div x-show="activeTab === 'info'" class="space-y-2">
                    <p><strong>Coverage Area:</strong> {{ $product->coverage_area }}</p>
                    <p><strong>Warranty:</strong> {{ $product->warranty }}</p>
                    <p><strong>Estimated Delivery:</strong> {{ $product->delivery_time }}</p>
                </div>
                <div x-show="activeTab === 'reviews'" class="space-y-4">
                    <div class="border-b pb-4">
                        <p class="font-bold text-slate-800">John Doe <span class="text-xs text-slate-400 font-normal">on July 15, 2026</span></p>
                        <p class="text-xs text-amber-500 font-bold">★★★★★</p>
                        <p class="text-slate-600 text-xs mt-1">Excellent glossy finish! Totally matches my bathroom color choice.</p>
                    </div>
                    <div class="border-b pb-4">
                        <p class="font-bold text-slate-800">Jane Smith <span class="text-xs text-slate-400 font-normal">on July 18, 2026</span></p>
                        <p class="text-xs text-amber-500 font-bold">★★★★☆</p>
                        <p class="text-slate-600 text-xs mt-1">Quality is top notch, slight delay in delivery but very satisfied with the packaging.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tile Calculator -->
        <div class="mt-12 bg-white border border-slate-200 rounded-3xl p-8 shadow-sm" x-data="{
            length: 12,
            width: 10,
            wastage: 10,
            tileAreaSqft: {{ (float) ($product->area_tile_sqft ?: 8) }},
            piecesPerBox: {{ (int) ($product->pieces_per_box ?: 2) }},
            pricePerBox: {{ (float) ($product->price_per_box ?: 0) }},
            estimated: false,
            get roomArea() { return (this.length > 0 && this.width > 0) ? this.length * this.width : 0; },
            get totalArea() { return this.roomArea * (1 + this.wastage / 100); },
            get tilesNeeded() { return this.tileAreaSqft > 0 ? Math.ceil(this.totalArea / this.tileAreaSqft) : 0; },
            get boxesNeeded() { return this.piecesPerBox > 0 ? Math.ceil(this.tilesNeeded / this.piecesPerBox) : 0; },
            get costEstimate() { return this.pricePerBox > 0 ? this.boxesNeeded * this.pricePerBox : 0; }
        }">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tight">Tile Requirement Calculator</h2>
                <p class="text-xs text-slate-400 font-medium mt-1">Estimate how many tiles and boxes you need for your room.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="space-y-4 md:col-span-1">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Room Length (ft)</label>
                        <input type="number" min="0" step="0.1" x-model.number="length" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Room Width (ft)</label>
                        <input type="number" min="0" step="0.1" x-model.number="width" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Wastage %</label>
                            <input type="number" min="0" max="30" x-model.number="wastage" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Tile Area (sq.ft)</label>
                            <input type="number" min="0" step="0.01" x-model.number="tileAreaSqft" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                    </div>
                    <button type="button" @click="estimated = true" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-xl transition text-sm">Calculate</button>
                </div>

                <div class="md:col-span-2 bg-slate-50 border border-slate-200 rounded-2xl p-6" x-show="estimated" x-cloak>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        <div class="bg-white border rounded-xl p-4 shadow-sm">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Room Area</p>
                            <p class="text-xl font-black text-slate-900 mt-1"><span x-text="roomArea.toFixed(2)"></span> <span class="text-xs font-semibold text-slate-400">sq.ft</span></p>
                        </div>
                        <div class="bg-white border rounded-xl p-4">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Area + Wastage</p>
                            <p class="text-xl font-black text-slate-900 mt-1"><span x-text="totalArea.toFixed(2)"></span> <span class="text-xs font-semibold text-slate-400">sq.ft</span></p>
                        </div>
                        <div class="bg-white border rounded-xl p-4">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tiles Needed</p>
                            <p class="text-xl font-black text-teal-700 mt-1" x-text="tilesNeeded"></p>
                        </div>
                        <div class="bg-white border rounded-xl p-4">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Boxes (~{{ $product->pieces_per_box ?: 2 }} / box)</p>
                            <p class="text-xl font-black text-teal-700 mt-1" x-text="boxesNeeded"></p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between bg-white border rounded-xl px-4 py-3" x-show="costEstimate > 0" x-cloak>
                        <p class="text-xs font-bold text-slate-500">Estimated Material Cost (excl. shipping)</p>
                        <p class="text-lg font-black text-slate-900">₹<span x-text="costEstimate.toLocaleString('en-IN', {maximumFractionDigits: 0})"></span></p>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-3">Tip: Always add 5&ndash;10% wastage for cutting and breakage during installation.</p>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
