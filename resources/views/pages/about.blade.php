<x-app-layout>
    <x-slot name="title">About Pristo - Architecture, Vitrified Surfaces & Luxury Bathrooms</x-slot>

    <!-- Hero Header -->
    <div class="bg-[#171615] text-[#f7f4ef] py-16 md:py-24 border-b border-[#2b2825] relative overflow-hidden">
        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <nav class="flex text-[#a39e97] text-xs gap-2 items-center mb-4">
                <a href="/" class="hover:text-[#c09b5a] transition">Home</a>
                <span>/</span>
                <span class="text-[#c09b5a] font-semibold">About Us</span>
            </nav>

            <div class="max-w-3xl space-y-4">
                <span class="text-[10px] uppercase font-bold tracking-[0.3em] text-[#c09b5a] block">SPACES INSPIRED • SINCE ESTABLISHMENT</span>
                <h1 class="font-serif-pristo text-3xl sm:text-5xl md:text-6xl font-bold text-white tracking-tight leading-tight">
                    Architectural Precision. <br><span class="text-[#c09b5a] italic font-normal">Timeless Craft.</span>
                </h1>
                <p class="text-xs sm:text-base text-[#a39e97] leading-relaxed pt-2">
                    Pristo was founded to bridge the gap between discerning architectural vision and high-performance building materials. We curate world-class glazed vitrified surfaces, Italian marble porcelain slabs, sculptural sanitaryware, and precision bath fittings.
                </p>
            </div>
        </div>

        <!-- Subtle aesthetic background glow -->
        <div class="absolute -right-20 -bottom-20 w-96 h-96 bg-[#c09b5a]/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Main Content -->
    <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 space-y-20">
        
        <!-- Story & Philosophy Split Section -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-6 space-y-6">
                <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#c09b5a] block">OUR PHILOSOPHY</span>
                <h2 class="font-serif-pristo text-3xl sm:text-4xl font-bold text-[#171615] tracking-tight leading-snug">
                    We believe materials should endure beyond trends.
                </h2>
                <div class="space-y-4 text-xs sm:text-sm text-[#55504a] leading-relaxed">
                    <p>
                        A home is an enduring sanctuary; a commercial development is a public statement. Too often, projects are compromised by inconsistent tile calibers, mismatched grout lines, and fragile finishes.
                    </p>
                    <p>
                        At Pristo, every single collection is hand-vetted for rigorous technical benchmarks: water absorption below 0.05%, Mohs hardness for scratch resistance, rectitude of edges, and exquisite depth of glaze.
                    </p>
                    <p>
                        From large-format 800x1600mm bookmatched slabs that flow seamlessly across double-height living rooms to anti-microbial rimless ceramic sanitaryware, Pristo provides complete surface harmony under one roof.
                    </p>
                </div>

                <div class="pt-2 flex flex-wrap gap-4">
                    <a href="/inspiration" class="inline-flex items-center gap-2 bg-[#171615] hover:bg-[#c09b5a] text-white font-bold px-6 py-3.5 rounded-xl text-xs uppercase tracking-wider transition shadow-md">
                        <span>View Completed Projects</span>
                        <span>➔</span>
                    </a>
                    <a href="/showroom-visit/book" class="inline-flex items-center gap-2 bg-white border border-[#ded7cd] hover:border-[#c09b5a] text-[#171615] font-bold px-6 py-3.5 rounded-xl text-xs uppercase tracking-wider transition">
                        <span>Book Showroom Consultation</span>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-6 grid grid-cols-2 gap-4">
                <div class="aspect-[4/5] rounded-3xl overflow-hidden bg-[#e8e2d8] shadow-sm">
                    <img src="/images/gallery/project_bathroom.jpg" alt="Pristo Luxury Bathroom" class="w-full h-full object-cover">
                </div>
                <div class="aspect-[4/5] rounded-3xl overflow-hidden bg-[#e8e2d8] shadow-sm mt-8">
                    <img src="/images/gallery/project_living.jpg" alt="Pristo Large Format Slab Living" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <!-- Four Pillars of Pristo -->
        <div class="space-y-10">
            <div class="text-center max-w-2xl mx-auto space-y-3">
                <span class="text-[10px] uppercase font-bold tracking-[0.25em] text-[#c09b5a] block">THE PRISTO ADVANTAGE</span>
                <h3 class="font-serif-pristo text-2xl sm:text-3xl md:text-4xl font-bold text-[#171615]">
                    Why Architects &amp; Homeowners Partner With Us
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Pillar 1 -->
                <div class="bg-white border border-[#ded7cd] hover:border-[#c09b5a] p-8 rounded-3xl space-y-4 shadow-xs hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-[#f7f4ef] border border-[#e8e2d8] flex items-center justify-center text-[#c09b5a]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h4 class="font-serif-pristo font-bold text-lg text-[#171615]">Direct Sourcing</h4>
                    <p class="text-xs text-[#55504a] leading-relaxed">
                        Eliminating intermediaries allows us to guarantee single-batch shade consistency, fresh production runs, and genuine wholesale pricing.
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="bg-white border border-[#ded7cd] hover:border-[#c09b5a] p-8 rounded-3xl space-y-4 shadow-xs hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-[#f7f4ef] border border-[#e8e2d8] flex items-center justify-center text-[#c09b5a]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    </div>
                    <h4 class="font-serif-pristo font-bold text-lg text-[#171615]">Caliber &amp; Shade Grading</h4>
                    <p class="text-xs text-[#55504a] leading-relaxed">
                        Every tile order is dispatched from a uniform production batch with matched tone ratings to eliminate unsightly color variance across broad floor expanses.
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="bg-white border border-[#ded7cd] hover:border-[#c09b5a] p-8 rounded-3xl space-y-4 shadow-xs hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-[#f7f4ef] border border-[#e8e2d8] flex items-center justify-center text-[#c09b5a]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h4 class="font-serif-pristo font-bold text-lg text-[#171615]">Architect &amp; B2B Desk</h4>
                    <p class="text-xs text-[#55504a] leading-relaxed">
                        Dedicated trade accounts, cut-piece sample delivery to your studio, detailed technical datasheets, and responsive Bill-of-Quantities (BOQ) turnaround.
                    </p>
                </div>

                <!-- Pillar 4 -->
                <div class="bg-white border border-[#ded7cd] hover:border-[#c09b5a] p-8 rounded-3xl space-y-4 shadow-xs hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-[#f7f4ef] border border-[#e8e2d8] flex items-center justify-center text-[#c09b5a]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                    </div>
                    <h4 class="font-serif-pristo font-bold text-lg text-[#171615]">Safe Palletized Freight</h4>
                    <p class="text-xs text-[#55504a] leading-relaxed">
                        Heavy ceramics require heavy-duty care. We deliver via specialized palletized crating with fair, transparent shipping charges calculated at actuals.
                    </p>
                </div>
            </div>
        </div>

        <!-- Metrics Strip -->
        <div class="bg-[#171615] text-white rounded-3xl p-10 sm:p-14 grid grid-cols-2 md:grid-cols-4 gap-8 text-center border border-[#2b2825]">
            <div class="space-y-1">
                <span class="font-serif-pristo text-3xl sm:text-4xl md:text-5xl font-bold text-[#c09b5a]">500+</span>
                <p class="text-xs sm:text-sm text-[#a39e97] uppercase tracking-wider">Curated Surfaces</p>
            </div>
            <div class="space-y-1">
                <span class="font-serif-pristo text-3xl sm:text-4xl md:text-5xl font-bold text-[#c09b5a]">1200+</span>
                <p class="text-xs sm:text-sm text-[#a39e97] uppercase tracking-wider">Executed Projects</p>
            </div>
            <div class="space-y-1">
                <span class="font-serif-pristo text-3xl sm:text-4xl md:text-5xl font-bold text-[#c09b5a]">100%</span>
                <p class="text-xs sm:text-sm text-[#a39e97] uppercase tracking-wider">Batch Inspected</p>
            </div>
            <div class="space-y-1">
                <span class="font-serif-pristo text-3xl sm:text-4xl md:text-5xl font-bold text-[#c09b5a]">24h</span>
                <p class="text-xs sm:text-sm text-[#a39e97] uppercase tracking-wider">BOQ Turnaround</p>
            </div>
        </div>

        <!-- Callout to Visit Showroom -->
        <div class="bg-[#f7f4ef] border border-[#ded7cd] rounded-3xl p-8 sm:p-12 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-2 max-w-2xl">
                <span class="text-[10px] uppercase font-bold tracking-[0.2em] text-[#c09b5a] block">EXPERIENCE CENTER</span>
                <h3 class="font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615]">
                    Experience Our Surfaces In Person
                </h3>
                <p class="text-xs sm:text-sm text-[#55504a] leading-relaxed">
                    Walk through fully realized mock-up bathrooms, full slab vertical displays, and custom brass fixtures at our Bangalore flagship studio. Both homeowners and trade professionals are welcome.
                </p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
                <a href="/showroom-visit/book" 
                   style="background-color: #171615; color: #ffffff;" 
                   class="w-full sm:w-auto text-center px-6 py-3.5 rounded-xl text-xs uppercase font-bold tracking-wider hover:bg-[#b58d56] transition shadow-md">
                    Schedule Showroom Visit
                </a>
                <a href="/contact" 
                   class="w-full sm:w-auto text-center px-6 py-3.5 rounded-xl text-xs uppercase font-bold tracking-wider bg-white border border-[#ded7cd] hover:border-[#c09b5a] text-[#171615] transition">
                    Contact Us
                </a>
            </div>
        </div>

    </div>
</x-app-layout>
