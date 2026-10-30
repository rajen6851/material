<x-admin-layout>
    <x-slot name="title">Add New Bathroom Package - Admin</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-6">
        <!-- Back Button & Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.packages.index') }}" class="p-2 text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Create Bathroom Package</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Define package configuration header. You can add items (Basin, WC, Shower) in the next step.</p>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs px-4 py-3 rounded-xl space-y-1">
                <strong class="font-bold">Please fix the following errors:</strong>
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Package Name -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Package Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Configuration 1, Configuration 2, or Master Suite Combo" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3 font-semibold text-slate-800">
                </div>

                <!-- Brand -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Brand
                    </label>
                    <select name="brand_id" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        <option value="">-- No Specific Brand / Multi-Brand --</option>
                        @foreach($brands as $b)
                            <option value="{{ $b->id }}" {{ old('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tagline / Subtitle -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Tagline / Subtitle
                    </label>
                    <input type="text" name="tagline" value="{{ old('tagline') }}" placeholder="e.g. Complete Sanitaryware &amp; CP Fittings Suite" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                </div>

                <!-- Package Offer Price -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Special Package Price (₹) <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" placeholder="e.g. 18500" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                </div>

                <!-- MRP -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Original MRP (₹) <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <input type="number" step="0.01" name="mrp" value="{{ old('mrp') }}" placeholder="e.g. 24000" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                </div>

                <!-- Cover Image -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Cover Image / Brochure Thumbnail <span class="text-slate-400 font-normal">(Optional)</span>
                    </label>
                    <input type="file" name="image" accept="image/*" class="w-full border border-slate-200 text-xs p-2 rounded-xl bg-slate-50">
                    <span class="text-[11px] text-slate-400 mt-1 block">JPG, PNG, WEBP up to 4MB</span>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Description / Package Notes
                    </label>
                    <textarea name="description" rows="3" placeholder="Brief details about warranty, finish, or what this configuration includes..." class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">{{ old('description') }}</textarea>
                </div>

                <!-- Display Settings -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Display Order (Sort)
                    </label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                </div>

                <div class="flex items-center pt-6">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-slate-300 text-teal-600 focus:ring-0 w-4 h-4">
                        <span class="text-sm font-bold text-slate-800">Publish Active (Visible on website)</span>
                    </label>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-6 flex items-center justify-end gap-3">
                <a href="{{ route('admin.packages.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-7 py-3 rounded-xl shadow-md transition flex items-center gap-2">
                    <span>Save &amp; Add Items &rarr;</span>
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>

