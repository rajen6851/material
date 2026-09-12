<x-app-layout>
    <x-slot name="title">PRISTO | Modern Spaces. Timeless Comfort.</x-slot>

    <!-- Main Container -->
    <div class="space-y-10 sm:space-y-16 pb-12 sm:pb-16">

        <!-- 1. HERO SLIDER SECTION -->
        <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8 pt-4 sm:pt-6 space-y-4">

            <!-- Main Hero Banner Carousel -->
            <div class="relative rounded-2xl sm:rounded-3xl border border-[#ded7cd] shadow-md" id="heroCarousel">

                <!-- Slides wrapper (overflow hidden for clean edges) -->
                <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-[#eae3d8]" style="min-height: 420px;">

                    @forelse($banners as $index => $banner)
                    <div class="hero-slide w-full grid grid-cols-1 md:grid-cols-12"
                         style="min-height:420px; {{ $index > 0 ? 'display:none;' : '' }} transition: opacity 0.7s ease;"
                         data-slide="{{ $index }}">

                        <!-- Left Content -->
                        <div class="md:col-span-5 flex flex-col justify-center p-6 sm:p-8 md:p-10 lg:p-14 bg-[#eae3d8]">
                            <div class="space-y-2.5 sm:space-y-3.5 max-w-lg">
                                <span class="inline-flex items-center gap-2 text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.25em] text-[#736c63]">
                                    <span class="w-2 h-2 rounded-full bg-[#b58d56] animate-ping"></span>
                                    <span>PRISTO CURATED SERIES &bull; 0{{ $loop->iteration }}</span>
                                </span>

                                <h1 class="font-serif-pristo text-2xl sm:text-4xl lg:text-[42px] font-bold text-[#171615] leading-[1.14] sm:leading-[1.12]">
                                    {{ $banner->title }}
                                </h1>

                                <p class="text-xs sm:text-sm text-[#615a52] leading-relaxed">
                                    {{ $banner->subtitle ?? 'Premium sanitaryware, tiles, kitchen solutions, faucets and more.' }}
                                </p>

                                <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3">
                                    <a href="{{ $banner->link ?? '/products' }}"
                                       style="background-color: #b58d56; color: #ffffff;"
                                       class="inline-flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-wider px-6 py-3.5 rounded-xl transition-all duration-300 shadow-md hover:opacity-90 text-center">
                                        <span>EXPLORE COLLECTION</span>
                                        <span class="text-sm font-normal">➔</span>
                                    </a>
                                    <a href="/showroom-visit/book"
                                       style="border: 1.5px solid #2b2723; color: #171615;"
                                       class="inline-flex items-center justify-center gap-2 text-xs font-bold uppercase tracking-wider px-5 py-3.5 rounded-xl transition-all duration-300 text-center hover:bg-[#171615]/5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>VISIT SHOWROOM</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Right Hero Image -->
                        <div class="md:col-span-7 relative overflow-hidden bg-[#171615]" style="min-height:250px;">
                            <img src="{{ asset($banner->image) }}"
                                 alt="{{ $banner->title }}"
                                 class="w-full h-full object-cover object-center"
                                 style="transition: transform 8s ease; transform: scale(1.05);"
                                 onerror="this.src='{{ asset('images/pristo/hero_bathroom.jpg') }}'">
                            <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-[#eae3d8]/70 via-transparent to-transparent pointer-events-none"></div>
                            <!-- Slide counter badge -->
                            <div class="absolute top-4 right-4 hidden sm:block">
                                <span class="bg-[#171615]/80 text-[#c09b5a] text-[10px] font-mono font-bold px-3 py-1.5 rounded-full uppercase tracking-wider border border-white/20">
                                    0{{ $loop->iteration }} / 0{{ $banners->count() }}
                                </span>
                            </div>
                        </div>

                    </div>
                    @empty
                    <div class="grid grid-cols-1 md:grid-cols-12" style="min-height:420px;">
                        <div class="md:col-span-5 flex flex-col justify-center p-8 lg:p-14 bg-[#eae3d8]">
                            <h1 class="font-serif-pristo text-4xl font-bold text-[#171615]">Modern Spaces. Timeless Comfort.</h1>
                            <p class="text-sm text-[#615a52] mt-3">Premium sanitaryware, tiles, kitchen solutions, faucets and more.</p>
                            <a href="/products" class="mt-5 inline-block bg-[#b58d56] text-white px-6 py-3 rounded-xl font-bold text-xs">EXPLORE COLLECTION</a>
                        </div>
                        <div class="md:col-span-7">
                            <img src="{{ asset('images/pristo/hero_bathroom.jpg') }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                    @endforelse

                    <!-- Dot Indicators -->
                    @if($banners->count() > 1)
                    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2 bg-[#171615]/70 px-3.5 py-1.5 rounded-full border border-white/20" id="heroDots">
                        @foreach($banners as $i => $b)
                        <button onclick="heroGoTo({{ $i }})"
                                class="hero-dot h-2 rounded-full transition-all duration-500 focus:outline-none {{ $i === 0 ? 'w-7 bg-[#c09b5a]' : 'w-2 bg-white/40' }}"
                                data-dot="{{ $i }}"
                                aria-label="Go to slide {{ $i + 1 }}"></button>
                        @endforeach
                    </div>
                    @endif

                </div><!-- end overflow-hidden -->
            </div><!-- end carousel -->

            <!-- Vanilla JS Auto Slider -->
            <script>
            (function() {
                var slides = document.querySelectorAll('.hero-slide');
                var dots   = document.querySelectorAll('.hero-dot');
                var total  = slides.length;
                var current = 0;
                var timer;

                if (total <= 1) return;

                function showSlide(n) {
                    slides[current].style.display = 'none';
                    dots[current] && dots[current].classList.replace('w-7','w-2');
                    dots[current] && dots[current].classList.replace('bg-[#c09b5a]','bg-white/40');
                    current = (n + total) % total;
                    slides[current].style.display = '';
                    dots[current] && dots[current].classList.replace('w-2','w-7');
                    dots[current] && dots[current].classList.replace('bg-white/40','bg-[#c09b5a]');
                }

                window.heroGoTo = function(n) {
                    clearInterval(timer);
                    showSlide(n);
                    timer = setInterval(function(){ showSlide(current + 1); }, 5000);
                };

                timer = setInterval(function(){ showSlide(current + 1); }, 5000);

                // Pause on hover
                var carousel = document.getElementById('heroCarousel');
                if (carousel) {
                    carousel.addEventListener('mouseenter', function(){ clearInterval(timer); });
                    carousel.addEventListener('mouseleave', function(){
                        timer = setInterval(function(){ showSlide(current + 1); }, 5000);
                    });
                }
            })();
            </script>



            <!-- Feature / Trust Badges Bar with Micro-Animations -->
            <div class="reveal bg-[#f5f1eb] rounded-2xl border border-[#ded7cd] p-4 sm:p-6 grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 divide-y-0 lg:divide-x divide-[#ded7cd] shadow-xs stagger-parent">
                
                <!-- 1. Premium Brands -->
                <div class="group flex items-center gap-3 sm:gap-4 sm:px-3 hover:-translate-y-1 transition-all duration-300 cursor-default">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#eae3d8] group-hover:bg-[#b58d56] group-hover:text-white flex items-center justify-center text-[#171615] flex-shrink-0 transition-all duration-300 group-hover:rotate-6 group-hover:scale-110 shadow-xs">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#b58d56] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-[#171615] group-hover:text-[#b58d56] transition-colors">Premium Brands</h4>
                        <p class="text-[10px] sm:text-[11px] text-[#736c63] mt-0.5">Only the best for your home</p>
                    </div>
                </div>

                <!-- 2. Expert Guidance -->
                <div class="group flex items-center gap-3 sm:gap-4 sm:px-3 hover:-translate-y-1 transition-all duration-300 cursor-default">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#eae3d8] group-hover:bg-[#b58d56] group-hover:text-white flex items-center justify-center text-[#171615] flex-shrink-0 transition-all duration-300 group-hover:rotate-6 group-hover:scale-110 shadow-xs">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#b58d56] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-[#171615] group-hover:text-[#b58d56] transition-colors">Expert Guidance</h4>
                        <p class="text-[10px] sm:text-[11px] text-[#736c63] mt-0.5">Professional support</p>
                    </div>
                </div>

                <!-- 3. Design Consultation -->
                <div class="group flex items-center gap-3 sm:gap-4 sm:px-3 hover:-translate-y-1 transition-all duration-300 cursor-default">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#eae3d8] group-hover:bg-[#b58d56] group-hover:text-white flex items-center justify-center text-[#171615] flex-shrink-0 transition-all duration-300 group-hover:rotate-6 group-hover:scale-110 shadow-xs">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#b58d56] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 4a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2V4zm-6 8a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2v-1zm12 0a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2v-1zM4 19h16"/></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-[#171615] group-hover:text-[#b58d56] transition-colors">Design Consultation</h4>
                        <p class="text-[10px] sm:text-[11px] text-[#736c63] mt-0.5">Plan your dream space</p>
                    </div>
                </div>

                <!-- 4. Delivery & Installation -->
                <div class="group flex items-center gap-3 sm:gap-4 sm:px-3 hover:-translate-y-1 transition-all duration-300 cursor-default">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#eae3d8] group-hover:bg-[#b58d56] group-hover:text-white flex items-center justify-center text-[#171615] flex-shrink-0 transition-all duration-300 group-hover:rotate-6 group-hover:scale-110 shadow-xs">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#b58d56] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-[#171615] group-hover:text-[#b58d56] transition-colors">Delivery &amp; Install</h4>
                        <p class="text-[10px] sm:text-[11px] text-[#736c63] mt-0.5">Hassle-free support</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. SHOP BY SPACE -->
        <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b border-[#ded7cd] pb-4">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#736c63]">SHOP BY SPACE</span>
                    <h2 class="heading-underline font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615] mt-1">Design Your Space</h2>
                    <p class="text-xs text-[#736c63] mt-0.5">Explore complete solutions for every corner of your home.</p>
                </div>
                <a href="/products" class="group text-xs font-bold text-[#171615] hover:text-[#b58d56] transition inline-flex items-center gap-1.5">
                    <span>Explore All Spaces</span>
                    <span class="transform group-hover:translate-x-1.5 transition-transform duration-300">➔</span>
                </a>
            </div>

            <!-- Grid of 4 Space Cards with Lift & Zoom Animations -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 stagger-parent">
                @foreach($rooms->take(4) as $index => $room)
                <a href="{{ route('rooms.show', $room->slug) }}" class="group bg-white border border-[#ded7cd] hover:border-[#b58d56]/60 rounded-2xl overflow-hidden shadow-xs hover:shadow-xl hover:-translate-y-2 transition-all duration-500 flex flex-col h-full">
                    <div class="aspect-[4/3] bg-[#f5f1eb] relative overflow-hidden">
                        <img src="{{ asset($room->image) }}" alt="{{ $room->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out" onerror="this.src='{{ asset('images/pristo/' . ($index == 0 ? 'hero_bathroom.jpg' : ($index == 1 ? 'space_kitchen.jpg' : ($index == 2 ? 'space_living.jpg' : 'space_outdoor.jpg')))) }}'">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="p-4 sm:p-5 flex items-start justify-between gap-2 flex-grow bg-white group-hover:bg-[#faf8f5] transition-colors duration-300">
                        <div>
                            <h3 class="font-bold text-xs uppercase tracking-wider text-[#171615] group-hover:text-[#b58d56] transition">{{ $room->name }}</h3>
                            <p class="text-[11px] text-[#736c63] leading-snug mt-1">Explore complete solutions for {{ strtolower($room->name) }} space</p>
                        </div>
                        <div class="w-7 h-7 rounded-full border border-[#ded7cd] group-hover:border-[#b58d56] group-hover:bg-[#b58d56] group-hover:text-white text-[#171615] flex items-center justify-center text-xs flex-shrink-0 transition-all duration-300 transform group-hover:translate-x-0.5">
                            ➔
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- 3. FEATURED SPOTLIGHT BANNER ("Everything for Your Perfect Bathroom") -->
        <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8">
            <div class="group relative bg-[#171615] text-white rounded-2xl sm:rounded-3xl overflow-hidden min-h-[340px] md:min-h-[420px] grid grid-cols-1 md:grid-cols-12 items-center border border-[#2b2825] shadow-lg hover:shadow-2xl transition-shadow duration-500 reveal">
                
                <!-- Left Overlay Content -->
                <div class="md:col-span-5 p-6 sm:p-12 md:p-14 space-y-3 sm:space-y-4 z-10">
                    <span class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.25em] text-[#b58d56]">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#b58d56] animate-pulse"></span>
                        <span>BATHROOM SPOTLIGHT</span>
                    </span>
                    
                    <h2 class="font-serif-pristo text-2xl sm:text-4xl font-bold leading-tight">
                        Everything for<br>Your Perfect Bathroom
                    </h2>

                    <p class="text-xs sm:text-sm text-[#a39e97] leading-relaxed">
                        From sanitaryware to accessories, we bring together style, quality and functionality &mdash; for a space you'll love.
                    </p>

                    <div class="pt-2">
                        <a href="/products?category=sanitary-ware" style="background-color: #b58d56; color: #ffffff;" class="inline-flex items-center gap-2 hover:opacity-95 text-xs font-bold uppercase tracking-wider px-6 py-3.5 rounded-xl transition-all duration-300 shadow-md transform hover:scale-105 active:scale-95">
                            <span>EXPLORE BATHROOM</span>
                            <span class="text-sm font-normal">➔</span>
                        </a>
                    </div>
                </div>

                <!-- Right Image with Zoom on Hover -->
                <div class="md:col-span-7 relative h-full min-h-[220px] sm:min-h-[300px] overflow-hidden">
                    <img src="{{ asset('images/pristo/spotlight_bathroom.jpg') }}" alt="Bathroom Spotlight" class="w-full h-full object-cover object-center transform scale-100 group-hover:scale-108 transition-transform duration-1000 ease-out">
                    <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-[#171615] via-[#171615]/60 to-transparent"></div>
                </div>
            </div>
        </div>

        <!-- 4. BATHROOM CATEGORIES SECTION (Interactive Sidebar menu + Subcategories Grid) -->
        <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8 space-y-6" 
             x-data="{ 
                categoriesData: {{ Js::from($bathroomCategoriesData) }},
                activeTab: Object.keys({{ Js::from($bathroomCategoriesData) }})[0] || 'sanitary-ware'
             }">

            <div class="border-b border-[#ded7cd] pb-3">
                <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#736c63]">BATHROOM CATEGORIES</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8 items-start" x-show="categoriesData && Object.keys(categoriesData).length > 0">
                
                <!-- Left Sidebar Menu Tabs (Scrollable Bar on Mobile, Vertical Stack on Desktop) -->
                <div class="md:col-span-3 bg-[#f7f4ef] border border-[#ded7cd] rounded-2xl p-2 flex md:flex-col overflow-x-auto gap-1.5 md:gap-1 scrollbar-none">
                    <template x-for="(cat, slug) in categoriesData" :key="slug">
                        <button @click="activeTab = slug" 
                                :class="activeTab === slug ? 'bg-white text-[#171615] font-bold shadow-xs' : 'text-[#615a52] hover:bg-white/60'" 
                                class="whitespace-nowrap md:w-full text-left px-3.5 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs flex items-center justify-between transition-all duration-200 flex-shrink-0">
                            <span x-text="cat.title"></span>
                            <span x-show="activeTab === slug" class="hidden md:inline font-bold text-[#b58d56]">➔</span>
                        </button>
                    </template>
                </div>

                <!-- Right Subcategories Dynamic Display Grid with Micro-Animations -->
                <div class="md:col-span-9 space-y-4 sm:space-y-5" x-show="categoriesData[activeTab]">
                    <div class="flex items-center justify-between border-b border-[#ded7cd] pb-3">
                        <div>
                            <h3 class="font-serif-pristo text-xl sm:text-2xl font-bold text-[#171615]" x-text="categoriesData[activeTab]?.title"></h3>
                            <p class="text-xs text-[#736c63] mt-0.5" x-text="categoriesData[activeTab]?.description"></p>
                        </div>
                        <a :href="'/products?room=bathroom&category=' + categoriesData[activeTab]?.slug" class="group text-xs font-bold text-[#171615] hover:text-[#b58d56] transition-colors flex items-center gap-1.5 flex-shrink-0">
                            <span>View All</span>
                            <span class="transform group-hover:translate-x-1 transition-transform duration-300">➔</span>
                        </a>
                    </div>

                    <!-- Grid Subcategory Cards with Hover Lift -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3 sm:gap-4">
                        <template x-for="(item, index) in categoriesData[activeTab]?.items" :key="index">
                            <a :href="'/products?room=bathroom&category=' + categoriesData[activeTab]?.slug + '&subcategory=' + encodeURIComponent(item.slug)" 
                               class="group bg-white border border-[#ded7cd] hover:border-[#b58d56] rounded-xl p-2.5 sm:p-3 shadow-2xs hover:shadow-lg hover:-translate-y-1.5 transition-all duration-300 text-center space-y-2 block">
                                <div class="aspect-square bg-[#faf8f5] rounded-lg flex items-center justify-center p-2 overflow-hidden">
                                    <img :src="item.image" :alt="item.name" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500 ease-out">
                                </div>
                                <div class="flex items-center justify-between text-[11px] font-bold text-[#171615] pt-0.5 px-0.5">
                                    <span class="group-hover:text-[#b58d56] transition-colors truncate text-left" x-text="item.name"></span>
                                    <span class="text-xs flex-shrink-0 ml-1 transform group-hover:translate-x-1 group-hover:text-[#b58d56] transition-all duration-300">➔</span>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. FEATURED PRODUCTS ("Our Top Picks") with Hover Micro-Animations -->
        <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8 space-y-6 sm:space-y-8 relative">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b border-[#ded7cd] pb-4">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#736c63]">FEATURED PRODUCTS</span>
                    <h2 class="heading-underline font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615] mt-1">Our Top Picks</h2>
                </div>
                <a href="/products" class="group text-xs font-bold text-[#171615] hover:text-[#b58d56] transition-colors inline-flex items-center gap-1.5">
                    <span>View All Products</span>
                    <span class="transform group-hover:translate-x-1.5 transition-transform duration-300">➔</span>
                </a>
            </div>

            <!-- Product Cards Responsive Grid (Lift on hover + zoom image) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-5 stagger-parent">
                @forelse($featuredProducts as $product)
                <div class="tilt-card bg-white border border-[#ded7cd] hover:border-[#b58d56]/60 rounded-xl sm:rounded-2xl overflow-hidden shadow-xs hover:shadow-xl hover:-translate-y-2 transition-all duration-300 flex flex-col justify-between group relative p-2.5 sm:p-3">
                    <button class="absolute top-3 right-3 z-10 text-[#736c63] hover:text-red-500 hover:scale-125 transition-all duration-200" title="Add to wishlist">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                    <a href="/products/{{ $product->slug }}" class="block aspect-square bg-[#faf8f5] rounded-lg sm:rounded-xl p-2 overflow-hidden mb-2.5">
                        <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-108 transition-transform duration-500 ease-out" onerror="this.src='{{ asset('images/pristo/prod_wall_hung_wc.svg') }}'">
                    </a>
                    <div class="space-y-0.5 sm:space-y-1">
                        <h4 class="font-bold text-[11px] sm:text-xs text-[#171615] group-hover:text-[#b58d56] transition-colors truncate" title="{{ $product->name }}">{{ $product->name }}</h4>
                        <p class="text-[9px] sm:text-[10px] text-[#736c63] truncate">{{ $product->brand->name ?? 'PRISTO' }} | {{ $product->sub_category ?? $product->category->name ?? 'Luxury' }}</p>
                        <p class="font-bold text-xs text-[#171615] pt-0.5">
                            ₹ {{ number_format($product->price, 0) }}
                            @if($product->price_per_sqft)
                                <span class="text-[9px] font-normal text-[#736c63]">/sq.ft</span>
                            @endif
                        </p>
                    </div>
                    @if(auth()->check() && auth()->user()->isProfessional())
                        <a href="/quotation-requests/create?product_id={{ $product->id }}" style="background-color: #171615; color: #ffffff;" class="mt-2.5 sm:mt-3 w-full block text-center hover:opacity-95 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider py-1.5 sm:py-2 rounded-md transition-all duration-200 shadow-xs hover:shadow transform active:scale-95">
                            REQUEST QUOTE
                        </a>
                    @else
                        <form action="/cart/add" method="POST" class="mt-2.5 sm:mt-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" style="background-color: #b58d56; color: #ffffff;" class="w-full hover:opacity-95 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider py-1.5 sm:py-2 rounded-md transition-all duration-200 shadow-xs hover:shadow transform active:scale-95">
                                ADD TO CART
                            </button>
                        </form>
                    @endif
                </div>
                @empty
                <div class="col-span-full text-center py-10 text-[#736c63] text-sm">
                    No featured products found.
                </div>
                @endforelse
            </div>

            <!-- Right Next Chevron floating indicator -->
            <button class="hidden lg:flex absolute right-0 top-1/2 translate-x-4 -translate-y-1/2 w-8 h-8 rounded-full bg-white border border-[#ded7cd] shadow-md items-center justify-center text-[#171615] hover:bg-[#b58d56] hover:text-white transition-all duration-300 transform hover:scale-110 active:scale-95 z-10" title="Next products">
                ➔
            </button>
        </div>

        <!-- 6. CUSTOM SPACE PLANNER ("Build Your Space") -->
        <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8">
            <div class="reveal-zoom bg-[#f5f1eb] border border-[#ded7cd] rounded-2xl sm:rounded-3xl p-6 sm:p-10 grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-8 items-center shadow-xs">
                
                <!-- Left Details -->
                <div class="md:col-span-4 space-y-3">
                    <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#736c63] block">CUSTOM SPACE PLANNER</span>
                    <h2 class="font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615]">Build Your Space</h2>
                    <p class="text-xs text-[#615a52] leading-relaxed">
                        Tell us what you need, your style and budget. We'll create a complete design with the right products for your space.
                    </p>
                    <div class="pt-1 sm:pt-2">
                        <a href="/quotation-requests/create" style="background-color: #b58d56; color: #ffffff;" class="inline-flex items-center justify-center w-full sm:w-auto gap-2 hover:opacity-95 text-xs font-bold uppercase tracking-wider px-6 py-3.5 rounded-xl transition-all duration-300 shadow-md transform hover:scale-105 active:scale-95 text-center">
                            <span>START NOW</span>
                            <span class="text-sm font-normal">➔</span>
                        </a>
                    </div>
                </div>

                <!-- Center 4 Step Process Icons with Micro-Animations -->
                <div class="md:col-span-8 grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 text-center">
                    
                    <div class="group bg-white border border-[#ded7cd] hover:border-[#b58d56] rounded-xl sm:rounded-2xl p-3 sm:p-4 space-y-1.5 sm:space-y-2 hover:-translate-y-1.5 hover:shadow-md transition-all duration-300 cursor-default">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-[#f5f1eb] group-hover:bg-[#b58d56] group-hover:text-white border border-[#ded7cd] group-hover:border-[#b58d56] flex items-center justify-center mx-auto text-[#b58d56] font-bold transition-all duration-300 transform group-hover:rotate-6 group-hover:scale-110">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <p class="text-[11px] sm:text-xs font-bold text-[#171615] group-hover:text-[#b58d56] transition-colors">1. Select Space</p>
                        <p class="text-[9px] sm:text-[10px] text-[#736c63]">(Bathroom / Kitchen)</p>
                    </div>

                    <div class="group bg-white border border-[#ded7cd] hover:border-[#b58d56] rounded-xl sm:rounded-2xl p-3 sm:p-4 space-y-1.5 sm:space-y-2 hover:-translate-y-1.5 hover:shadow-md transition-all duration-300 cursor-default">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-[#f5f1eb] group-hover:bg-[#b58d56] group-hover:text-white border border-[#ded7cd] group-hover:border-[#b58d56] flex items-center justify-center mx-auto text-[#b58d56] font-bold transition-all duration-300 transform group-hover:rotate-6 group-hover:scale-110">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                        </div>
                        <p class="text-[11px] sm:text-xs font-bold text-[#171615] group-hover:text-[#b58d56] transition-colors">2. Choose Style</p>
                        <p class="text-[9px] sm:text-[10px] text-[#736c63]">(Modern / Classic)</p>
                    </div>

                    <div class="group bg-white border border-[#ded7cd] hover:border-[#b58d56] rounded-xl sm:rounded-2xl p-3 sm:p-4 space-y-1.5 sm:space-y-2 hover:-translate-y-1.5 hover:shadow-md transition-all duration-300 cursor-default">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-[#f5f1eb] group-hover:bg-[#b58d56] group-hover:text-white border border-[#ded7cd] group-hover:border-[#b58d56] flex items-center justify-center mx-auto text-[#b58d56] font-bold transition-all duration-300 transform group-hover:rotate-6 group-hover:scale-110">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        </div>
                        <p class="text-[11px] sm:text-xs font-bold text-[#171615] group-hover:text-[#b58d56] transition-colors">3. Pick Products</p>
                        <p class="text-[9px] sm:text-[10px] text-[#736c63]">(From top brands)</p>
                    </div>

                    <div class="group bg-white border border-[#ded7cd] hover:border-[#b58d56] rounded-xl sm:rounded-2xl p-3 sm:p-4 space-y-1.5 sm:space-y-2 hover:-translate-y-1.5 hover:shadow-md transition-all duration-300 cursor-default">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-[#f5f1eb] group-hover:bg-[#b58d56] group-hover:text-white border border-[#ded7cd] group-hover:border-[#b58d56] flex items-center justify-center mx-auto text-[#b58d56] font-bold transition-all duration-300 transform group-hover:rotate-6 group-hover:scale-110">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"/></svg>
                        </div>
                        <p class="text-[11px] sm:text-xs font-bold text-[#171615] group-hover:text-[#b58d56] transition-colors">4. Get Your Plan</p>
                        <p class="text-[9px] sm:text-[10px] text-[#736c63]">(With pricing)</p>
                    </div>

                </div>
            </div>
        </div>

        <!-- 7. INSPIRATION ("SPACES THAT INSPIRE") -->
        <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8 space-y-6 sm:space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b border-[#ded7cd] pb-4">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#736c63]">INSPIRATION</span>
                    <h2 class="heading-underline font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615] mt-1">SPACES THAT INSPIRE</h2>
                    <p class="text-xs text-[#736c63] mt-0.5">Real homes. Beautiful spaces. Endless possibilities.</p>
                </div>
                <a href="/inspiration" style="background-color: #b58d56; color: #ffffff;" class="group inline-flex items-center justify-center gap-2 hover:opacity-95 text-xs font-bold uppercase tracking-wider px-5 py-2.5 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md transform hover:scale-105 active:scale-95 text-center">
                    <span>EXPLORE ALL LOOKS</span>
                    <span class="transform group-hover:translate-x-1 transition-transform duration-300">➔</span>
                </a>
            </div>

            <!-- Grid of 4 Gallery Cards with Smooth Zoom & Slide -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6 stagger-parent">
                
                <!-- Gallery 1: Modern Bathroom -->
                <a href="/inspiration" class="group relative rounded-xl sm:rounded-2xl overflow-hidden aspect-[4/3] bg-[#171615] block shadow-xs hover:shadow-xl hover:-translate-y-2 transition-all duration-500">
                    <img src="{{ asset('images/pristo/hero_bathroom.jpg') }}" alt="Modern Bathroom" class="w-full h-full object-cover group-hover:scale-112 transition-transform duration-700 ease-out opacity-90 group-hover:opacity-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent"></div>
                    <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4 text-white transform group-hover:-translate-y-0.5 transition-transform duration-300">
                        <h4 class="font-bold text-xs sm:text-sm">Modern Bathroom</h4>
                        <p class="text-[9px] sm:text-[10px] text-[#c09b5a] mt-0.5 font-bold flex items-center gap-1">
                            <span>Explore the look</span>
                            <span class="transform group-hover:translate-x-1 transition-transform duration-300">➔</span>
                        </p>
                    </div>
                </a>

                <!-- Gallery 2: Luxury Kitchen -->
                <a href="/inspiration" class="group relative rounded-xl sm:rounded-2xl overflow-hidden aspect-[4/3] bg-[#171615] block shadow-xs hover:shadow-xl hover:-translate-y-2 transition-all duration-500">
                    <img src="{{ asset('images/pristo/space_kitchen.jpg') }}" alt="Luxury Kitchen" class="w-full h-full object-cover group-hover:scale-112 transition-transform duration-700 ease-out opacity-90 group-hover:opacity-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent"></div>
                    <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4 text-white transform group-hover:-translate-y-0.5 transition-transform duration-300">
                        <h4 class="font-bold text-xs sm:text-sm">Luxury Kitchen</h4>
                        <p class="text-[9px] sm:text-[10px] text-[#c09b5a] mt-0.5 font-bold flex items-center gap-1">
                            <span>Explore the look</span>
                            <span class="transform group-hover:translate-x-1 transition-transform duration-300">➔</span>
                        </p>
                    </div>
                </a>

                <!-- Gallery 3: Contemporary Living -->
                <a href="/inspiration" class="group relative rounded-xl sm:rounded-2xl overflow-hidden aspect-[4/3] bg-[#171615] block shadow-xs hover:shadow-xl hover:-translate-y-2 transition-all duration-500">
                    <img src="{{ asset('images/pristo/space_living.jpg') }}" alt="Contemporary Living" class="w-full h-full object-cover group-hover:scale-112 transition-transform duration-700 ease-out opacity-90 group-hover:opacity-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent"></div>
                    <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4 text-white transform group-hover:-translate-y-0.5 transition-transform duration-300">
                        <h4 class="font-bold text-xs sm:text-sm">Contemporary Living</h4>
                        <p class="text-[9px] sm:text-[10px] text-[#c09b5a] mt-0.5 font-bold flex items-center gap-1">
                            <span>Explore the look</span>
                            <span class="transform group-hover:translate-x-1 transition-transform duration-300">➔</span>
                        </p>
                    </div>
                </a>

                <!-- Gallery 4: Outdoor Space -->
                <a href="/inspiration" class="group relative rounded-xl sm:rounded-2xl overflow-hidden aspect-[4/3] bg-[#171615] block shadow-xs hover:shadow-xl hover:-translate-y-2 transition-all duration-500">
                    <img src="{{ asset('images/pristo/space_outdoor.jpg') }}" alt="Outdoor Space" class="w-full h-full object-cover group-hover:scale-112 transition-transform duration-700 ease-out opacity-90 group-hover:opacity-100">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent"></div>
                    <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4 text-white transform group-hover:-translate-y-0.5 transition-transform duration-300">
                        <h4 class="font-bold text-xs sm:text-sm">Outdoor Space</h4>
                        <p class="text-[9px] sm:text-[10px] text-[#c09b5a] mt-0.5 font-bold flex items-center gap-1">
                            <span>Explore the look</span>
                            <span class="transform group-hover:translate-x-1 transition-transform duration-300">➔</span>
                        </p>
                    </div>
                </a>

            </div>
        </div>

    </div>

    {{-- ============================================================
         HOMEPAGE ANIMATIONS — Scroll Reveal + Stagger + Floating
         ============================================================ --}}
    <style>
        /* ── Reveal base ── */
        .reveal {
            opacity: 0;
            transform: translateY(36px);
            transition: opacity 0.72s cubic-bezier(.25,.8,.25,1),
                        transform 0.72s cubic-bezier(.25,.8,.25,1);
        }
        .reveal.visible { opacity: 1; transform: translateY(0); }

        /* ── Reveal from left ── */
        .reveal-left {
            opacity: 0;
            transform: translateX(-40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal-left.visible { opacity: 1; transform: translateX(0); }

        /* ── Reveal from right ── */
        .reveal-right {
            opacity: 0;
            transform: translateX(40px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }
        .reveal-right.visible { opacity: 1; transform: translateX(0); }

        /* ── Stagger delays ── */
        .stagger-1 { transition-delay: 0.05s !important; }
        .stagger-2 { transition-delay: 0.13s !important; }
        .stagger-3 { transition-delay: 0.21s !important; }
        .stagger-4 { transition-delay: 0.29s !important; }
        .stagger-5 { transition-delay: 0.37s !important; }
        .stagger-6 { transition-delay: 0.45s !important; }

        /* ── Section heading underline sweep ── */
        .heading-underline {
            position: relative;
            display: inline-block;
        }
        .heading-underline::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2.5px;
            background: linear-gradient(90deg, #b58d56, #c09b5a);
            border-radius: 2px;
            transition: width 0.8s cubic-bezier(.25,.8,.25,1) 0.3s;
        }
        .heading-underline.visible::after { width: 100%; }

        /* ── Floating badge pulse ── */
        @keyframes floatUp {
            0%, 100% { transform: translateY(0px); }
            50%       { transform: translateY(-8px); }
        }
        .float-badge { animation: floatUp 4s ease-in-out infinite; }

        /* ── Shimmer on hero image ── */
        @keyframes shimmer {
            0%   { background-position: -200% center; }
            100% { background-position: 200% center; }
        }

        /* ── Scale zoom on visible ── */
        .reveal-zoom {
            opacity: 0;
            transform: scale(0.93);
            transition: opacity 0.65s ease, transform 0.65s ease;
        }
        .reveal-zoom.visible { opacity: 1; transform: scale(1); }

        /* ── Smooth number counter ── */
        .count-num { display: inline-block; }

        /* ── Marquee scroll for brands ── */
        @keyframes marquee {
            from { transform: translateX(0); }
            to   { transform: translateX(-50%); }
        }
        .marquee-track {
            display: flex;
            animation: marquee 20s linear infinite;
        }
        .marquee-track:hover { animation-play-state: paused; }
    </style>

    <script>
    (function() {
        // ── 1. Intersection Observer for scroll reveals ──────────────
        var revealClasses = ['.reveal', '.reveal-left', '.reveal-right', '.reveal-zoom', '.heading-underline'];
        var allReveal = document.querySelectorAll(revealClasses.join(','));

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

            allReveal.forEach(function(el) { observer.observe(el); });
        } else {
            // Fallback: show all immediately
            allReveal.forEach(function(el) { el.classList.add('visible'); });
        }

        // ── 2. Stagger children inside .stagger-parent ───────────────
        document.querySelectorAll('.stagger-parent').forEach(function(parent) {
            var children = parent.children;
            Array.from(children).forEach(function(child, i) {
                child.classList.add('reveal');
                child.classList.add('stagger-' + Math.min(i + 1, 6));
                observer && observer.observe(child);
            });
        });

        // ── 3. Floating elements ─────────────────────────────────────
        document.querySelectorAll('.float-badge').forEach(function(el, i) {
            el.style.animationDelay = (i * 0.6) + 's';
        });

        // ── 4. Tilt card effect on product cards ────────────────────
        document.querySelectorAll('.tilt-card').forEach(function(card) {
            card.addEventListener('mousemove', function(e) {
                var rect = card.getBoundingClientRect();
                var x = e.clientX - rect.left - rect.width / 2;
                var y = e.clientY - rect.top  - rect.height / 2;
                var rx = -(y / rect.height) * 8;
                var ry =  (x / rect.width)  * 8;
                card.style.transform = 'perspective(600px) rotateX(' + rx + 'deg) rotateY(' + ry + 'deg) translateY(-4px)';
                card.style.boxShadow = '0 20px 40px rgba(23,22,21,0.13)';
            });
            card.addEventListener('mouseleave', function() {
                card.style.transform = '';
                card.style.boxShadow = '';
                card.style.transition = 'transform 0.5s ease, box-shadow 0.5s ease';
            });
        });


    })();
    </script>

</x-app-layout>
