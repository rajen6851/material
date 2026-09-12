<x-app-layout>
    <x-slot name="title">Contact Us & Experience Center - Pristo Enterprises</x-slot>

    <!-- Hero Header -->
    <div class="bg-[#171615] text-[#f7f4ef] py-14 md:py-20 border-b border-[#2b2825]">
        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-[#a39e97] text-xs gap-2 items-center mb-4">
                <a href="/" class="hover:text-[#c09b5a] transition">Home</a>
                <span>/</span>
                <span class="text-[#c09b5a] font-semibold">Contact Us</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="space-y-3 max-w-3xl">
                    <span class="text-[10px] uppercase font-bold tracking-[0.28em] text-[#c09b5a] block">CLIENT SERVICES &amp; SHOWROOM</span>
                    <h1 class="font-serif-pristo text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white tracking-tight leading-tight">
                        Connect with Pristo
                    </h1>
                    <p class="text-xs sm:text-sm text-[#a39e97] leading-relaxed pt-1">
                        Whether you are an architect detailing custom project specifications or a homeowner curating your dream bath &amp; living space, our material experts are here to assist.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="/showroom-visit/book" 
                       class="inline-flex items-center gap-2 bg-[#c09b5a] hover:bg-[#a48043] text-white font-bold px-6 py-3.5 rounded-xl text-xs uppercase tracking-wider shadow-md transition">
                        <span>Book Showroom Visit</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        
        @if(session('success'))
            <div class="mb-8 p-4 bg-[#f5f0ea] border-l-4 border-[#c09b5a] rounded-r-2xl text-[#171615] flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-[#c09b5a] text-white flex items-center justify-center font-bold text-sm">✓</span>
                    <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <!-- Left Info Panel (5 cols) -->
            <div class="lg:col-span-5 space-y-8">
                <div class="bg-white border border-[#ded7cd] rounded-3xl p-8 shadow-xs space-y-6">
                    <div>
                        <span class="text-[10px] uppercase font-bold tracking-[0.2em] text-[#c09b5a] block mb-1">EXPERIENCE CENTER</span>
                        <h2 class="font-serif-pristo text-2xl font-bold text-[#171615]">Pristo Flagship Studio</h2>
                        <p class="text-xs text-[#55504a] mt-2 leading-relaxed">
                            Touch and feel over 500+ premium porcelain slabs, designer sanitaryware, freestanding tubs, and brass fittings in person.
                        </p>
                    </div>

                    <div class="space-y-4 pt-2 border-t border-[#f0ebe3]">
                        <div class="flex items-start gap-3.5 text-xs text-[#333]">
                            <div class="w-9 h-9 rounded-xl bg-[#f7f4ef] border border-[#e8e2d8] flex items-center justify-center text-[#c09b5a] flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <span class="font-bold text-[#171615] block">Location</span>
                                <span class="text-[#666]">Bangalore City, Karnataka, India</span>
                                <span class="text-[11px] text-[#8c857b] block mt-0.5">Central Hub with Curbside Freight &amp; Warehousing</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5 text-xs text-[#333]">
                            <div class="w-9 h-9 rounded-xl bg-[#f7f4ef] border border-[#e8e2d8] flex items-center justify-center text-[#c09b5a] flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <span class="font-bold text-[#171615] block">Phone &amp; WhatsApp Concierge</span>
                                <a href="tel:+916362346660" class="hover:text-[#c09b5a] font-semibold transition text-sm">+91 63623 46660</a>
                                <span class="text-[11px] text-[#8c857b] block mt-0.5">Mon to Sat: 9:30 AM – 7:30 PM</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3.5 text-xs text-[#333]">
                            <div class="w-9 h-9 rounded-xl bg-[#f7f4ef] border border-[#e8e2d8] flex items-center justify-center text-[#c09b5a] flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <span class="font-bold text-[#171615] block">Direct Email</span>
                                <a href="mailto:pristoenterprises@gmail.com" class="hover:text-[#c09b5a] transition">pristoenterprises@gmail.com</a>
                                <span class="text-[11px] text-[#8c857b] block mt-0.5">For official BOQs, CAD drawings, and trade inquiries</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Specialized Support Desks -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-[#f7f4ef] border border-[#e8e2d8] rounded-2xl p-5 space-y-2">
                        <span class="text-[10px] uppercase font-bold tracking-wider text-[#c09b5a] block">ARCHITECTS &amp; B2B</span>
                        <h4 class="font-bold text-xs text-[#171615]">Trade Account Desk</h4>
                        <p class="text-[11px] text-[#666] leading-relaxed">
                            Project sampling, GST invoicing, site delivery scheduling, and volume wholesale pricing.
                        </p>
                    </div>

                    <div class="bg-[#f7f4ef] border border-[#e8e2d8] rounded-2xl p-5 space-y-2">
                        <span class="text-[10px] uppercase font-bold tracking-wider text-[#c09b5a] block">LOGISTICS &amp; FREIGHT</span>
                        <h4 class="font-bold text-xs text-[#171615]">Delivery Desk</h4>
                        <p class="text-[11px] text-[#666] leading-relaxed">
                            Specialized hydraulic tail-lift vehicles &amp; crate handling across Bangalore and Karnataka.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Form (7 cols) -->
            <div class="lg:col-span-7 bg-white border border-[#ded7cd] rounded-3xl p-8 sm:p-10 shadow-sm space-y-6">
                <div>
                    <span class="text-[10px] uppercase font-bold tracking-[0.2em] text-[#c09b5a] block mb-1">INQUIRY FORM</span>
                    <h2 class="font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615]">Send a Message</h2>
                    <p class="text-xs text-[#55504a] mt-1">
                        Fill out the details below and an experienced materials specialist will get back to you with guidance and cut-sheets.
                    </p>
                </div>

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Full Name -->
                        <div class="space-y-1.5">
                            <label for="name" class="block text-xs font-bold uppercase tracking-wider text-[#55504a]">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', auth()->user()?->name) }}" 
                                   placeholder="e.g. Rahul Sharma" 
                                   required 
                                   class="w-full bg-[#faf8f5] border border-[#ded7cd] focus:border-[#c09b5a] focus:bg-white rounded-xl px-4 py-3 text-xs text-[#171615] focus:outline-none transition">
                            @error('name')
                                <p class="text-[11px] text-red-500 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="space-y-1.5">
                            <label for="email" class="block text-xs font-bold uppercase tracking-wider text-[#55504a]">
                                Email Address <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', auth()->user()?->email) }}" 
                                   placeholder="e.g. rahul@example.com" 
                                   required 
                                   class="w-full bg-[#faf8f5] border border-[#ded7cd] focus:border-[#c09b5a] focus:bg-white rounded-xl px-4 py-3 text-xs text-[#171615] focus:outline-none transition">
                            @error('email')
                                <p class="text-[11px] text-red-500 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Phone / Mobile -->
                        <div class="space-y-1.5">
                            <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-[#55504a]">
                                Mobile / WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', auth()->user()?->mobile) }}" 
                                   placeholder="+91 98765 43210" 
                                   required 
                                   class="w-full bg-[#faf8f5] border border-[#ded7cd] focus:border-[#c09b5a] focus:bg-white rounded-xl px-4 py-3 text-xs text-[#171615] focus:outline-none transition">
                            @error('phone')
                                <p class="text-[11px] text-red-500 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Inquiry Type -->
                        <div class="space-y-1.5">
                            <label for="inquiry_type" class="block text-xs font-bold uppercase tracking-wider text-[#55504a]">
                                Purpose of Inquiry <span class="text-red-500">*</span>
                            </label>
                            <select id="inquiry_type" 
                                    name="inquiry_type" 
                                    required 
                                    class="w-full bg-[#faf8f5] border border-[#ded7cd] focus:border-[#c09b5a] focus:bg-white rounded-xl px-4 py-3 text-xs text-[#171615] focus:outline-none transition">
                                <option value="General Inquiry" {{ old('inquiry_type') == 'General Inquiry' ? 'selected' : '' }}>General Inquiry</option>
                                <option value="Showroom Visit Request" {{ old('inquiry_type') == 'Showroom Visit Request' ? 'selected' : '' }}>Showroom Consultation</option>
                                <option value="Architect & Contractor Trade Desk" {{ old('inquiry_type') == 'Architect & Contractor Trade Desk' ? 'selected' : '' }}>Architect &amp; B2B Trade Pricing</option>
                                <option value="Bulk Quotation (BOQ)" {{ old('inquiry_type') == 'Bulk Quotation (BOQ)' ? 'selected' : '' }}>Bulk Material Quotation (BOQ)</option>
                                <option value="Order & Shipping Support" {{ old('inquiry_type') == 'Order & Shipping Support' ? 'selected' : '' }}>Order Status &amp; Shipping Support</option>
                            </select>
                            @error('inquiry_type')
                                <p class="text-[11px] text-red-500 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Subject -->
                    <div class="space-y-1.5">
                        <label for="subject" class="block text-xs font-bold uppercase tracking-wider text-[#55504a]">
                            Subject <span class="text-[#8c857b] font-normal lowercase">(optional)</span>
                        </label>
                        <input type="text" 
                               id="subject" 
                               name="subject" 
                               value="{{ old('subject') }}" 
                               placeholder="e.g. Requirement for 600x1200mm porcelain tiles for villa project" 
                               class="w-full bg-[#faf8f5] border border-[#ded7cd] focus:border-[#c09b5a] focus:bg-white rounded-xl px-4 py-3 text-xs text-[#171615] focus:outline-none transition">
                    </div>

                    <!-- Message -->
                    <div class="space-y-1.5">
                        <label for="message" class="block text-xs font-bold uppercase tracking-wider text-[#55504a]">
                            Your Requirement / Message <span class="text-red-500">*</span>
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="5" 
                                  required 
                                  placeholder="Describe the rooms, square footage, specific brands or finishes you are looking for..." 
                                  class="w-full bg-[#faf8f5] border border-[#ded7cd] focus:border-[#c09b5a] focus:bg-white rounded-xl p-4 text-xs text-[#171615] focus:outline-none transition leading-relaxed">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-[11px] text-red-500 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <button type="submit" 
                                style="background-color: #171615; color: #ffffff;" 
                                class="w-full sm:w-auto px-8 py-4 rounded-xl text-xs uppercase font-bold tracking-wider hover:bg-[#b58d56] transition shadow-md flex items-center justify-center gap-2">
                            <span>Submit Inquiry</span>
                            <span>➔</span>
                        </button>
                        <span class="text-[11px] text-[#8c857b]">
                            Our advisors reply within 24 business hours.
                        </span>
                    </div>
                </form>
            </div>

        </div>

    </div>
</x-app-layout>
