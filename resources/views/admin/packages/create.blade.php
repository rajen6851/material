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
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Tagline / Subtitle
                    </label>
                    <input type="text" name="tagline" value="{{ old('tagline') }}" placeholder="e.g. Complete Sanitaryware &amp; CP Fittings Suite" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                </div>

                <!-- Package Pricing & Discount Calculation -->
                <div class="md:col-span-2 bg-gradient-to-br from-slate-50 via-teal-50/30 to-white border-2 border-teal-500/30 rounded-3xl p-6 sm:p-7 space-y-4 shadow-sm">
                    <div class="flex items-center gap-2 border-b border-teal-100 pb-2">
                        <span class="text-xl">💰</span>
                        <span class="text-xs font-black text-slate-900 uppercase tracking-wide">Pricing &amp; Discount Calculator</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- Original MRP -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Original MRP (₹) <span class="text-slate-400 font-normal">(Optional)</span>
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 font-bold text-sm">₹</span>
                                <input type="number" step="0.01" name="mrp" id="create_package_mrp" value="{{ old('mrp') }}" placeholder="e.g. 24000" class="w-full pl-8 border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3 font-semibold text-slate-900 bg-white">
                            </div>
                        </div>

                        <!-- Discount % -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Package Discount (% OFF)
                            </label>
                            <div class="relative">
                                <input type="number" step="any" min="0" max="100" name="discount_percent" id="create_package_discount" value="{{ old('discount_percent') }}" placeholder="e.g. 20" class="w-full pr-8 border-slate-300 focus:border-emerald-500 focus:ring-0 rounded-xl text-sm p-3 font-black text-emerald-700 bg-white">
                                <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 font-bold text-sm">%</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-1.5 mt-2">
                                @foreach([10, 15, 20, 25, 30, 40, 50] as $qDisc)
                                    <button type="button" onclick="setCreateQuickDiscount({{ $qDisc }})" class="text-[10px] font-black px-2 py-0.5 rounded-lg border border-slate-200 bg-white hover:bg-emerald-50 hover:text-emerald-700 transition cursor-pointer">
                                        {{ $qDisc }}%
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Special Package Price -->
                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                Special Package Price (₹)
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 font-bold text-sm">₹</span>
                                <input type="number" step="0.01" name="price" id="create_package_price" value="{{ old('price') }}" placeholder="e.g. 18500" class="w-full pl-8 border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-base p-3 font-black text-teal-700 bg-white">
                            </div>
                        </div>
                    </div>

                    <div id="create_pricing_summary"></div>
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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const mrpInput = document.getElementById('create_package_mrp');
        const discInput = document.getElementById('create_package_discount');
        const priceInput = document.getElementById('create_package_price');
        const summaryEl = document.getElementById('create_pricing_summary');

        window.setCreateQuickDiscount = function (percent) {
            if (discInput) {
                discInput.value = percent;
                recalcFromDiscount();
            }
        };

        function updateSummary() {
            if (!summaryEl) return;
            const mrp = parseFloat(mrpInput ? mrpInput.value : 0) || 0;
            const price = parseFloat(priceInput ? priceInput.value : 0) || 0;

            if (mrp > 0 && price > 0 && mrp > price) {
                const savings = mrp - price;
                const pct = Math.round((savings / mrp) * 100);
                summaryEl.innerHTML = `
                    <div class="flex flex-wrap items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-900 px-4 py-2.5 rounded-xl text-xs font-bold">
                        <span class="bg-emerald-600 text-white px-2 py-0.5 rounded-md text-[11px] font-black">🔥 ${pct}% DISCOUNT</span>
                        <span>Customer Saves: <strong>₹${savings.toLocaleString('en-IN', {minimumFractionDigits: 2})}</strong></span>
                    </div>
                `;
            } else {
                summaryEl.innerHTML = '';
            }
        }

        function recalcFromDiscount() {
            const mrp = parseFloat(mrpInput ? mrpInput.value : 0) || 0;
            const disc = parseFloat(discInput ? discInput.value : 0);
            if (!isNaN(disc) && mrp > 0 && priceInput) {
                const clamped = Math.max(0, Math.min(100, disc));
                priceInput.value = Math.round(mrp - (mrp * (clamped / 100)));
            }
            updateSummary();
        }

        function recalcFromPrice() {
            const mrp = parseFloat(mrpInput ? mrpInput.value : 0) || 0;
            const price = parseFloat(priceInput ? priceInput.value : 0);
            if (mrp > 0 && !isNaN(price) && discInput) {
                if (price > 0 && mrp > price) {
                    discInput.value = Math.round(((mrp - price) / mrp) * 100);
                } else if (price >= mrp) {
                    discInput.value = 0;
                }
            }
            updateSummary();
        }

        if (discInput) discInput.addEventListener('input', recalcFromDiscount);
        if (priceInput) priceInput.addEventListener('input', recalcFromPrice);
        if (mrpInput) mrpInput.addEventListener('input', function () {
            if (discInput && discInput.value) {
                recalcFromDiscount();
            } else {
                recalcFromPrice();
            }
        });

        updateSummary();
    });
    </script>
</x-admin-layout>

