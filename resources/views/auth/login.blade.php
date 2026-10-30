<x-app-layout>
    <x-slot name="title">Login - Pristo</x-slot>

    <div class="py-12 sm:py-16 bg-[#faf8f5] flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
        <div class="w-full sm:max-w-md bg-white border border-[#e8e4dc] rounded-2xl shadow-sm p-6 sm:p-8">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <div class="mb-8 text-center">
                <h2 class="text-2xl font-black text-slate-900">Login</h2>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="text-xs font-bold uppercase text-slate-500 mb-1" />
                    <x-text-input id="email" class="block w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3" type="email" name="email" :value="old('email')" placeholder="Enter email address" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <x-input-label for="password" :value="__('Password')" class="text-xs font-bold uppercase text-slate-500" />
                        @if (Route::has('password.request'))
                            <a class="text-xs font-bold text-teal-600 hover:text-teal-700" href="{{ route('password.request') }}">
                                {{ __('Forgot Password?') }}
                            </a>
                        @endif
                    </div>

                    <x-text-input id="password" class="block w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                                    type="password"
                                    name="password"
                                    placeholder="Enter password"
                                    required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="w-full bg-teal-700 hover:bg-teal-800 text-white font-bold h-12 rounded-xl transition text-sm shadow-md flex items-center justify-center">
                        {{ __('Login') }}
                    </button>
                </div>


                <div class="text-center text-xs font-semibold text-slate-500 pt-2">
                    Don't have an account? 
                    <a href="{{ route('register') }}" class="text-teal-600 hover:text-teal-700">
                        Register here
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
