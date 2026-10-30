<x-app-layout>
    <x-slot name="title">Shipping Policy - Pristo Enterprises</x-slot>

    <!-- Hero Header -->
    <div class="bg-[#171615] text-[#f7f4ef] py-14 md:py-20 border-b border-[#2b2825]">
        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-[#a39e97] text-xs gap-2 items-center mb-4">
                <a href="/" class="hover:text-[#c09b5a] transition">Home</a>
                <span>/</span>
                <span class="text-[#c09b5a] font-semibold">Shipping Policy</span>
            </nav>

            <div class="max-w-3xl space-y-3">
                <span class="text-[10px] uppercase font-bold tracking-[0.28em] text-[#c09b5a] block">LOGISTICS</span>
                <h1 class="font-serif-pristo text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight leading-tight">
                    Shipping Policy
                </h1>
                <p class="text-xs sm:text-sm text-[#a39e97] leading-relaxed pt-1">
                    Details about our delivery areas, timelines, and freight charges for building materials.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        <div class="bg-white border border-[#ded7cd] rounded-3xl p-8 sm:p-12 shadow-xs space-y-8 text-xs sm:text-sm text-[#55504a]">
            
            <section class="space-y-3">
                <h2 class="font-serif-pristo text-xl font-bold text-[#171615]">1. Service Areas</h2>
                <p>Currently, Pristo Enterprises delivers materials exclusively within Bangalore and an agreed 20 KM radius from our primary warehouses.</p>
            </section>

            <section class="space-y-3">
                <h2 class="font-serif-pristo text-xl font-bold text-[#171615]">2. Delivery Timelines</h2>
                <ul class="list-disc pl-5 space-y-2">
                    <li><strong>Piece-based products (Sanitaryware, Faucets):</strong> Next Day or Standard (3-4 Days).</li>
                    <li><strong>Tiles:</strong> Regular orders generally deliver within 3-4 days. Special/Project orders have custom timelines discussed during quotation.</li>
                </ul>
            </section>

            <section class="space-y-3">
                <h2 class="font-serif-pristo text-xl font-bold text-[#171615]">3. Freight & Unloading</h2>
                <p>Heavy materials such as tiles require specialized freight. Shipping charges are calculated dynamically based on weight and distance during checkout. <strong>Note:</strong> Unless specified otherwise, unloading is the responsibility of the buyer at the delivery site.</p>
            </section>

        </div>
    </div>
</x-app-layout>
