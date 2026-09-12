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

                <!-- Divider -->
                <div class="relative flex py-2 items-center">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="flex-shrink mx-4 text-xs font-semibold text-slate-400 uppercase">or</span>
                    <div class="flex-grow border-t border-slate-200"></div>
                </div>

                <!-- Google Login Button -->
                <div>
                    <button type="button" class="w-full border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-bold h-12 rounded-xl transition text-xs shadow-sm flex items-center justify-center gap-2">
                        <!-- Simple Google Icon SVG -->
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                        </svg>
                        <span>Login with Google</span>
                    </button>
                </div>

                <!-- OTP Login Button -->
                <div>
                    <button type="button" class="w-full border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-bold h-12 rounded-xl transition text-xs shadow-sm flex items-center justify-center">
                        Login with OTP
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
