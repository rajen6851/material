@php
    $isLoggedIn = auth()->check();
    $userRole = $isLoggedIn ? (auth()->user()->isProfessional() ? 'professional' : 'homeowner') : 'homeowner';
    $defaultCompany = $isLoggedIn ? (auth()->user()->company_name ?? '') : '';
    $defaultName = $isLoggedIn ? auth()->user()->name : '';
    $defaultMobile = $isLoggedIn ? (auth()->user()->phone ?? '') : '';
    $defaultEmail = $isLoggedIn ? auth()->user()->email : '';
@endphp

<x-app-layout>
    <x-slot name="title">Book Showroom Experience - Pristo Luxury Hub</x-slot>

    <!-- Hero Header -->
    <div class="bg-[#171615] text-[#f7f4ef] py-12 md:py-16 border-b border-[#2b2825]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-3">
            <span class="text-[10px] uppercase font-bold tracking-[0.28em] text-[#c09b5a] block">PRISTO EXPERIENCE CENTRE</span>
            <h1 class="font-serif-pristo text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight">
                Book a Showroom Visit
            </h1>
            <p class="text-xs sm:text-sm text-[#a39e97] max-w-xl mx-auto leading-relaxed">
                Step inside our immersive materials studio. Touch, feel, and inspect Italian marble, vitrified tiles, sanitaryware, and luxury faucets with our technical specialists.
            </p>
        </div>
    </div>

    <!-- Booking Form Container -->
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16" 
         x-data="{ 
            visitorRole: '{{ old('role', $userRole) }}',
            purpose: '{{ old('purpose', '') }}'
         }">
        
        @if(session('success'))
            <div class="mb-8 p-5 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-start gap-4">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 flex-shrink-0 font-bold">✓</div>
                <div>
                    <h3 class="text-sm font-bold text-emerald-900">Booking Request Received!</h3>
                    <p class="text-xs text-emerald-700 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white border border-[#ded7cd] rounded-3xl p-6 sm:p-10 shadow-sm space-y-8">
            
            <!-- Step 1: Visitor Role Selection (User vs B2B) -->
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <label class="text-[11px] font-bold uppercase tracking-wider text-[#171615] block">
                        1. Who Are You Visiting As? <span class="text-red-500">*</span>
                    </label>
                    <span class="text-[10px] text-[#736c63]">Select your visitor profile</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Option A: Homeowner / Individual (B2C) -->
                    <button type="button" 
                            @click="visitorRole = 'homeowner'" 
                            :class="visitorRole === 'homeowner' ? 'border-[#c09b5a] bg-[#faf7f2] shadow-sm ring-1 ring-[#c09b5a]' : 'border-[#ded7cd] bg-white hover:border-[#b58d56]/50'" 
                            class="p-5 rounded-2xl border text-left transition duration-200 relative group flex flex-col justify-between">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-2xl">🏠</span>
                                <span x-show="visitorRole === 'homeowner'" class="w-4 h-4 rounded-full bg-[#c09b5a] text-white text-[10px] flex items-center justify-center">✓</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-[#171615]">Homeowner / Individual (B2C)</h4>
                                <p class="text-xs text-[#736c63] mt-1 leading-relaxed">
                                    Planning personal home construction, bathroom renovation, or tile selection with our design adviser.
                                </p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-[#c09b5a] uppercase tracking-wider mt-3 inline-block">Personal Visit</span>
                    </button>

                    <!-- Option B: Trade Professional / B2B -->
                    <button type="button" 
                            @click="visitorRole = 'professional'" 
                            :class="visitorRole === 'professional' ? 'border-[#c09b5a] bg-[#faf7f2] shadow-sm ring-1 ring-[#c09b5a]' : 'border-[#ded7cd] bg-white hover:border-[#b58d56]/50'" 
                            class="p-5 rounded-2xl border text-left transition duration-200 relative group flex flex-col justify-between">
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-2xl">🏢</span>
                                <span x-show="visitorRole === 'professional'" class="w-4 h-4 rounded-full bg-[#c09b5a] text-white text-[10px] flex items-center justify-center">✓</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-[#171615]">Architect / Designer / B2B Trade</h4>
                                <p class="text-xs text-[#736c63] mt-1 leading-relaxed">
                                    Architects, interior designers, builders, and contractors seeking project quotes, sample libraries & wholesale trade desk.
                                </p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold text-[#c09b5a] uppercase tracking-wider mt-3 inline-block">B2B Trade Session</span>
                    </button>
                </div>
            </div>

            <form action="{{ route('showroom.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="role" :value="visitorRole">

                <!-- Conditional B2B Company Details -->
                <div x-show="visitorRole === 'professional'" x-cloak class="p-5 bg-[#faf8f5] border border-[#ded7cd] rounded-2xl space-y-4">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-[#c09b5a] block">B2B Trade Information</span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-[#55504a] uppercase mb-1">Company / Studio / Firm Name</label>
                            <input type="text" name="company_name" value="{{ old('company_name', $defaultCompany) }}" placeholder="e.g. Studio Arc Architects" class="w-full bg-white border border-[#ded7cd] focus:border-[#c09b5a] focus:ring-0 rounded-xl text-xs p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#55504a] uppercase mb-1">Professional Category</label>
                            <select name="professional_type" class="w-full bg-white border border-[#ded7cd] focus:border-[#c09b5a] focus:ring-0 rounded-xl text-xs p-3">
                                <option value="architect">Architect</option>
                                <option value="interior_designer">Interior Designer</option>
                                <option value="contractor">Builder / Contractor</option>
                                <option value="dealer">Tile & Sanitary Dealer</option>
                                <option value="consultant">Project PMC / Consultant</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Contact Information -->
                <div class="space-y-4">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#171615] block border-b border-[#ded7cd] pb-2">
                        2. Contact Information
                    </span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-xs font-bold text-[#55504a] uppercase mb-1">Your Full Name <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $defaultName) }}" required placeholder="e.g. Rahul Sharma" class="w-full border border-[#ded7cd] focus:border-[#c09b5a] focus:ring-0 rounded-xl text-xs p-3">
                            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-500" />
                        </div>
                        <div>
                            <label for="mobile" class="block text-xs font-bold text-[#55504a] uppercase mb-1">Mobile Number (WhatsApp) <span class="text-red-500">*</span></label>
                            <input type="text" id="mobile" name="mobile" value="{{ old('mobile', $defaultMobile) }}" required placeholder="e.g. 6362346660" class="w-full border border-[#ded7cd] focus:border-[#c09b5a] focus:ring-0 rounded-xl text-xs p-3">
                            <x-input-error :messages="$errors->get('mobile')" class="mt-1 text-xs text-red-500" />
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-xs font-bold text-[#55504a] uppercase mb-1">Email Address (Optional)</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $defaultEmail) }}" placeholder="e.g. yourname@example.com" class="w-full border border-[#ded7cd] focus:border-[#c09b5a] focus:ring-0 rounded-xl text-xs p-3">
                    </div>
                </div>

                <!-- Step 3: Date & Slot Selection -->
                <div class="space-y-4">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#171615] block border-b border-[#ded7cd] pb-2">
                        3. Appointment Schedule
                    </span>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="visit_date" class="block text-xs font-bold text-[#55504a] uppercase mb-1">Select Date <span class="text-red-500">*</span></label>
                            <input type="date" id="visit_date" name="visit_date" value="{{ old('visit_date', date('Y-m-d', strtotime('+1 day'))) }}" min="{{ date('Y-m-d') }}" required class="w-full border border-[#ded7cd] focus:border-[#c09b5a] focus:ring-0 rounded-xl text-xs p-3">
                            <x-input-error :messages="$errors->get('visit_date')" class="mt-1 text-xs text-red-500" />
                        </div>
                        <div>
                            <label for="visit_time" class="block text-xs font-bold text-[#55504a] uppercase mb-1">Select Time Slot <span class="text-red-500">*</span></label>
                            <select id="visit_time" name="visit_time" required class="w-full border border-[#ded7cd] focus:border-[#c09b5a] focus:ring-0 rounded-xl text-xs p-3">
                                <option value="">-- Choose Time Slot --</option>
                                <option value="10:00 AM - 12:00 PM" {{ old('visit_time') === '10:00 AM - 12:00 PM' ? 'selected' : '' }}>Morning (10:00 AM - 12:00 PM)</option>
                                <option value="12:00 PM - 02:00 PM" {{ old('visit_time') === '12:00 PM - 02:00 PM' ? 'selected' : '' }}>Mid-Day (12:00 PM - 02:00 PM)</option>
                                <option value="02:00 PM - 04:00 PM" {{ old('visit_time') === '02:00 PM - 04:00 PM' ? 'selected' : '' }}>Afternoon (02:00 PM - 04:00 PM)</option>
                                <option value="04:00 PM - 06:00 PM" {{ old('visit_time') === '04:00 PM - 06:00 PM' ? 'selected' : '' }}>Evening (04:00 PM - 06:00 PM)</option>
                                <option value="06:00 PM - 08:00 PM" {{ old('visit_time') === '06:00 PM - 08:00 PM' ? 'selected' : '' }}>Late Evening (06:00 PM - 08:00 PM)</option>
                            </select>
                            <x-input-error :messages="$errors->get('visit_time')" class="mt-1 text-xs text-red-500" />
                        </div>
                    </div>
                </div>

                <!-- Step 4: Purpose & Requirements -->
                <div class="space-y-4">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#171615] block border-b border-[#ded7cd] pb-2">
                        4. Purpose & Materials of Interest
                    </span>
                    <div>
                        <label for="purpose" class="block text-xs font-bold text-[#55504a] uppercase mb-1">Primary Reason for Visit</label>
                        <select id="purpose" name="purpose" class="w-full border border-[#ded7cd] focus:border-[#c09b5a] focus:ring-0 rounded-xl text-xs p-3">
                            <template x-if="visitorRole === 'professional'">
                                <optgroup label="B2B & Trade Purposes">
                                    <option value="trade">Trade / Bulk Wholesale Pricing Consultation</option>
                                    <option value="consultation">Architectural Project Material Selection</option>
                                    <option value="samples">Sample Box Inspection & Library Setup</option>
                                    <option value="partnership">Agency / Dealer / Distribution Partnership</option>
                                </optgroup>
                            </template>
                            <template x-if="visitorRole === 'homeowner'">
                                <optgroup label="Homeowner Purposes">
                                    <option value="purchase">Planning Purchase / Home Construction</option>
                                    <option value="renovation">Bathroom / Kitchen Renovation</option>
                                    <option value="inspect">Inspect Tiles & Sanitaryware Finishes</option>
                                    <option value="browse">Browse Design Ideas & Mockups</option>
                                </optgroup>
                            </template>
                        </select>
                    </div>

                    <div>
                        <label for="notes" class="block text-xs font-bold text-[#55504a] uppercase mb-1">Project Details or Special Requests (Optional)</label>
                        <textarea id="notes" name="notes" rows="3" placeholder="Tell us about your project (e.g., 3BHK Apartment in Mumbai, looking for large format 600x1200 tiles, wall hung WCs, concealed showers...)" class="w-full border border-[#ded7cd] focus:border-[#c09b5a] focus:ring-0 rounded-xl text-xs p-3">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-4 flex flex-col sm:flex-row gap-3 border-t border-[#ded7cd]">
                    <a href="/" class="sm:w-1/3 bg-[#f5f1eb] hover:bg-[#ede7dd] text-[#171615] font-bold py-3.5 rounded-xl text-center text-xs uppercase tracking-wider transition">
                        Cancel
                    </a>
                    <button type="submit" style="background-color: #171615; color: #ffffff;" class="sm:w-2/3 hover:bg-[#b58d56] text-white font-bold py-3.5 rounded-xl text-xs uppercase tracking-wider shadow-md transition flex items-center justify-center gap-2">
                        <span>Confirm Showroom Appointment</span>
                        <span>➔</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Trust Badges Under Form -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8 text-center">
            <div class="bg-white border border-[#ded7cd] rounded-xl p-4 space-y-1">
                <span class="text-lg">📍</span>
                <h5 class="text-xs font-bold text-[#171615]">Prime Experience Hub</h5>
                <p class="text-[10px] text-[#736c63]">Centrally located luxury studio</p>
            </div>
            <div class="bg-white border border-[#ded7cd] rounded-xl p-4 space-y-1">
                <span class="text-lg">☕</span>
                <h5 class="text-xs font-bold text-[#171615]">Dedicated Concierge</h5>
                <p class="text-[10px] text-[#736c63]">1-on-1 technical & design consultation</p>
            </div>
            <div class="bg-white border border-[#ded7cd] rounded-xl p-4 space-y-1">
                <span class="text-lg">💼</span>
                <h5 class="text-xs font-bold text-[#171615]">Trade & Retail Desks</h5>
                <p class="text-[10px] text-[#736c63]">Separate counters for B2B & Homeowners</p>
            </div>
        </div>

    </div>
</x-app-layout>
