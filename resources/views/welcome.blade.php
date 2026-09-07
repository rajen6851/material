<x-app-layout>
    <x-slot name="title">PRISTO | Modern Spaces. Timeless Comfort.</x-slot>

    <!-- Main Container -->
    <div class="space-y-10 sm:space-y-16 pb-12 sm:pb-16">

        <!-- 1. HERO SECTION -->
        <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8 pt-4 sm:pt-6 space-y-4">
            
            <!-- Main Split Hero Banner -->
            <div class="grid grid-cols-1 md:grid-cols-12 rounded-2xl sm:rounded-3xl overflow-hidden border border-[#ded7cd] bg-[#eae3d8] shadow-xs min-h-[380px] md:min-h-[460px]">
                
                <!-- Left Content Block (Warm Beige Panel) -->
                <div class="md:col-span-5 flex flex-col justify-center p-6 sm:p-8 md:p-10 lg:p-12 bg-[#eae3d8] relative z-10">
                    <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.22em] text-[#736c63] block mb-2 sm:mb-2.5">
                        LUXURY BATHROOM SOLUTIONS
                    </span>
                    
                    <h1 class="font-serif-pristo text-2xl sm:text-4xl lg:text-[44px] font-bold text-[#171615] leading-[1.15] sm:leading-[1.12] mb-3 sm:mb-3.5">
                        Modern Spaces.<br class="hidden sm:inline">Timeless Comfort.
                    </h1>

                    <p class="text-xs sm:text-sm text-[#615a52] leading-relaxed max-w-md mb-5 sm:mb-6">
                        Premium sanitaryware, tiles, kitchen solutions, faucets and more &mdash; for spaces that inspire.
                    </p>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-3">
                        <a href="/products" style="background-color: #b58d56; color: #ffffff;" class="inline-flex items-center justify-center gap-2 hover:opacity-90 text-xs font-bold uppercase tracking-wider px-5 py-3 rounded-md transition duration-200 shadow-sm text-center">
                            EXPLORE COLLECTION <span class="text-sm font-normal ml-0.5">➔</span>
                        </a>
                        <a href="/showroom-visit/book" style="border-color: #2b2723; color: #171615;" class="inline-flex items-center justify-center gap-2 bg-transparent hover:bg-[#171615]/5 border text-xs font-bold uppercase tracking-wider px-4 py-3 rounded-md transition duration-200 text-center">
                            <svg class="w-3.5 h-3.5 text-[#171615]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            VISIT SHOWROOM
                        </a>
                    </div>
                </div>

                <!-- Right Hero Image -->
                <div class="md:col-span-7 relative min-h-[240px] sm:min-h-[300px] md:min-h-full overflow-hidden">
                    <img src="{{ asset('images/pristo/hero_bathroom.jpg') }}" alt="Luxury Bathroom" class="w-full h-full object-cover object-center transform hover:scale-105 transition duration-700">
                </div>
            </div>

            <!-- Feature / Trust Badges Bar -->
            <div class="bg-[#f5f1eb] rounded-2xl border border-[#ded7cd] p-4 sm:p-6 grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 divide-y-0 lg:divide-x divide-[#ded7cd]">
                
                <!-- 1. Premium Brands -->
                <div class="flex items-center gap-3 sm:gap-4 sm:px-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#eae3d8] flex items-center justify-center text-[#171615] flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#b58d56]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-[#171615]">Premium Brands</h4>
                        <p class="text-[10px] sm:text-[11px] text-[#736c63] mt-0.5">Only the best for your home</p>
                    </div>
                </div>

                <!-- 2. Expert Guidance -->
                <div class="flex items-center gap-3 sm:gap-4 sm:px-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#eae3d8] flex items-center justify-center text-[#171615] flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#b58d56]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-[#171615]">Expert Guidance</h4>
                        <p class="text-[10px] sm:text-[11px] text-[#736c63] mt-0.5">Professional support</p>
                    </div>
                </div>

                <!-- 3. Design Consultation -->
                <div class="flex items-center gap-3 sm:gap-4 sm:px-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#eae3d8] flex items-center justify-center text-[#171615] flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#b58d56]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 4a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2V4zm-6 8a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2v-1zm12 0a2 2 0 114 0v1a2 2 0 01-2 2 2 2 0 01-2-2v-1zM4 19h16"/></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-[#171615]">Design Consultation</h4>
                        <p class="text-[10px] sm:text-[11px] text-[#736c63] mt-0.5">Plan your dream space</p>
                    </div>
                </div>

                <!-- 4. Delivery & Installation -->
                <div class="flex items-center gap-3 sm:gap-4 sm:px-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-[#eae3d8] flex items-center justify-center text-[#171615] flex-shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-[#b58d56]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a2 2 0 104 0m-4 0a2 2 0 114 0m-6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                    </div>
                    <div>
                        <h4 class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-[#171615]">Delivery &amp; Install</h4>
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
                    <h2 class="font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615] mt-1">Design Your Space</h2>
                    <p class="text-xs text-[#736c63] mt-0.5">Explore complete solutions for every corner of your home.</p>
                </div>
                <a href="/products" class="text-xs font-bold text-[#171615] hover:text-[#b58d56] transition inline-flex items-center gap-1">
                    Explore All Spaces ➔
                </a>
            </div>

            <!-- Grid of 4 Space Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($rooms->take(4) as $index => $room)
                <a href="/products?room={{ $room->slug }}" class="group bg-white border border-[#ded7cd] rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition flex flex-col h-full">
                    <div class="aspect-[4/3] bg-[#f5f1eb] relative overflow-hidden">
                        <img src="{{ asset($room->image) }}" alt="{{ $room->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" onerror="this.src='{{ asset('images/pristo/' . ($index == 0 ? 'hero_bathroom.jpg' : ($index == 1 ? 'space_kitchen.jpg' : ($index == 2 ? 'space_living.jpg' : 'space_outdoor.jpg')))) }}'">
                    </div>
                    <div class="p-4 sm:p-5 flex items-start justify-between gap-2 flex-grow bg-white">
                        <div>
                            <h3 class="font-bold text-xs uppercase tracking-wider text-[#171615] group-hover:text-[#b58d56] transition">{{ $room->name }}</h3>
                            <p class="text-[11px] text-[#736c63] leading-snug mt-1">Explore complete solutions for {{ strtolower($room->name) }} space</p>
                        </div>
                        <div class="w-7 h-7 rounded-full border border-[#ded7cd] group-hover:border-[#b58d56] group-hover:bg-[#b58d56] group-hover:text-white text-[#171615] flex items-center justify-center text-xs flex-shrink-0 transition">
                            ➔
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- 3. FEATURED SPOTLIGHT BANNER ("Everything for Your Perfect Bathroom") -->
        <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8">
            <div class="relative bg-[#171615] text-white rounded-2xl sm:rounded-3xl overflow-hidden min-h-[340px] md:min-h-[420px] grid grid-cols-1 md:grid-cols-12 items-center border border-[#2b2825]">
                
                <!-- Left Overlay Content -->
                <div class="md:col-span-5 p-6 sm:p-12 md:p-14 space-y-3 sm:space-y-4 z-10">
                    <span class="text-[10px] font-bold uppercase tracking-[0.25em] text-[#b58d56] block">BATHROOM</span>
                    
                    <h2 class="font-serif-pristo text-2xl sm:text-4xl font-bold leading-tight">
                        Everything for<br>Your Perfect Bathroom
                    </h2>

                    <p class="text-xs sm:text-sm text-[#a39e97] leading-relaxed">
                        From sanitaryware to accessories, we bring together style, quality and functionality &mdash; for a space you'll love.
                    </p>

                    <div class="pt-2">
                        <a href="/products?category=sanitary-ware" style="background-color: #b58d56; color: #ffffff;" class="inline-flex items-center gap-2 hover:opacity-90 text-xs font-bold uppercase tracking-wider px-5 sm:px-6 py-3 sm:py-3.5 rounded-md transition shadow-md">
                            EXPLORE BATHROOM ➔
                        </a>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="md:col-span-7 relative h-full min-h-[220px] sm:min-h-[300px] overflow-hidden">
                    <img src="{{ asset('images/pristo/spotlight_bathroom.jpg') }}" alt="Bathroom Spotlight" class="w-full h-full object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-[#171615] via-[#171615]/60 to-transparent"></div>
                </div>
            </div>
        </div>

        <!-- 4. BATHROOM CATEGORIES SECTION (Interactive Sidebar menu + Subcategories Grid) -->
        <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8 space-y-6" 
             x-data="{ 
                activeTab: 'sanitaryware',
                categoriesData: {
                    sanitaryware: {
                        title: 'Sanitaryware',
                        description: 'Style, hygiene and comfort for every home.',
                        slug: 'sanitary-ware',
                        items: [
                            { name: 'Wall Hung WC', image: '{{ asset('images/pristo/sub_floor_mounted_wc.svg') }}' },
                            { name: 'Floor Mounted WC', image: '{{ asset('images/pristo/sub_floor_mounted_wc.svg') }}' },
                            { name: 'One Piece WC', image: '{{ asset('images/pristo/sub_one_piece_wc.svg') }}' },
                            { name: 'Two Piece WC', image: '{{ asset('images/pristo/sub_two_piece_wc.svg') }}' },
                            { name: 'Urinals', image: '{{ asset('images/pristo/sub_urinal.svg') }}' },
                            { name: 'Cisterns', image: '{{ asset('images/pristo/sub_cistern.svg') }}' }
                        ]
                    },
                    'wash-basins': {
                        title: 'Wash Basins',
                        description: 'Elegant basins designed for modern aesthetics and daily utility.',
                        slug: 'wash-basins',
                        items: [
                            { name: 'Table Top Wash Basin', image: '{{ asset('images/pristo/prod_table_top_basin.svg') }}' },
                            { name: 'Wall Hung Basin', image: '{{ asset('images/pristo/prod_table_top_basin.svg') }}' },
                            { name: 'Pedestal Basin', image: '{{ asset('images/pristo/prod_table_top_basin.svg') }}' },
                            { name: 'Under Counter Basin', image: '{{ asset('images/pristo/prod_table_top_basin.svg') }}' },
                            { name: 'Integrated Vanity Basin', image: '{{ asset('images/pristo/prod_table_top_basin.svg') }}' },
                            { name: 'Corner Basin', image: '{{ asset('images/pristo/prod_table_top_basin.svg') }}' }
                        ]
                    },
                    faucets: {
                        title: 'Faucets',
                        description: 'Precision engineering meets sleek design for effortless water control.',
                        slug: 'faucets',
                        items: [
                            { name: 'Single Lever Basin Mixer', image: '{{ asset('images/pristo/prod_basin_mixer.svg') }}' },
                            { name: 'Tall Body Basin Mixer', image: '{{ asset('images/pristo/prod_basin_mixer.svg') }}' },
                            { name: 'Wall Mounted Mixers', image: '{{ asset('images/pristo/prod_basin_mixer.svg') }}' },
                            { name: 'Thermostatic Bath Mixers', image: '{{ asset('images/pristo/prod_basin_mixer.svg') }}' },
                            { name: 'Sensor Faucets', image: '{{ asset('images/pristo/prod_basin_mixer.svg') }}' },
                            { name: 'Health Faucets', image: '{{ asset('images/pristo/prod_basin_mixer.svg') }}' }
                        ]
                    },
                    showers: {
                        title: 'Showers',
                        description: 'Immerse yourself in pure relaxation with luxury shower systems.',
                        slug: 'showers',
                        items: [
                            { name: 'Shower System', image: '{{ asset('images/pristo/prod_shower_system.svg') }}' },
                            { name: 'Overhead Rain Showers', image: '{{ asset('images/pristo/prod_shower_system.svg') }}' },
                            { name: 'Multi-function Hand Showers', image: '{{ asset('images/pristo/prod_shower_system.svg') }}' },
                            { name: 'Thermostatic Diverters', image: '{{ asset('images/pristo/prod_shower_system.svg') }}' },
                            { name: 'Body Jets', image: '{{ asset('images/pristo/prod_shower_system.svg') }}' },
                            { name: 'Ceiling Mounted Showers', image: '{{ asset('images/pristo/prod_shower_system.svg') }}' }
                        ]
                    },
                    bathtubs: {
                        title: 'Bathtubs',
                        description: 'Ergonomic designs for ultimate relaxation and luxury spa experiences.',
                        slug: 'bathtubs',
                        items: [
                            { name: 'Freestanding Bathtubs', image: '{{ asset('images/pristo/hero_bathroom.jpg') }}' },
                            { name: 'Built-in Bathtubs', image: '{{ asset('images/pristo/spotlight_bathroom.jpg') }}' },
                            { name: 'Whirlpool Massage Tubs', image: '{{ asset('images/pristo/hero_bathroom.jpg') }}' },
                            { name: 'Corner Spa Bathtubs', image: '{{ asset('images/pristo/spotlight_bathroom.jpg') }}' },
                            { name: 'Alcove Bathtubs', image: '{{ asset('images/pristo/hero_bathroom.jpg') }}' },
                            { name: 'Bathtub Spouts & Fillers', image: '{{ asset('images/pristo/prod_basin_mixer.svg') }}' }
                        ]
                    },
                    vanities: {
                        title: 'Vanities & Furniture',
                        description: 'Stylish storage solutions and vanity units tailored to your space.',
                        slug: 'vanities',
                        items: [
                            { name: 'Vanity Unit', image: '{{ asset('images/pristo/prod_vanity_unit.svg') }}' },
                            { name: 'Wall Hung Vanities', image: '{{ asset('images/pristo/prod_vanity_unit.svg') }}' },
                            { name: 'Floor Standing Cabinets', image: '{{ asset('images/pristo/prod_vanity_unit.svg') }}' },
                            { name: 'LED Mirror Cabinets', image: '{{ asset('images/pristo/prod_vanity_unit.svg') }}' },
                            { name: 'Solid Surface Counters', image: '{{ asset('images/pristo/prod_vanity_unit.svg') }}' },
                            { name: 'Tall Side Storage', image: '{{ asset('images/pristo/prod_vanity_unit.svg') }}' }
                        ]
                    },
                    accessories: {
                        title: 'Accessories',
                        description: 'The subtle details that complete your luxury bathroom atmosphere.',
                        slug: 'accessories',
                        items: [
                            { name: 'Towel Bars & Rails', image: '{{ asset('images/pristo/sub_cistern.svg') }}' },
                            { name: 'Robe Hooks', image: '{{ asset('images/pristo/sub_cistern.svg') }}' },
                            { name: 'Paper Holders', image: '{{ asset('images/pristo/sub_cistern.svg') }}' },
                            { name: 'Soap Holders & Dispensers', image: '{{ asset('images/pristo/sub_cistern.svg') }}' },
                            { name: 'Glass Shelves', image: '{{ asset('images/pristo/sub_cistern.svg') }}' },
                            { name: 'Bathroom Mirrors', image: '{{ asset('images/pristo/sub_cistern.svg') }}' }
                        ]
                    },
                    wellness: {
                        title: 'Health & Wellness',
                        description: 'Transform your home into a personal sanctuary for mind and body.',
                        slug: 'wellness',
                        items: [
                            { name: 'Steam Generators & Enclosures', image: '{{ asset('images/pristo/spotlight_bathroom.jpg') }}' },
                            { name: 'Sauna Cabins', image: '{{ asset('images/pristo/spotlight_bathroom.jpg') }}' },
                            { name: 'Smart Electronic Seats', image: '{{ asset('images/pristo/sub_floor_mounted_wc.svg') }}' },
                            { name: 'Jacuzzi Hydro Systems', image: '{{ asset('images/pristo/hero_bathroom.jpg') }}' },
                            { name: 'Chromotherapy Showers', image: '{{ asset('images/pristo/prod_shower_system.svg') }}' },
                            { name: 'Foot Massager Panels', image: '{{ asset('images/pristo/hero_bathroom.jpg') }}' }
                        ]
                    },
                    plumbing: {
                        title: 'Drains & Plumbing',
                        description: 'Robust concealed installation systems, channels and plumbing fittings.',
                        slug: 'plumbing',
                        items: [
                            { name: 'Floor Tile Drains', image: '{{ asset('images/pristo/sub_cistern.svg') }}' },
                            { name: 'Concealed Cistern Frames', image: '{{ asset('images/pristo/sub_cistern.svg') }}' },
                            { name: 'Flush Actuator Plates', image: '{{ asset('images/pristo/sub_cistern.svg') }}' },
                            { name: 'Brass Bottle Traps', image: '{{ asset('images/pristo/sub_cistern.svg') }}' },
                            { name: 'Angle Control Valves', image: '{{ asset('images/pristo/prod_basin_mixer.svg') }}' },
                            { name: 'Drain Grates & Gullies', image: '{{ asset('images/pristo/sub_cistern.svg') }}' }
                        ]
                    }
                }
             }">

            <div class="border-b border-[#ded7cd] pb-3">
                <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#736c63]">BATHROOM CATEGORIES</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8 items-start">
                
                <!-- Left Sidebar Menu Tabs (Scrollable Bar on Mobile, Vertical Stack on Desktop) -->
                <div class="md:col-span-3 bg-[#f7f4ef] border border-[#ded7cd] rounded-2xl p-2 flex md:flex-col overflow-x-auto gap-1.5 md:gap-1 scrollbar-none">
                    <button @click="activeTab = 'sanitaryware'" :class="activeTab === 'sanitaryware' ? 'bg-white text-[#171615] font-bold shadow-xs' : 'text-[#615a52] hover:bg-white/60'" class="whitespace-nowrap md:w-full text-left px-3.5 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs flex items-center justify-between transition flex-shrink-0">
                        <span>Sanitaryware</span>
                        <span x-show="activeTab === 'sanitaryware'" class="hidden md:inline">➔</span>
                    </button>
                    <button @click="activeTab = 'wash-basins'" :class="activeTab === 'wash-basins' ? 'bg-white text-[#171615] font-bold shadow-xs' : 'text-[#615a52] hover:bg-white/60'" class="whitespace-nowrap md:w-full text-left px-3.5 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs flex items-center justify-between transition flex-shrink-0">
                        <span>Wash Basins</span>
                        <span x-show="activeTab === 'wash-basins'" class="hidden md:inline">➔</span>
                    </button>
                    <button @click="activeTab = 'faucets'" :class="activeTab === 'faucets' ? 'bg-white text-[#171615] font-bold shadow-xs' : 'text-[#615a52] hover:bg-white/60'" class="whitespace-nowrap md:w-full text-left px-3.5 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs flex items-center justify-between transition flex-shrink-0">
                        <span>Faucets</span>
                        <span x-show="activeTab === 'faucets'" class="hidden md:inline">➔</span>
                    </button>
                    <button @click="activeTab = 'showers'" :class="activeTab === 'showers' ? 'bg-white text-[#171615] font-bold shadow-xs' : 'text-[#615a52] hover:bg-white/60'" class="whitespace-nowrap md:w-full text-left px-3.5 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs flex items-center justify-between transition flex-shrink-0">
                        <span>Showers</span>
                        <span x-show="activeTab === 'showers'" class="hidden md:inline">➔</span>
                    </button>
                    <button @click="activeTab = 'bathtubs'" :class="activeTab === 'bathtubs' ? 'bg-white text-[#171615] font-bold shadow-xs' : 'text-[#615a52] hover:bg-white/60'" class="whitespace-nowrap md:w-full text-left px-3.5 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs flex items-center justify-between transition flex-shrink-0">
                        <span>Bathtubs</span>
                        <span x-show="activeTab === 'bathtubs'" class="hidden md:inline">➔</span>
                    </button>
                    <button @click="activeTab = 'vanities'" :class="activeTab === 'vanities' ? 'bg-white text-[#171615] font-bold shadow-xs' : 'text-[#615a52] hover:bg-white/60'" class="whitespace-nowrap md:w-full text-left px-3.5 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs flex items-center justify-between transition flex-shrink-0">
                        <span>Vanities &amp; Furniture</span>
                        <span x-show="activeTab === 'vanities'" class="hidden md:inline">➔</span>
                    </button>
                    <button @click="activeTab = 'accessories'" :class="activeTab === 'accessories' ? 'bg-white text-[#171615] font-bold shadow-xs' : 'text-[#615a52] hover:bg-white/60'" class="whitespace-nowrap md:w-full text-left px-3.5 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs flex items-center justify-between transition flex-shrink-0">
                        <span>Accessories</span>
                        <span x-show="activeTab === 'accessories'" class="hidden md:inline">➔</span>
                    </button>
                    <button @click="activeTab = 'wellness'" :class="activeTab === 'wellness' ? 'bg-white text-[#171615] font-bold shadow-xs' : 'text-[#615a52] hover:bg-white/60'" class="whitespace-nowrap md:w-full text-left px-3.5 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs flex items-center justify-between transition flex-shrink-0">
                        <span>Health &amp; Wellness</span>
                        <span x-show="activeTab === 'wellness'" class="hidden md:inline">➔</span>
                    </button>
                    <button @click="activeTab = 'plumbing'" :class="activeTab === 'plumbing' ? 'bg-white text-[#171615] font-bold shadow-xs' : 'text-[#615a52] hover:bg-white/60'" class="whitespace-nowrap md:w-full text-left px-3.5 sm:px-4 py-2.5 sm:py-3 rounded-xl text-xs flex items-center justify-between transition flex-shrink-0">
                        <span>Drains &amp; Plumbing</span>
                        <span x-show="activeTab === 'plumbing'" class="hidden md:inline">➔</span>
                    </button>
                </div>

                <!-- Right Subcategories Dynamic Display Grid -->
                <div class="md:col-span-9 space-y-4 sm:space-y-5">
                    <div class="flex items-center justify-between border-b border-[#ded7cd] pb-3">
                        <div>
                            <h3 class="font-serif-pristo text-xl sm:text-2xl font-bold text-[#171615]" x-text="categoriesData[activeTab].title">Sanitaryware</h3>
                            <p class="text-xs text-[#736c63] mt-0.5" x-text="categoriesData[activeTab].description">Style, hygiene and comfort for every home.</p>
                        </div>
                        <a :href="'/products?category=' + categoriesData[activeTab].slug" class="text-xs font-bold text-[#171615] hover:text-[#b58d56] transition flex items-center gap-1 flex-shrink-0">
                            <span>View All</span> ➔
                        </a>
                    </div>

                    <!-- 6 Grid Subcategory Cards -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3 sm:gap-4">
                        <template x-for="(item, index) in categoriesData[activeTab].items" :key="index">
                            <a :href="'/products?search=' + encodeURIComponent(item.name)" class="group bg-white border border-[#ded7cd] rounded-xl p-2.5 sm:p-3 shadow-2xs hover:shadow-md transition text-center space-y-2 block">
                                <div class="aspect-square bg-[#faf8f5] rounded-lg flex items-center justify-center p-2 overflow-hidden">
                                    <img :src="item.image" :alt="item.name" class="w-full h-full object-contain group-hover:scale-105 transition duration-300">
                                </div>
                                <div class="flex items-center justify-between text-[11px] font-bold text-[#171615] pt-0.5 px-0.5">
                                    <span class="group-hover:text-[#b58d56] transition truncate text-left" x-text="item.name"></span>
                                    <span class="text-xs flex-shrink-0 ml-1">➔</span>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. FEATURED PRODUCTS ("Our Top Picks") -->
        <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8 space-y-6 sm:space-y-8 relative">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-2 border-b border-[#ded7cd] pb-4">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#736c63]">FEATURED PRODUCTS</span>
                    <h2 class="font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615] mt-1">Our Top Picks</h2>
                </div>
                <a href="/products" class="text-xs font-bold text-[#171615] hover:text-[#b58d56] transition inline-flex items-center gap-1">
                    View All Products ➔
                </a>
            </div>

            <!-- Product Cards Responsive Grid (2 columns on mobile, 3 on tablet, 6 on desktop) -->
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-5">
                @forelse($featuredProducts as $product)
                <div class="bg-white border border-[#ded7cd] rounded-xl sm:rounded-2xl overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between group relative p-2.5 sm:p-3">
                    <button class="absolute top-3 right-3 z-10 text-[#736c63] hover:text-red-500 transition" title="Add to wishlist">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </button>
                    <a href="/products/{{ $product->slug }}" class="block aspect-square bg-[#faf8f5] rounded-lg sm:rounded-xl p-2 overflow-hidden mb-2.5">
                        <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain group-hover:scale-105 transition" onerror="this.src='{{ asset('images/pristo/prod_wall_hung_wc.svg') }}'">
                    </a>
                    <div class="space-y-0.5 sm:space-y-1">
                        <h4 class="font-bold text-[11px] sm:text-xs text-[#171615] truncate" title="{{ $product->name }}">{{ $product->name }}</h4>
                        <p class="text-[9px] sm:text-[10px] text-[#736c63] truncate">{{ $product->brand->name ?? 'PRISTO' }} | {{ $product->sub_category ?? $product->category->name ?? 'Luxury' }}</p>
                        <p class="font-bold text-xs text-[#171615] pt-0.5">
                            ₹ {{ number_format($product->price, 0) }}
                            @if($product->price_per_sqft)
                                <span class="text-[9px] font-normal text-[#736c63]">/sq.ft</span>
                            @endif
                        </p>
                    </div>
                    @if(auth()->check() && auth()->user()->isProfessional())
                        <a href="/quotation-requests/create?product_id={{ $product->id }}" style="background-color: #171615; color: #ffffff;" class="mt-2.5 sm:mt-3 w-full block text-center hover:opacity-90 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider py-1.5 sm:py-2 rounded-md transition shadow-xs">
                            REQUEST QUOTE
                        </a>
                    @else
                        <form action="/cart/add" method="POST" class="mt-2.5 sm:mt-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" style="background-color: #b58d56; color: #ffffff;" class="w-full hover:opacity-90 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider py-1.5 sm:py-2 rounded-md transition">
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
            <button class="hidden lg:flex absolute right-0 top-1/2 translate-x-4 -translate-y-1/2 w-8 h-8 rounded-full bg-white border border-[#ded7cd] shadow-md items-center justify-center text-[#171615] hover:bg-[#b58d56] hover:text-white transition z-10" title="Next products">
                ➔
            </button>
        </div>

        <!-- 6. CUSTOM SPACE PLANNER ("Build Your Space") -->
        <div class="max-w-[1550px] mx-auto px-3 sm:px-6 lg:px-8">
            <div class="bg-[#f5f1eb] border border-[#ded7cd] rounded-2xl sm:rounded-3xl p-6 sm:p-10 grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-8 items-center">
                
                <!-- Left Details -->
                <div class="md:col-span-4 space-y-3">
                    <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#736c63] block">CUSTOM SPACE PLANNER</span>
                    <h2 class="font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615]">Build Your Space</h2>
                    <p class="text-xs text-[#615a52] leading-relaxed">
                        Tell us what you need, your style and budget. We'll create a complete design with the right products for your space.
                    </p>
                    <div class="pt-1 sm:pt-2">
                        <a href="/quotation-requests/create" style="background-color: #b58d56; color: #ffffff;" class="inline-flex items-center justify-center w-full sm:w-auto gap-2 hover:opacity-90 text-xs font-bold uppercase tracking-wider px-6 py-3 rounded-md transition shadow-sm text-center">
                            START NOW ➔
                        </a>
                    </div>
                </div>

                <!-- Center 4 Step Process Icons -->
                <div class="md:col-span-8 grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 text-center">
                    
                    <div class="bg-white border border-[#ded7cd] rounded-xl sm:rounded-2xl p-3 sm:p-4 space-y-1.5 sm:space-y-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-[#f5f1eb] border border-[#ded7cd] flex items-center justify-center mx-auto text-[#b58d56] font-bold">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <p class="text-[11px] sm:text-xs font-bold text-[#171615]">1. Select Space</p>
                        <p class="text-[9px] sm:text-[10px] text-[#736c63]">(Bathroom / Kitchen)</p>
                    </div>

                    <div class="bg-white border border-[#ded7cd] rounded-xl sm:rounded-2xl p-3 sm:p-4 space-y-1.5 sm:space-y-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-[#f5f1eb] border border-[#ded7cd] flex items-center justify-center mx-auto text-[#b58d56] font-bold">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                        </div>
                        <p class="text-[11px] sm:text-xs font-bold text-[#171615]">2. Choose Style</p>
                        <p class="text-[9px] sm:text-[10px] text-[#736c63]">(Modern / Classic)</p>
                    </div>

                    <div class="bg-white border border-[#ded7cd] rounded-xl sm:rounded-2xl p-3 sm:p-4 space-y-1.5 sm:space-y-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-[#f5f1eb] border border-[#ded7cd] flex items-center justify-center mx-auto text-[#b58d56] font-bold">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        </div>
                        <p class="text-[11px] sm:text-xs font-bold text-[#171615]">3. Pick Products</p>
                        <p class="text-[9px] sm:text-[10px] text-[#736c63]">(From top brands)</p>
                    </div>

                    <div class="bg-white border border-[#ded7cd] rounded-xl sm:rounded-2xl p-3 sm:p-4 space-y-1.5 sm:space-y-2">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-[#f5f1eb] border border-[#ded7cd] flex items-center justify-center mx-auto text-[#b58d56] font-bold">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"/></svg>
                        </div>
                        <p class="text-[11px] sm:text-xs font-bold text-[#171615]">4. Get Your Plan</p>
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
                    <h2 class="font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615] mt-1">SPACES THAT INSPIRE</h2>
                    <p class="text-xs text-[#736c63] mt-0.5">Real homes. Beautiful spaces. Endless possibilities.</p>
                </div>
                <a href="/products" style="background-color: #b58d56; color: #ffffff;" class="inline-flex items-center justify-center gap-2 hover:opacity-90 text-xs font-bold uppercase tracking-wider px-5 py-2.5 rounded-md transition shadow-xs text-center">
                    EXPLORE ALL LOOKS ➔
                </a>
            </div>

            <!-- Grid of 4 Gallery Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                
                <!-- Gallery 1: Modern Bathroom -->
                <a href="/products" class="group relative rounded-xl sm:rounded-2xl overflow-hidden aspect-[4/3] bg-[#171615] block shadow-sm">
                    <img src="{{ asset('images/pristo/hero_bathroom.jpg') }}" alt="Modern Bathroom" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4 text-white">
                        <h4 class="font-bold text-xs sm:text-sm">Modern Bathroom</h4>
                        <p class="text-[9px] sm:text-[10px] text-[#b58d56] mt-0.5 font-bold">Explore the look ➔</p>
                    </div>
                </a>

                <!-- Gallery 2: Luxury Kitchen -->
                <a href="/products" class="group relative rounded-xl sm:rounded-2xl overflow-hidden aspect-[4/3] bg-[#171615] block shadow-sm">
                    <img src="{{ asset('images/pristo/space_kitchen.jpg') }}" alt="Luxury Kitchen" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4 text-white">
                        <h4 class="font-bold text-xs sm:text-sm">Luxury Kitchen</h4>
                        <p class="text-[9px] sm:text-[10px] text-[#b58d56] mt-0.5 font-bold">Explore the look ➔</p>
                    </div>
                </a>

                <!-- Gallery 3: Contemporary Living -->
                <a href="/products" class="group relative rounded-xl sm:rounded-2xl overflow-hidden aspect-[4/3] bg-[#171615] block shadow-sm">
                    <img src="{{ asset('images/pristo/space_living.jpg') }}" alt="Contemporary Living" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4 text-white">
                        <h4 class="font-bold text-xs sm:text-sm">Contemporary Living</h4>
                        <p class="text-[9px] sm:text-[10px] text-[#b58d56] mt-0.5 font-bold">Explore the look ➔</p>
                    </div>
                </a>

                <!-- Gallery 4: Outdoor Space -->
                <a href="/products" class="group relative rounded-xl sm:rounded-2xl overflow-hidden aspect-[4/3] bg-[#171615] block shadow-sm">
                    <img src="{{ asset('images/pristo/space_outdoor.jpg') }}" alt="Outdoor Space" class="w-full h-full object-cover group-hover:scale-105 transition duration-500 opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4 text-white">
                        <h4 class="font-bold text-xs sm:text-sm">Outdoor Space</h4>
                        <p class="text-[9px] sm:text-[10px] text-[#b58d56] mt-0.5 font-bold">Explore the look ➔</p>
                    </div>
                </a>

            </div>
        </div>

    </div>
</x-app-layout>

