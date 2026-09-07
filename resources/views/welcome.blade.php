<x-app-layout>
    <x-slot name="title">PRISTO | Modern Spaces. Timeless Comfort.</x-slot>

    <!-- Main Container -->
    <div class="space-y-16 pb-16">

        <!-- 1. HERO SECTION -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="relative bg-[#171615] rounded-3xl overflow-hidden min-h-[480px] lg:min-h-[520px] flex items-center shadow-lg border border-[#2b2825]">
                
                <!-- Background Image (Right / Cover) -->
                <div class="absolute inset-0 z-0">
                    <img src="{{ asset('images/pristo/hero_bathroom.jpg') }}" alt="Luxury Bathroom" class="w-full h-full object-cover object-right">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#171615] via-[#171615]/70 to-transparent lg:via-[#171615]/40"></div>
                </div>

                <!-- Left Content Card Overlay -->
                <div class="relative z-10 p-6 sm:p-10 lg:p-14 max-w-xl">
                    <div class="bg-[#f4eeea]/95 backdrop-blur-md p-8 sm:p-10 rounded-2xl border border-[#e5ddd5] shadow-xl space-y-4">
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#78716c]">LUXURY BATHROOM SOLUTIONS</p>
                        
                        <h1 class="font-serif-pristo text-3xl sm:text-4xl lg:text-5xl font-bold text-[#171615] leading-tight">
                            Modern Spaces.<br>Timeless Comfort.
                        </h1>

                        <p class="text-xs sm:text-sm text-[#66615b] leading-relaxed">
                            Premium sanitaryware, tiles, kitchen solutions, faucets and more &mdash; for spaces that inspire.
                        </p>

                        <div class="pt-3 flex flex-wrap items-center gap-3">
                            <a href="/products" class="inline-flex items-center gap-2 bg-[#c09b5a] hover:bg-[#a48043] text-white text-xs font-bold uppercase tracking-wider px-6 py-3 rounded-md transition shadow-sm">
                                Explore Collection ➔
                            </a>
                            <a href="/showroom-visit/book" class="inline-flex items-center gap-2 bg-transparent hover:bg-[#171615]/5 border border-[#171615] text-[#171615] text-xs font-bold uppercase tracking-wider px-5 py-3 rounded-md transition">
                                📍 Visit Showroom
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. SHOP BY SPACE -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b border-[#e8e4dc] pb-4">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#78716c]">SHOP BY SPACE</span>
                    <h2 class="font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615] mt-1">Design Your Space</h2>
                    <p class="text-xs text-[#78716c] mt-0.5">Explore complete solutions for every corner of your home.</p>
                </div>
                <a href="/products" class="text-xs font-bold text-[#171615] hover:text-[#c09b5a] transition inline-flex items-center gap-1">
                    Explore All Spaces ➔
                </a>
            </div>

            <!-- Grid of 4 Space Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Card 1: Bathroom -->
                <a href="/products?room=bathroom" class="group bg-white border border-[#e8e4dc] rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col h-full">
                    <div class="aspect-[4/3] bg-[#f5f0ea] relative overflow-hidden">
                        <img src="{{ asset('images/pristo/hero_bathroom.jpg') }}" alt="Bathroom" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-5 flex items-start justify-between gap-2 flex-grow bg-white">
                        <div>
                            <h3 class="font-bold text-sm uppercase tracking-wider text-[#171615] group-hover:text-[#c09b5a] transition">BATHROOM</h3>
                            <p class="text-[11px] text-[#78716c] leading-snug mt-1">Sanitaryware, basins, faucets, showers, bathtubs, accessories &amp; more</p>
                        </div>
                        <div class="w-7 h-7 rounded-full border border-[#e8e4dc] group-hover:border-[#c09b5a] group-hover:bg-[#c09b5a] group-hover:text-white text-[#171615] flex items-center justify-center text-xs flex-shrink-0 transition">
                            ➔
                        </div>
                    </div>
                </a>

                <!-- Card 2: Kitchen -->
                <a href="/products?room=kitchen" class="group bg-white border border-[#e8e4dc] rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col h-full">
                    <div class="aspect-[4/3] bg-[#f5f0ea] relative overflow-hidden">
                        <img src="{{ asset('images/pristo/space_kitchen.jpg') }}" alt="Kitchen" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-5 flex items-start justify-between gap-2 flex-grow bg-white">
                        <div>
                            <h3 class="font-bold text-sm uppercase tracking-wider text-[#171615] group-hover:text-[#c09b5a] transition">KITCHEN</h3>
                            <p class="text-[11px] text-[#78716c] leading-snug mt-1">Sinks, faucets, storage, water solutions &amp; accessories</p>
                        </div>
                        <div class="w-7 h-7 rounded-full border border-[#e8e4dc] group-hover:border-[#c09b5a] group-hover:bg-[#c09b5a] group-hover:text-white text-[#171615] flex items-center justify-center text-xs flex-shrink-0 transition">
                            ➔
                        </div>
                    </div>
                </a>

                <!-- Card 3: Living -->
                <a href="/products?room=living-room" class="group bg-white border border-[#e8e4dc] rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col h-full">
                    <div class="aspect-[4/3] bg-[#f5f0ea] relative overflow-hidden">
                        <img src="{{ asset('images/pristo/space_living.jpg') }}" alt="Living" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-5 flex items-start justify-between gap-2 flex-grow bg-white">
                        <div>
                            <h3 class="font-bold text-sm uppercase tracking-wider text-[#171615] group-hover:text-[#c09b5a] transition">LIVING</h3>
                            <p class="text-[11px] text-[#78716c] leading-snug mt-1">Tiles, wall panels, lighting &amp; decorative surfaces</p>
                        </div>
                        <div class="w-7 h-7 rounded-full border border-[#e8e4dc] group-hover:border-[#c09b5a] group-hover:bg-[#c09b5a] group-hover:text-white text-[#171615] flex items-center justify-center text-xs flex-shrink-0 transition">
                            ➔
                        </div>
                    </div>
                </a>

                <!-- Card 4: Outdoor -->
                <a href="/products?room=outdoor" class="group bg-white border border-[#e8e4dc] rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col h-full">
                    <div class="aspect-[4/3] bg-[#f5f0ea] relative overflow-hidden">
                        <img src="{{ asset('images/pristo/space_outdoor.jpg') }}" alt="Outdoor" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-5 flex items-start justify-between gap-2 flex-grow bg-white">
                        <div>
                            <h3 class="font-bold text-sm uppercase tracking-wider text-[#171615] group-hover:text-[#c09b5a] transition">OUTDOOR</h3>
                            <p class="text-[11px] text-[#78716c] leading-snug mt-1">Parking tiles, outdoor tiles, garden &amp; landscape solutions</p>
                        </div>
                        <div class="w-7 h-7 rounded-full border border-[#e8e4dc] group-hover:border-[#c09b5a] group-hover:bg-[#c09b5a] group-hover:text-white text-[#171615] flex items-center justify-center text-xs flex-shrink-0 transition">
                            ➔
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- 3. FEATURED SPOTLIGHT BANNER ("Everything for Your Perfect Bathroom") -->
        <div class="bg-[#171615] text-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative rounded-3xl overflow-hidden min-h-[420px] flex items-center border border-[#2b2825]">
                    
                    <!-- Background Image -->
                    <div class="absolute inset-0 z-0">
                        <img src="{{ asset('images/pristo/spotlight_bathroom.jpg') }}" alt="Bathroom Spotlight" class="w-full h-full object-cover object-right">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#171615] via-[#171615]/80 to-transparent"></div>
                    </div>

                    <!-- Overlay Box -->
                    <div class="relative z-10 p-8 sm:p-12 max-w-lg">
                        <div class="space-y-4">
                            <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#c09b5a]">BATHROOM</span>
                            
                            <h2 class="font-serif-pristo text-3xl sm:text-4xl font-bold leading-tight">
                                Everything for<br>Your Perfect Bathroom
                            </h2>

                            <p class="text-xs sm:text-sm text-[#a39e97] leading-relaxed">
                                From sanitaryware to accessories, we bring together style, quality and functionality &mdash; for a space you'll love.
                            </p>

                            <div class="pt-2">
                                <a href="/products?category=sanitary-ware" class="inline-flex items-center gap-2 bg-[#c09b5a] hover:bg-[#a48043] text-white text-xs font-bold uppercase tracking-wider px-6 py-3 rounded-md transition shadow-md">
                                    Explore Bathroom ➔
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. BATHROOM CATEGORIES SECTION (Sidebar menu + Subcategories Grid) -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8" x-data="{ activeTab: 'sanitaryware' }">
            <div class="border-b border-[#e8e4dc] pb-3">
                <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#78716c]">BATHROOM CATEGORIES</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
                
                <!-- Left Sidebar Menu Tabs -->
                <div class="bg-white border border-[#e8e4dc] rounded-2xl p-2 space-y-1">
                    <button @click="activeTab = 'sanitaryware'" :class="activeTab === 'sanitaryware' ? 'bg-[#f4eeea] text-[#171615] font-bold border-l-4 border-[#c09b5a]' : 'text-[#66615b] hover:bg-[#faf8f5]'" class="w-full text-left px-4 py-3 rounded-xl text-xs flex items-center justify-between transition">
                        <span>Sanitaryware</span>
                        <span>➔</span>
                    </button>
                    <button @click="activeTab = 'wash-basins'" :class="activeTab === 'wash-basins' ? 'bg-[#f4eeea] text-[#171615] font-bold border-l-4 border-[#c09b5a]' : 'text-[#66615b] hover:bg-[#faf8f5]'" class="w-full text-left px-4 py-3 rounded-xl text-xs flex items-center justify-between transition">
                        <span>Wash Basins</span>
                    </button>
                    <button @click="activeTab = 'faucets'" :class="activeTab === 'faucets' ? 'bg-[#f4eeea] text-[#171615] font-bold border-l-4 border-[#c09b5a]' : 'text-[#66615b] hover:bg-[#faf8f5]'" class="w-full text-left px-4 py-3 rounded-xl text-xs flex items-center justify-between transition">
                        <span>Faucets</span>
                    </button>
                    <button @click="activeTab = 'showers'" :class="activeTab === 'showers' ? 'bg-[#f4eeea] text-[#171615] font-bold border-l-4 border-[#c09b5a]' : 'text-[#66615b] hover:bg-[#faf8f5]'" class="w-full text-left px-4 py-3 rounded-xl text-xs flex items-center justify-between transition">
                        <span>Showers</span>
                    </button>
                    <button @click="activeTab = 'bathtubs'" :class="activeTab === 'bathtubs' ? 'bg-[#f4eeea] text-[#171615] font-bold border-l-4 border-[#c09b5a]' : 'text-[#66615b] hover:bg-[#faf8f5]'" class="w-full text-left px-4 py-3 rounded-xl text-xs flex items-center justify-between transition">
                        <span>Bathtubs</span>
                    </button>
                    <button @click="activeTab = 'vanities'" :class="activeTab === 'vanities' ? 'bg-[#f4eeea] text-[#171615] font-bold border-l-4 border-[#c09b5a]' : 'text-[#66615b] hover:bg-[#faf8f5]'" class="w-full text-left px-4 py-3 rounded-xl text-xs flex items-center justify-between transition">
                        <span>Vanities &amp; Furniture</span>
                    </button>
                    <button @click="activeTab = 'accessories'" :class="activeTab === 'accessories' ? 'bg-[#f4eeea] text-[#171615] font-bold border-l-4 border-[#c09b5a]' : 'text-[#66615b] hover:bg-[#faf8f5]'" class="w-full text-left px-4 py-3 rounded-xl text-xs flex items-center justify-between transition">
                        <span>Accessories</span>
                    </button>
                    <button @click="activeTab = 'wellness'" :class="activeTab === 'wellness' ? 'bg-[#f4eeea] text-[#171615] font-bold border-l-4 border-[#c09b5a]' : 'text-[#66615b] hover:bg-[#faf8f5]'" class="w-full text-left px-4 py-3 rounded-xl text-xs flex items-center justify-between transition">
                        <span>Health &amp; Wellness</span>
                    </button>
                    <button @click="activeTab = 'plumbing'" :class="activeTab === 'plumbing' ? 'bg-[#f4eeea] text-[#171615] font-bold border-l-4 border-[#c09b5a]' : 'text-[#66615b] hover:bg-[#faf8f5]'" class="w-full text-left px-4 py-3 rounded-xl text-xs flex items-center justify-between transition">
                        <span>Drains &amp; Plumbing</span>
                    </button>
                </div>

                <!-- Right Subcategories Display Grid -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="flex items-center justify-between border-b border-[#e8e4dc] pb-3">
                        <div>
                            <h3 class="font-serif-pristo text-2xl font-bold text-[#171615]">Sanitaryware</h3>
                            <p class="text-xs text-[#78716c] mt-0.5">Style, hygiene and comfort for every home.</p>
                        </div>
                        <a href="/products?category=sanitary-ware" class="text-xs font-bold text-[#171615] hover:text-[#c09b5a] transition">
                            View All ➔
                        </a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        
                        <!-- 1. Wall Hung WC -->
                        <a href="/products" class="group bg-white border border-[#e8e4dc] rounded-2xl p-4 shadow-sm hover:shadow-md transition text-center space-y-3 block">
                            <div class="aspect-square bg-[#faf8f5] rounded-xl flex items-center justify-center p-3 overflow-hidden">
                                <img src="{{ asset('images/pristo/prod_wall_hung_wc.jpg') }}" alt="Wall Hung WC" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                            </div>
                            <div class="flex items-center justify-between text-xs font-bold text-[#171615] pt-1 px-1">
                                <span class="group-hover:text-[#c09b5a] transition">Wall Hung WC</span>
                                <span>➔</span>
                            </div>
                        </a>

                        <!-- 2. Floor Mounted WC -->
                        <a href="/products" class="group bg-white border border-[#e8e4dc] rounded-2xl p-4 shadow-sm hover:shadow-md transition text-center space-y-3 block">
                            <div class="aspect-square bg-[#faf8f5] rounded-xl flex items-center justify-center p-3 overflow-hidden">
                                <img src="{{ asset('images/pristo/prod_wall_hung_wc.jpg') }}" alt="Floor Mounted WC" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                            </div>
                            <div class="flex items-center justify-between text-xs font-bold text-[#171615] pt-1 px-1">
                                <span class="group-hover:text-[#c09b5a] transition">Floor Mounted WC</span>
                                <span>➔</span>
                            </div>
                        </a>

                        <!-- 3. One Piece WC -->
                        <a href="/products" class="group bg-white border border-[#e8e4dc] rounded-2xl p-4 shadow-sm hover:shadow-md transition text-center space-y-3 block">
                            <div class="aspect-square bg-[#faf8f5] rounded-xl flex items-center justify-center p-3 overflow-hidden">
                                <img src="{{ asset('images/pristo/prod_wall_hung_wc.jpg') }}" alt="One Piece WC" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                            </div>
                            <div class="flex items-center justify-between text-xs font-bold text-[#171615] pt-1 px-1">
                                <span class="group-hover:text-[#c09b5a] transition">One Piece WC</span>
                                <span>➔</span>
                            </div>
                        </a>

                        <!-- 4. Two Piece WC -->
                        <a href="/products" class="group bg-white border border-[#e8e4dc] rounded-2xl p-4 shadow-sm hover:shadow-md transition text-center space-y-3 block">
                            <div class="aspect-square bg-[#faf8f5] rounded-xl flex items-center justify-center p-3 overflow-hidden">
                                <img src="{{ asset('images/pristo/prod_wall_hung_wc.jpg') }}" alt="Two Piece WC" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                            </div>
                            <div class="flex items-center justify-between text-xs font-bold text-[#171615] pt-1 px-1">
                                <span class="group-hover:text-[#c09b5a] transition">Two Piece WC</span>
                                <span>➔</span>
                            </div>
                        </a>

                        <!-- 5. Urinals -->
                        <a href="/products" class="group bg-white border border-[#e8e4dc] rounded-2xl p-4 shadow-sm hover:shadow-md transition text-center space-y-3 block">
                            <div class="aspect-square bg-[#faf8f5] rounded-xl flex items-center justify-center p-3 overflow-hidden">
                                <img src="{{ asset('images/pristo/prod_wall_hung_wc.jpg') }}" alt="Urinals" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                            </div>
                            <div class="flex items-center justify-between text-xs font-bold text-[#171615] pt-1 px-1">
                                <span class="group-hover:text-[#c09b5a] transition">Urinals</span>
                                <span>➔</span>
                            </div>
                        </a>

                        <!-- 6. Cisterns -->
                        <a href="/products" class="group bg-white border border-[#e8e4dc] rounded-2xl p-4 shadow-sm hover:shadow-md transition text-center space-y-3 block">
                            <div class="aspect-square bg-[#faf8f5] rounded-xl flex items-center justify-center p-3 overflow-hidden">
                                <img src="{{ asset('images/pristo/prod_wall_hung_wc.jpg') }}" alt="Cisterns" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                            </div>
                            <div class="flex items-center justify-between text-xs font-bold text-[#171615] pt-1 px-1">
                                <span class="group-hover:text-[#c09b5a] transition">Cisterns</span>
                                <span>➔</span>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <!-- 5. FEATURED PRODUCTS ("Our Top Picks") -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b border-[#e8e4dc] pb-4">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#78716c]">FEATURED PRODUCTS</span>
                    <h2 class="font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615] mt-1">Our Top Picks</h2>
                </div>
                <a href="/products" class="text-xs font-bold text-[#171615] hover:text-[#c09b5a] transition inline-flex items-center gap-1">
                    View All Products ➔
                </a>
            </div>

            <!-- Product Cards Horizontal Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5">
                
                <!-- Product 1: Wall Hung WC -->
                <div class="bg-white border border-[#e8e4dc] rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between group relative p-3">
                    <button class="absolute top-4 right-4 z-10 text-[#8c857b] hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                    <a href="/products" class="block aspect-square bg-[#faf8f5] rounded-xl p-2 overflow-hidden mb-3">
                        <img src="{{ asset('images/pristo/prod_wall_hung_wc.jpg') }}" alt="Wall Hung WC" class="w-full h-full object-contain group-hover:scale-105 transition">
                    </a>
                    <div class="space-y-1">
                        <h4 class="font-bold text-xs text-[#171615] truncate">Wall Hung WC</h4>
                        <p class="text-[10px] text-[#78716c]">CERA | Modern Collection</p>
                        <p class="font-bold text-xs text-[#171615] pt-1">₹ 18,990</p>
                    </div>
                    <form action="/cart/add" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="product_id" value="1">
                        <button type="submit" class="w-full bg-[#c09b5a] hover:bg-[#a48043] text-white text-[11px] font-bold uppercase tracking-wider py-2 rounded-md transition">
                            ADD TO CART
                        </button>
                    </form>
                </div>

                <!-- Product 2: Single Lever Basin Mixer -->
                <div class="bg-white border border-[#e8e4dc] rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between group relative p-3">
                    <button class="absolute top-4 right-4 z-10 text-[#8c857b] hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                    <a href="/products" class="block aspect-square bg-[#faf8f5] rounded-xl p-2 overflow-hidden mb-3">
                        <img src="{{ asset('images/pristo/prod_basin_mixer.jpg') }}" alt="Single Lever Basin Mixer" class="w-full h-full object-contain group-hover:scale-105 transition">
                    </a>
                    <div class="space-y-1">
                        <h4 class="font-bold text-xs text-[#171615] truncate">Single Lever Basin Mixer</h4>
                        <p class="text-[10px] text-[#78716c]">JAQUAR | Ruby</p>
                        <p class="font-bold text-xs text-[#171615] pt-1">₹ 12,480</p>
                    </div>
                    <form action="/cart/add" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="product_id" value="1">
                        <button type="submit" class="w-full bg-[#c09b5a] hover:bg-[#a48043] text-white text-[11px] font-bold uppercase tracking-wider py-2 rounded-md transition">
                            ADD TO CART
                        </button>
                    </form>
                </div>

                <!-- Product 3: Table Top Wash Basin -->
                <div class="bg-white border border-[#e8e4dc] rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between group relative p-3">
                    <button class="absolute top-4 right-4 z-10 text-[#8c857b] hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                    <a href="/products" class="block aspect-square bg-[#faf8f5] rounded-xl p-2 overflow-hidden mb-3">
                        <img src="{{ asset('images/pristo/prod_wall_hung_wc.jpg') }}" alt="Table Top Wash Basin" class="w-full h-full object-contain group-hover:scale-105 transition">
                    </a>
                    <div class="space-y-1">
                        <h4 class="font-bold text-xs text-[#171615] truncate">Table Top Wash Basin</h4>
                        <p class="text-[10px] text-[#78716c]">TESSA | Premium</p>
                        <p class="font-bold text-xs text-[#171615] pt-1">₹ 8,990</p>
                    </div>
                    <form action="/cart/add" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="product_id" value="1">
                        <button type="submit" class="w-full bg-[#c09b5a] hover:bg-[#a48043] text-white text-[11px] font-bold uppercase tracking-wider py-2 rounded-md transition">
                            ADD TO CART
                        </button>
                    </form>
                </div>

                <!-- Product 4: Shower System -->
                <div class="bg-white border border-[#e8e4dc] rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between group relative p-3">
                    <button class="absolute top-4 right-4 z-10 text-[#8c857b] hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                    <a href="/products" class="block aspect-square bg-[#faf8f5] rounded-xl p-2 overflow-hidden mb-3">
                        <img src="{{ asset('images/pristo/prod_basin_mixer.jpg') }}" alt="Shower System" class="w-full h-full object-contain group-hover:scale-105 transition">
                    </a>
                    <div class="space-y-1">
                        <h4 class="font-bold text-xs text-[#171615] truncate">Shower System</h4>
                        <p class="text-[10px] text-[#78716c]">GEBERIT | Classic</p>
                        <p class="font-bold text-xs text-[#171615] pt-1">₹ 25,990</p>
                    </div>
                    <form action="/cart/add" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="product_id" value="1">
                        <button type="submit" class="w-full bg-[#c09b5a] hover:bg-[#a48043] text-white text-[11px] font-bold uppercase tracking-wider py-2 rounded-md transition">
                            ADD TO CART
                        </button>
                    </form>
                </div>

                <!-- Product 5: Porcelain Tile 600x1200 -->
                <div class="bg-white border border-[#e8e4dc] rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between group relative p-3">
                    <button class="absolute top-4 right-4 z-10 text-[#8c857b] hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                    <a href="/products" class="block aspect-square bg-[#faf8f5] rounded-xl p-2 overflow-hidden mb-3">
                        <img src="{{ asset('images/pristo/hero_bathroom.jpg') }}" alt="Porcelain Tile" class="w-full h-full object-cover group-hover:scale-105 transition">
                    </a>
                    <div class="space-y-1">
                        <h4 class="font-bold text-xs text-[#171615] truncate">Porcelain Tile 600x1200</h4>
                        <p class="text-[10px] text-[#78716c]">KAJARIA | Marble Look</p>
                        <p class="font-bold text-xs text-[#171615] pt-1">₹ 1,290 <span class="text-[9px] font-normal text-[#78716c]">/sq.ft</span></p>
                    </div>
                    <form action="/cart/add" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="product_id" value="1">
                        <button type="submit" class="w-full bg-[#c09b5a] hover:bg-[#a48043] text-white text-[11px] font-bold uppercase tracking-wider py-2 rounded-md transition">
                            ADD TO CART
                        </button>
                    </form>
                </div>

                <!-- Product 6: Vanity Unit -->
                <div class="bg-white border border-[#e8e4dc] rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between group relative p-3">
                    <button class="absolute top-4 right-4 z-10 text-[#8c857b] hover:text-red-500 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                    <a href="/products" class="block aspect-square bg-[#faf8f5] rounded-xl p-2 overflow-hidden mb-3">
                        <img src="{{ asset('images/pristo/spotlight_bathroom.jpg') }}" alt="Vanity Unit" class="w-full h-full object-cover group-hover:scale-105 transition">
                    </a>
                    <div class="space-y-1">
                        <h4 class="font-bold text-xs text-[#171615] truncate">Vanity Unit</h4>
                        <p class="text-[10px] text-[#78716c]">PRESTO Collection</p>
                        <p class="font-bold text-xs text-[#171615] pt-1">₹ 32,990</p>
                    </div>
                    <form action="/cart/add" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="product_id" value="1">
                        <button type="submit" class="w-full bg-[#c09b5a] hover:bg-[#a48043] text-white text-[11px] font-bold uppercase tracking-wider py-2 rounded-md transition">
                            ADD TO CART
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <!-- 6. CUSTOM SPACE PLANNER ("Build Your Space") -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#f4eeea] border border-[#e5ddd5] rounded-3xl p-8 sm:p-12 grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                
                <!-- Left Details -->
                <div class="space-y-4">
                    <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#78716c]">CUSTOM SPACE PLANNER</span>
                    <h2 class="font-serif-pristo text-3xl font-bold text-[#171615]">Build Your Space</h2>
                    <p class="text-xs text-[#66615b] leading-relaxed">
                        Tell us what you need, your style and budget. We'll create a complete design with the right products for your space.
                    </p>
                    <div class="pt-2">
                        <a href="/quotation-requests/create" class="inline-flex items-center gap-2 bg-[#c09b5a] hover:bg-[#a48043] text-white text-xs font-bold uppercase tracking-wider px-6 py-3 rounded-md transition shadow-sm">
                            START NOW ➔
                        </a>
                    </div>
                </div>

                <!-- Center 4 Step Process Icons -->
                <div class="lg:col-span-2 grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                    
                    <div class="space-y-2">
                        <div class="w-12 h-12 rounded-full bg-white border border-[#e2ddd5] flex items-center justify-center mx-auto text-[#c09b5a] font-bold">
                            ♨
                        </div>
                        <p class="text-xs font-bold text-[#171615]">1. Select Space</p>
                        <p class="text-[10px] text-[#78716c]">(Bathroom / Kitchen / Living / Outdoor)</p>
                    </div>

                    <div class="space-y-2">
                        <div class="w-12 h-12 rounded-full bg-white border border-[#e2ddd5] flex items-center justify-center mx-auto text-[#c09b5a] font-bold">
                            ⚙
                        </div>
                        <p class="text-xs font-bold text-[#171615]">2. Choose Style</p>
                        <p class="text-[10px] text-[#78716c]">(Modern / Classic / Luxury)</p>
                    </div>

                    <div class="space-y-2">
                        <div class="w-12 h-12 rounded-full bg-white border border-[#e2ddd5] flex items-center justify-center mx-auto text-[#c09b5a] font-bold">
                            88
                        </div>
                        <p class="text-xs font-bold text-[#171615]">3. Pick Products</p>
                        <p class="text-[10px] text-[#78716c]">(From top brands)</p>
                    </div>

                    <div class="space-y-2">
                        <div class="w-12 h-12 rounded-full bg-white border border-[#e2ddd5] flex items-center justify-center mx-auto text-[#c09b5a] font-bold">
                            📋
                        </div>
                        <p class="text-xs font-bold text-[#171615]">4. Get Your Plan</p>
                        <p class="text-[10px] text-[#78716c]">(With pricing)</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- 7. INSPIRATION ("SPACES THAT INSPIRE") -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b border-[#e8e4dc] pb-4">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#78716c]">INSPIRATION</span>
                    <h2 class="font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615] mt-1">SPACES THAT INSPIRE</h2>
                    <p class="text-xs text-[#78716c] mt-0.5">Real homes. Beautiful spaces. Endless possibilities.</p>
                </div>
                <a href="/products" class="inline-flex items-center gap-2 bg-[#c09b5a] hover:bg-[#a48043] text-white text-xs font-bold uppercase tracking-wider px-5 py-2.5 rounded-md transition">
                    EXPLORE ALL LOOKS ➔
                </a>
            </div>

            <!-- Grid of 4 Gallery Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Gallery 1: Modern Bathroom -->
                <a href="/products" class="group relative rounded-2xl overflow-hidden aspect-[4/3] bg-[#171615] block shadow-sm">
                    <img src="{{ asset('images/pristo/hero_bathroom.jpg') }}" alt="Modern Bathroom" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="font-bold text-sm">Modern Bathroom</h4>
                        <p class="text-[10px] text-[#c09b5a] mt-0.5">Explore the look ➔</p>
                    </div>
                </a>

                <!-- Gallery 2: Luxury Kitchen -->
                <a href="/products" class="group relative rounded-2xl overflow-hidden aspect-[4/3] bg-[#171615] block shadow-sm">
                    <img src="{{ asset('images/pristo/space_kitchen.jpg') }}" alt="Luxury Kitchen" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="font-bold text-sm">Luxury Kitchen</h4>
                        <p class="text-[10px] text-[#c09b5a] mt-0.5">Explore the look ➔</p>
                    </div>
                </a>

                <!-- Gallery 3: Contemporary Living -->
                <a href="/products" class="group relative rounded-2xl overflow-hidden aspect-[4/3] bg-[#171615] block shadow-sm">
                    <img src="{{ asset('images/pristo/space_living.jpg') }}" alt="Contemporary Living" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="font-bold text-sm">Contemporary Living</h4>
                        <p class="text-[10px] text-[#c09b5a] mt-0.5">Explore the look ➔</p>
                    </div>
                </a>

                <!-- Gallery 4: Outdoor Space -->
                <a href="/products" class="group relative rounded-2xl overflow-hidden aspect-[4/3] bg-[#171615] block shadow-sm">
                    <img src="{{ asset('images/pristo/space_outdoor.jpg') }}" alt="Outdoor Space" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 text-white">
                        <h4 class="font-bold text-sm">Outdoor Space</h4>
                        <p class="text-[10px] text-[#c09b5a] mt-0.5">Explore the look ➔</p>
                    </div>
                </a>

            </div>
        </div>

    </div>
</x-app-layout>
