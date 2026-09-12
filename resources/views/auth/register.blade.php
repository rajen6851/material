<x-app-layout>
    <x-slot name="title">Register - Pristo</x-slot>

    <div class="py-12 sm:py-16 bg-[#faf8f5] flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
        <div class="w-full sm:max-w-lg bg-white border border-[#e8e4dc] rounded-2xl shadow-sm p-6 sm:p-8" x-data="{ activeTab: 'homeowner' }">
            <!-- Heading -->
            <div class="mb-6">
                <h2 class="text-3xl font-extrabold text-slate-900">Register</h2>
            </div>

            <!-- Tabs -->
            <div class="flex border-b border-slate-200 mb-6">
                <button type="button" @click="activeTab = 'homeowner'"
                    :class="activeTab === 'homeowner' ? 'border-b-2 border-teal-600 text-teal-700 font-bold' : 'text-slate-500 font-semibold'"
                    class="flex-1 pb-3 text-center text-sm focus:outline-none transition">
                    Homeowner
                </button>
                <button type="button" @click="activeTab = 'professional'"
                    :class="activeTab === 'professional' ? 'border-b-2 border-teal-600 text-teal-700 font-bold' : 'text-slate-500 font-semibold'"
                    class="flex-1 pb-3 text-center text-sm focus:outline-none transition">
                    B2B
                </button>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Role Hidden Input based on tab selection -->
                <input type="hidden" name="role" :value="activeTab">

                <!-- Full Name -->
                <div>
                    <x-text-input id="name"
                        class="block w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                        type="text" name="name" :value="old('name')" placeholder="Full Name" required autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Email Address -->
                <div>
                    <x-text-input id="email"
                        class="block w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                        type="email" name="email" :value="old('email')" placeholder="Email Address" required
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Mobile Number -->
                <div>
                    <x-text-input id="phone"
                        class="block w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                        type="text" name="phone" :value="old('phone')" placeholder="Mobile Number" required />
                    <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                </div>

                <!-- Passwords Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative">
                        <x-text-input id="password"
                            class="block w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            type="password" name="password" placeholder="Password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1" />
                    </div>

                    <div class="relative">
                        <x-text-input id="password_confirmation"
                            class="block w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            type="password" name="password_confirmation" placeholder="Confirm Password" required
                            autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                    </div>
                </div>

                <!-- Professional Details Block (Shows when tab is Professional) -->
                <div x-show="activeTab === 'professional'" class="space-y-4 pt-4 border-t" x-cloak>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Company Name -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Company Name</label>
                            <x-text-input id="company_name"
                                class="block w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                                type="text" name="company_name" :value="old('company_name')" placeholder="Company Name" />
                            <x-input-error :messages="$errors->get('company_name')" class="mt-1" />
                        </div>

                        <!-- Profession Type dropdown -->
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Profession Type</label>
                            <select id="professional_type" name="professional_type"
                                class="block w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                <option value="">Select Profession</option>
                                <option value="architect" {{ old('professional_type') == 'architect' ? 'selected' : '' }}>
                                    Architect</option>
                                <option value="plumber" {{ old('professional_type') == 'plumber' ? 'selected' : '' }}>
                                    Plumber</option>
                                <option value="designer" {{ old('professional_type') == 'designer' ? 'selected' : '' }}>
                                    Interior Designer</option>
                                <option value="builder" {{ old('professional_type') == 'builder' ? 'selected' : '' }}>Builder/
                                    Contractor</option>
                            </select>
                            <x-input-error :messages="$errors->get('professional_type')" class="mt-1" />
                        </div>
                    </div>

                    <!-- GST Number -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">GST Number (Optional)</label>
                        <x-text-input id="gst_number"
                            class="block w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            type="text" name="gst_number" :value="old('gst_number')" placeholder="GST Number" />
                        <x-input-error :messages="$errors->get('gst_number')" class="mt-1" />
                    </div>
                </div>

                <!-- Homeowner Register Button -->
                <div x-show="activeTab === 'homeowner'">
                    <button type="submit"
                        class="w-full bg-teal-700 hover:bg-teal-800 text-white font-bold h-12 rounded-xl transition text-sm shadow-md flex items-center justify-center">
                        Register as Homeowner
                    </button>
                </div>

                <!-- Professional Register Button -->
                <div x-show="activeTab === 'professional'">
                    <button type="submit"
                        class="w-full bg-teal-700 hover:bg-teal-800 text-white font-bold h-12 rounded-xl transition text-sm shadow-md flex items-center justify-center">
                        Register as B2B
                    </button>
                </div>

                <!-- OR Divider & Professional box for homeowner tab -->
                <div x-show="activeTab === 'homeowner'" class="space-y-4">
                    <!-- Divider -->
                    <div class="relative flex py-2 items-center">
                        <div class="flex-grow border-t border-slate-200"></div>
                        <span class="flex-shrink mx-4 text-xs font-semibold text-slate-400 uppercase">or</span>
                        <div class="flex-grow border-t border-slate-200"></div>
                    </div>

                    <!-- Professional Prompt Box -->
                    <div
                        class="bg-slate-900 text-white rounded-2xl p-5 text-center space-y-3.5 border border-slate-800 shadow-lg">
                        <p class="text-xs font-semibold text-slate-200">Are you a B2B? (Architect, Contractor,
                            Builder)</p>
                        <button type="button" @click="activeTab = 'professional'"
                            class="w-full bg-teal-700 hover:bg-teal-800 text-white font-bold h-11 rounded-xl transition text-xs flex items-center justify-center">
                            Register as B2B
                        </button>
                    </div>
                </div>

                <div class="text-center text-xs font-semibold text-slate-500 pt-4">
                    Already registered?
                    <a href="{{ route('login') }}" class="text-teal-600 hover:text-teal-700">
                        Login here
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>