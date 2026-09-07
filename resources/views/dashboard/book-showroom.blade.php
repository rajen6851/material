@php
    $isProfessional = auth()->check() && auth()->user()->isProfessional();
    $roleLabel = $isProfessional ? (auth()->user()->professional_type ?: 'Professional') : 'Homeowner';
@endphp

<x-app-layout>
    <x-slot name="title">Book Showroom Visit - MaterialDeck</x-slot>

    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <div class="bg-white border rounded-2xl p-6 md:p-8 shadow-sm space-y-6">
            <div class="border-b pb-4">
                <h1 class="text-2xl font-extrabold text-slate-900">Book Showroom Visit</h1>
                <p class="text-slate-500 text-sm mt-1">Book an in-person session at our designer hub in Mumbai. Touch, feel, and select premium materials with an expert adviser.</p>
            </div>

            @auth
                <!-- Role-aware visit context -->
                <div class="rounded-2xl p-5 border {{ $isProfessional ? 'bg-slate-900 border-slate-800 text-white' : 'bg-teal-50 border-teal-100 text-teal-900' }}">
                    <span class="text-[10px] font-black uppercase tracking-wider block mb-1 {{ $isProfessional ? 'text-teal-400' : 'text-teal-600' }}">
                        {{ $roleLabel }} visit
                    </span>
                    @if($isProfessional)
                        <p class="text-xs leading-relaxed {{ $isProfessional ? 'text-slate-300' : 'text-teal-800' }}">
                            As a <strong class="text-white capitalize">{{ $roleLabel }}</strong>, our trade desk will be ready for you — full-size premium samples, material catalogs, <strong class="text-teal-400">bulk quotation support</strong>, and wholesale/trade pricing for {{ auth()->user()->company_name ?: 'your company' }}.
                        </p>
                    @else
                        <p class="text-xs leading-relaxed text-teal-800">
                            As a <strong>Homeowner</strong>, our advisers will help you shortlist tiles, sanitary ware, and fixtures for your space — compare finishes in person and get an instant estimate.
                        </p>
                    @endif
                </div>
            @endauth

            <form action="{{ route('showroom.store') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Purpose (role-aware) -->
                <div>
                    <label for="purpose" class="block text-xs font-bold text-slate-500 uppercase mb-1">Reason for Visit</label>
                    <select id="purpose" name="purpose" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        @if($isProfessional)
                            <option value="trade" {{ old('purpose') === 'trade' ? 'selected' : '' }}>Trade / Bulk Material Consultation</option>
                            <option value="consultation" {{ old('purpose') === 'consultation' ? 'selected' : '' }}>Project Material Consultation</option>
                            <option value="inspect" {{ old('purpose') === 'inspect' ? 'selected' : '' }}>Inspect &amp; Select Samples</option>
                            <option value="browse" {{ old('purpose') === 'browse' ? 'selected' : '' }}>General Browsing</option>
                        @else
                            <option value="purchase" {{ old('purpose') === 'purchase' ? 'selected' : '' }}>Planning a Purchase</option>
                            <option value="inspect" {{ old('purpose') === 'inspect' ? 'selected' : '' }}>Inspect &amp; Select Samples</option>
                            <option value="browse" {{ old('purpose') === 'browse' ? 'selected' : '' }}>Browse Design Ideas</option>
                        @endif
                    </select>
                    <x-input-error :messages="$errors->get('purpose')" class="mt-1" />
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-500 uppercase mb-1">Your Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', auth()->check() ? auth()->user()->name : '') }}" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Mobile -->
                <div>
                    <label for="mobile" class="block text-xs font-bold text-slate-500 uppercase mb-1">Mobile Number</label>
                    <input type="text" id="mobile" name="mobile" value="{{ old('mobile', auth()->check() ? auth()->user()->phone : '') }}" required placeholder="e.g. 9876543210" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    <x-input-error :messages="$errors->get('mobile')" class="mt-1" />
                </div>

                <!-- Visit Date -->
                <div>
                    <label for="visit_date" class="block text-xs font-bold text-slate-500 uppercase mb-1">Select Visit Date</label>
                    <input type="date" id="visit_date" name="visit_date" min="{{ date('Y-m-d') }}" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    <x-input-error :messages="$errors->get('visit_date')" class="mt-1" />
                </div>

                <!-- Visit Time Slot -->
                <div>
                    <label for="visit_time" class="block text-xs font-bold text-slate-500 uppercase mb-1">Preferred Time Slot</label>
                    <select id="visit_time" name="visit_time" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        <option value="">-- Choose Time Slot --</option>
                        <option value="10:00 AM - 12:00 PM">Morning (10:00 AM - 12:00 PM)</option>
                        <option value="12:00 PM - 02:00 PM">Mid-Day (12:00 PM - 02:00 PM)</option>
                        <option value="02:00 PM - 04:00 PM">Afternoon (02:00 PM - 04:00 PM)</option>
                        <option value="04:00 PM - 06:00 PM">Evening (04:00 PM - 06:00 PM)</option>
                    </select>
                    <x-input-error :messages="$errors->get('visit_time')" class="mt-1" />
                </div>

                <!-- Actions -->
                <div class="pt-4 flex gap-4">
                    <a href="/" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-3.5 rounded-xl text-center text-sm transition">Cancel</a>
                    <button type="submit" class="flex-grow bg-teal-600 hover:bg-teal-700 text-white font-bold py-3.5 rounded-xl shadow-md transition text-sm">Confirm Booking</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
