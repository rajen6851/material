<x-app-layout>
    <x-slot name="title">Work Gallery & Design Inspirations - Pristo Enterprises</x-slot>

    <!-- Hero Header -->
    <div class="bg-[#171615] text-[#f7f4ef] py-14 md:py-20 border-b border-[#2b2825]">
        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-[#a39e97] text-xs gap-2 items-center mb-4">
                <a href="/" class="hover:text-[#c09b5a] transition">Home</a>
                <span>/</span>
                <span class="text-[#c09b5a] font-semibold">Work Gallery</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-3 max-w-3xl">
                    <span class="text-[10px] uppercase font-bold tracking-[0.28em] text-[#c09b5a] block">PORTFOLIO &amp; REAL PROJECTS</span>
                    <h1 class="font-serif-pristo text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white tracking-tight leading-tight">
                        Our Work &amp; Inspirations
                    </h1>
                    <p class="text-xs sm:text-sm text-[#a39e97] leading-relaxed pt-1">
                        Explore our curated gallery of completed architectural installations, luxury bathroom sanctuaries, designer kitchens, and expansive porcelain surfaces executed across premier residences.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="/showroom-visit/book" 
                       class="inline-flex items-center gap-2 bg-[#c09b5a] hover:bg-[#a48043] text-white font-bold px-6 py-3.5 rounded-xl text-xs uppercase tracking-wider shadow-md transition">
                        <span>Book Showroom Consultation</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.__GALLERY_PROJECTS__ = @json($allProjects);
    </script>

    <!-- Main Content Area -->
    <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 space-y-12" 
         x-data="{ 
            selectedFilter: '{{ $activeFilter }}',
            activeModal: null
         }">

        <!-- Filter Pills Bar -->
        <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none border-b border-[#ded7cd]">
            <button type="button" 
                    @click="selectedFilter = 'all'" 
                    :class="selectedFilter === 'all' ? 'bg-[#171615] text-white' : 'bg-white text-[#55504a] hover:bg-[#f5f0ea] border border-[#ded7cd]'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-2 flex-shrink-0">
                <span>All Projects</span>
                <span class="text-[10px] px-2 py-0.5 rounded-full" :class="selectedFilter === 'all' ? 'bg-[#c09b5a] text-white' : 'bg-slate-100 text-slate-600'">
                    {{ count($allProjects) }}
                </span>
            </button>

            <button type="button" 
                    @click="selectedFilter = 'bathroom'" 
                    :class="selectedFilter === 'bathroom' ? 'bg-[#171615] text-white' : 'bg-white text-[#55504a] hover:bg-[#f5f0ea] border border-[#ded7cd]'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-2 flex-shrink-0">
                <span>Bathrooms</span>
                <span class="text-[10px] px-2 py-0.5 rounded-full" :class="selectedFilter === 'bathroom' ? 'bg-[#c09b5a] text-white' : 'bg-slate-100 text-slate-600'">
                    {{ count(array_filter($allProjects, fn($p) => $p['space'] === 'bathroom')) }}
                </span>
            </button>

            <button type="button" 
                    @click="selectedFilter = 'living-room'" 
                    :class="selectedFilter === 'living-room' ? 'bg-[#171615] text-white' : 'bg-white text-[#55504a] hover:bg-[#f5f0ea] border border-[#ded7cd]'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-2 flex-shrink-0">
                <span>Living Rooms</span>
                <span class="text-[10px] px-2 py-0.5 rounded-full" :class="selectedFilter === 'living-room' ? 'bg-[#c09b5a] text-white' : 'bg-slate-100 text-slate-600'">
                    {{ count(array_filter($allProjects, fn($p) => $p['space'] === 'living-room')) }}
                </span>
            </button>

            <button type="button" 
                    @click="selectedFilter = 'kitchen'" 
                    :class="selectedFilter === 'kitchen' ? 'bg-[#171615] text-white' : 'bg-white text-[#55504a] hover:bg-[#f5f0ea] border border-[#ded7cd]'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-2 flex-shrink-0">
                <span>Kitchens</span>
                <span class="text-[10px] px-2 py-0.5 rounded-full" :class="selectedFilter === 'kitchen' ? 'bg-[#c09b5a] text-white' : 'bg-slate-100 text-slate-600'">
                    {{ count(array_filter($allProjects, fn($p) => $p['space'] === 'kitchen')) }}
                </span>
            </button>

            <button type="button" 
                    @click="selectedFilter = 'outdoor'" 
                    :class="selectedFilter === 'outdoor' ? 'bg-[#171615] text-white' : 'bg-white text-[#55504a] hover:bg-[#f5f0ea] border border-[#ded7cd]'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-2 flex-shrink-0">
                <span>Outdoor &amp; Deck</span>
                <span class="text-[10px] px-2 py-0.5 rounded-full" :class="selectedFilter === 'outdoor' ? 'bg-[#c09b5a] text-white' : 'bg-slate-100 text-slate-600'">
                    {{ count(array_filter($allProjects, fn($p) => $p['space'] === 'outdoor')) }}
                </span>
            </button>

            <button type="button" 
                    @click="selectedFilter = 'commercial'" 
                    :class="selectedFilter === 'commercial' ? 'bg-[#171615] text-white' : 'bg-white text-[#55504a] hover:bg-[#f5f0ea] border border-[#ded7cd]'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition flex items-center gap-2 flex-shrink-0">
                <span>Commercial</span>
                <span class="text-[10px] px-2 py-0.5 rounded-full" :class="selectedFilter === 'commercial' ? 'bg-[#c09b5a] text-white' : 'bg-slate-100 text-slate-600'">
                    {{ count(array_filter($allProjects, fn($p) => $p['space'] === 'commercial')) }}
                </span>
            </button>
        </div>

        <!-- Project Cards Grid (Pure Server-Side Blade Rendering with Instant Images) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($allProjects as $project)
                <div x-show="selectedFilter === 'all' || selectedFilter === '{{ $project['space'] }}'" 
                     class="group bg-white border border-[#ded7cd] hover:border-[#c09b5a] rounded-3xl overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col justify-between"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100">
                    
                    <!-- Cover Image with Location Badge -->
                    <div class="relative aspect-[16/10] bg-[#f5f1eb] overflow-hidden cursor-pointer" 
                         @click="activeModal = (window.__GALLERY_PROJECTS__ || []).find(p => p.id === {{ $project['id'] }})">
                        <img src="{{ asset($project['image']) }}" 
                             alt="{{ $project['title'] }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-[#171615]/80 via-transparent to-transparent opacity-60 group-hover:opacity-85 transition-opacity"></div>
                        
                        <!-- Badges -->
                        <div class="absolute top-4 left-4 flex gap-2">
                            <span class="bg-[#171615]/85 backdrop-blur-xs text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-white/20">
                                {{ $project['space_name'] }}
                            </span>
                        </div>

                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <span class="text-[10px] font-medium text-[#c09b5a] uppercase tracking-wider block">
                                {{ $project['location'] }}
                            </span>
                            <h3 class="font-serif-pristo text-lg sm:text-xl font-bold truncate mt-0.5">
                                {{ $project['title'] }}
                            </h3>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                        <div class="space-y-3">
                            <p class="text-xs text-[#55504a] leading-relaxed">
                                {{ $project['description'] }}
                            </p>

                            <!-- Materials Breakdown Tags -->
                            <div class="pt-2 border-t border-[#f0ebe3]">
                                <span class="text-[9px] uppercase font-bold tracking-wider text-[#a8a29e] block mb-2">Materials &amp; Fixtures Used:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($project['materials'] as $mat)
                                        <span class="text-[10px] bg-[#f7f4ef] text-[#2b2825] px-2.5 py-1 rounded-md border border-[#e8e2d8] font-medium">
                                            {{ $mat }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Card Action Buttons -->
                        <div class="pt-4 border-t border-[#ded7cd] flex items-center justify-between gap-3">
                            <a href="{{ $project['products_url'] }}" 
                               class="text-xs font-bold text-[#171615] hover:text-[#c09b5a] transition flex items-center gap-1">
                                <span>View Products</span>
                                <span>➔</span>
                            </a>
                            <a href="/quotation-requests/create" 
                               style="background-color: #171615; color: #ffffff;"
                               class="text-[10px] uppercase font-bold tracking-wider px-3.5 py-2 rounded-lg hover:bg-[#b58d56] transition shadow-xs">
                                Request Quote
                            </a>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <!-- Lightbox / Modal for Project Details -->
        <div x-show="activeModal" 
             class="fixed inset-0 z-50 bg-[#171615]/85 backdrop-blur-sm flex items-center justify-center p-4" 
             x-cloak 
             @click.self="activeModal = null" 
             @keydown.escape.window="activeModal = null">
            
            <div class="bg-white rounded-3xl max-w-4xl w-full overflow-hidden shadow-2xl border border-[#ded7cd] max-h-[90vh] flex flex-col" @click.stop>
                
                <!-- Modal Top Header -->
                <div class="flex items-center justify-between p-5 border-b border-[#ded7cd]">
                    <div>
                        <span class="text-[10px] font-bold text-[#c09b5a] uppercase tracking-wider" x-text="activeModal?.type + ' • ' + activeModal?.location"></span>
                        <h3 class="font-serif-pristo text-xl sm:text-2xl font-bold text-[#171615]" x-text="activeModal?.title"></h3>
                    </div>
                    <button @click="activeModal = null" class="w-8 h-8 rounded-full bg-[#f5f1eb] hover:bg-[#171615] hover:text-white transition flex items-center justify-center font-bold text-sm">
                        ✕
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6 overflow-y-auto space-y-6">
                    <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-[#f5f1eb]">
                        <img :src="'/' + activeModal?.image" :alt="activeModal?.title" class="w-full h-full object-cover">
                    </div>

                    <div class="space-y-3">
                        <h4 class="font-serif-pristo text-lg font-bold text-[#171615]">Design Overview</h4>
                        <p class="text-xs sm:text-sm text-[#55504a] leading-relaxed" x-text="activeModal?.description"></p>
                    </div>

                    <div class="space-y-3 bg-[#faf8f5] p-5 rounded-2xl border border-[#ded7cd]">
                        <h4 class="font-serif-pristo text-sm font-bold text-[#171615]">Key Specifications &amp; Surfaces</h4>
                        <ul class="space-y-2 text-xs text-[#55504a]">
                            <template x-for="(mat, idx) in activeModal?.materials" :key="idx">
                                <li class="flex items-start gap-2">
                                    <span class="text-[#c09b5a] font-bold">✓</span>
                                    <span x-text="mat"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-5 border-t border-[#ded7cd] bg-[#f9f7f4] flex flex-col sm:flex-row items-center justify-between gap-3">
                    <span class="text-xs text-[#736c63]">Interested in recreating this concept for your space?</span>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <a href="/showroom-visit/book" class="flex-1 sm:flex-initial text-center bg-white border border-[#ded7cd] hover:border-[#c09b5a] text-[#171615] font-bold text-xs px-4 py-2.5 rounded-xl transition">
                            Book Showroom Visit
                        </a>
                        <a :href="activeModal?.products_url" style="background-color: #171615; color: #ffffff;" class="flex-1 sm:flex-initial text-center text-xs font-bold px-5 py-2.5 rounded-xl hover:bg-[#b58d56] transition shadow-xs">
                            Shop Materials ➔
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- Bottom Callout Section -->
        <div class="bg-[#171615] text-white rounded-3xl p-8 sm:p-12 relative overflow-hidden">
            <div class="relative z-10 max-w-2xl space-y-4">
                <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#c09b5a] block">BESPOKE ARCHITECTURAL ASSISTANCE</span>
                <h2 class="font-serif-pristo text-2xl sm:text-3xl md:text-4xl font-bold tracking-tight">
                    Have an Architectural Vision? Let's Build It.
                </h2>
                <p class="text-xs sm:text-sm text-[#a39e97] leading-relaxed">
                    Whether you are an architect curating an entire development or a homeowner transforming your private sanctuary, our technical team provides samples, CAD cut-sheets, and bespoke trade pricing.
                </p>
                <div class="pt-2 flex flex-wrap gap-4">
                    <a href="/showroom-visit/book" style="background-color: #c09b5a; color: #ffffff;" class="inline-flex items-center gap-2 hover:opacity-90 font-bold px-6 py-3.5 rounded-xl text-xs uppercase tracking-wider transition shadow-md">
                        <span>Book Showroom Visit (User &amp; B2B)</span>
                        <span>➔</span>
                    </a>
                    <a href="/quotation-requests/create" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 text-white font-bold px-6 py-3.5 rounded-xl text-xs uppercase tracking-wider transition border border-white/20">
                        <span>Request Custom Quotation</span>
                    </a>
                </div>
            </div>

            <!-- Subtle background aesthetic overlay -->
            <div class="absolute right-0 top-0 bottom-0 w-1/3 opacity-20 pointer-events-none hidden md:block">
                <img src="/images/gallery/project_bathroom.jpg" alt="Watermark" class="w-full h-full object-cover">
            </div>
        </div>

    </div>
</x-app-layout>
