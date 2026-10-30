<x-admin-layout>
    <x-slot name="title">Website Settings - Pristo Admin</x-slot>

    <div class="space-y-8 max-w-5xl mx-auto">
        <!-- Top Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 pb-5">
            <div>
                <nav class="flex text-slate-400 text-xs gap-1.5 items-center mb-1">
                    <a href="/admin/dashboard" class="hover:text-teal-600">Admin</a>
                    <span>/</span>
                    <span class="text-slate-700 font-semibold">Website Settings</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Website Settings</h1>
                <p class="text-xs text-slate-500 mt-0.5">Manage global contact information, social links, and branding.</p>
            </div>
        </div>

        <form action="{{ route('admin.website-settings.update') }}" method="POST" class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-xs space-y-8">
            @csrf
            
            <!-- Contact Information Section -->
            <div class="space-y-4">
                <div class="border-b border-slate-100 pb-2">
                    <h2 class="text-lg font-bold text-slate-800">Contact Information</h2>
                    <p class="text-xs text-slate-500">Displayed on the Contact Us page, footer, and emails.</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Official Phone Number</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $settings->phone) }}" class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-xl px-4 py-2.5 text-sm text-slate-900 transition">
                        @error('phone') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Support Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $settings->email) }}" class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-xl px-4 py-2.5 text-sm text-slate-900 transition">
                        @error('email') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5 md:col-span-2">
                        <label for="address" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Experience Center Address</label>
                        <textarea id="address" name="address" rows="3" class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-xl px-4 py-2.5 text-sm text-slate-900 transition">{{ old('address', $settings->address) }}</textarea>
                        @error('address') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Social Media Section -->
            <div class="space-y-4 pt-4">
                <div class="border-b border-slate-100 pb-2">
                    <h2 class="text-lg font-bold text-slate-800">Social Media Links</h2>
                    <p class="text-xs text-slate-500">Provide full URLs (e.g., https://instagram.com/pristo)</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <label for="instagram_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Instagram URL</label>
                        <input type="url" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $settings->instagram_url) }}" class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-xl px-4 py-2.5 text-sm text-slate-900 transition">
                        @error('instagram_url') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="facebook_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Facebook URL</label>
                        <input type="url" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $settings->facebook_url) }}" class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-xl px-4 py-2.5 text-sm text-slate-900 transition">
                        @error('facebook_url') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="youtube_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700">YouTube URL</label>
                        <input type="url" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $settings->youtube_url) }}" class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-xl px-4 py-2.5 text-sm text-slate-900 transition">
                        @error('youtube_url') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label for="twitter_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Twitter / X URL</label>
                        <input type="url" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $settings->twitter_url) }}" class="w-full bg-slate-50 border border-slate-200 focus:border-teal-500 focus:ring-1 focus:ring-teal-500 rounded-xl px-4 py-2.5 text-sm text-slate-900 transition">
                        @error('twitter_url') <span class="text-[10px] text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100 flex justify-end">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-8 rounded-xl shadow-md transition text-sm">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
