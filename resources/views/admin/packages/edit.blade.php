<x-admin-layout>
    <x-slot name="title">Edit {{ $package->name }} - Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8" x-data="{
        addItemModal: false,
        editItemModal: false,
        productPickerModal: false,
        activeAreaTab: 'all',
        
        // Single Add/Edit State
        editItemData: {
            id: null,
            area: 'Basin Area',
            cat_no: '',
            name: '',
            description: '',
            price: '',
            quantity: 1,
            sort_order: 0,
            image: ''
        },

        // Product Picker Search State
        searchQuery: '',
        selectedCategory: '',
        selectedBrand: '',
        selectedArea: 'Basin Area',
        loadingProducts: false,
        searchResults: [],
        selectedProductIds: [],

        openAddModal() {
            this.addItemModal = true;
        },
        openEditModal(item) {
            this.editItemData = { ...item };
            if (!this.editItemData.area) {
                this.editItemData.area = 'Basin Area';
            }
            this.editItemModal = true;
        },
        openProductPicker() {
            this.selectedProductIds = [];
            this.productPickerModal = true;
            this.fetchProducts();
        },

        fetchProducts() {
            this.loadingProducts = true;
            let url = '/admin/packages/search-products?q=' + encodeURIComponent(this.searchQuery)
                    + '&category_id=' + encodeURIComponent(this.selectedCategory)
                    + '&brand_id=' + encodeURIComponent(this.selectedBrand);
            
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    this.searchResults = data;
                    this.loadingProducts = false;
                })
                .catch(err => {
                    console.error(err);
                    this.loadingProducts = false;
                });
        },

        toggleProductSelect(id) {
            let index = this.selectedProductIds.indexOf(id);
            if (index > -1) {
                this.selectedProductIds.splice(index, 1);
            } else {
                this.selectedProductIds.push(id);
            }
        },

        selectAllProducts() {
            if (this.selectedProductIds.length === this.searchResults.length) {
                this.selectedProductIds = [];
            } else {
                this.selectedProductIds = this.searchResults.map(p => p.id);
            }
        },

        fillSingleFromProduct(product) {
            let catInput = document.getElementById('single_cat_no');
            let nameInput = document.getElementById('single_name');
            let priceInput = document.getElementById('single_price');
            let descInput = document.getElementById('single_desc');
            let prodIdInput = document.getElementById('single_product_id');

            if (catInput) catInput.value = product.sku || '';
            if (nameInput) nameInput.value = product.name || '';
            if (priceInput) priceInput.value = product.price || '';
            if (descInput) descInput.value = product.description || '';
            if (prodIdInput) prodIdInput.value = product.id;
        }
    }">

        <!-- Top Header & Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.packages.index') }}" class="p-2.5 text-slate-500 hover:text-slate-900 hover:bg-slate-100 rounded-xl transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">{{ $package->name }}</h2>
                        @if($package->brand)
                            <span class="bg-indigo-100 text-indigo-700 text-xs font-black uppercase px-2.5 py-0.5 rounded-full">
                                {{ $package->brand->name }}
                            </span>
                        @endif
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-bold {{ $package->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $package->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 mt-1">
                        {{ $package->tagline ?? 'Add and manage all products included in this package.' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <a href="{{ route('packages.show', $package->slug) }}" target="_blank" class="inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-4 py-2.5 rounded-xl transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    <span>Preview Package</span>
                </a>
                <button type="button" @click="openProductPicker()" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>+ Pick from Store Products</span>
                </button>
                <button type="button" @click="openAddModal()" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>+ Add Custom Product</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm px-4 py-3 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs px-4 py-3 rounded-xl space-y-1">
                <strong class="font-bold">Please fix errors:</strong>
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ========================================================================= -->
        <!-- PRODUCTS IN THIS PACKAGE (WITH BASIN / WC / SHOWER AREA)                   -->
        <!-- ========================================================================= -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden space-y-0">
            <!-- Section Header -->
            <div class="p-6 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-black text-slate-900 tracking-tight flex items-center gap-2">
                        <span>📦 Products in this Package</span>
                        <span class="text-xs bg-indigo-50 text-indigo-700 px-2.5 py-0.5 rounded-full font-extrabold border border-indigo-100">
                            {{ $items->count() }} Products
                        </span>
                    </h3>
                    <p class="text-xs text-slate-500 mt-0.5">Organize items by <strong>Basin Area</strong>, <strong>WC Area</strong>, and <strong>Shower Area</strong>.</p>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" @click="openProductPicker()" class="inline-flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <span>Pick Existing Products</span>
                    </button>
                    <button type="button" @click="openAddModal()" class="inline-flex items-center gap-1.5 bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold px-4 py-2 rounded-xl transition">
                        <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>+ Custom Product</span>
                    </button>
                </div>
            </div>

            <!-- Filter Area Tabs -->
            @php
                $basinCount = $items->filter(fn($i) => str_contains(strtolower($i->area), 'basin'))->count();
                $wcCount = $items->filter(fn($i) => str_contains(strtolower($i->area), 'wc') || str_contains(strtolower($i->area), 'toilet'))->count();
                $showerCount = $items->filter(fn($i) => str_contains(strtolower($i->area), 'shower'))->count();
                $otherCount = $items->count() - $basinCount - $wcCount - $showerCount;
            @endphp
            <div class="px-6 py-3 bg-slate-50/70 border-b border-slate-200 flex items-center gap-2 overflow-x-auto text-xs font-bold">
                <span class="text-slate-400 uppercase tracking-wider text-[10px] mr-1 flex-shrink-0">Filter Area:</span>
                <button type="button" @click="activeAreaTab = 'all'" :class="activeAreaTab === 'all' ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200'" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 flex-shrink-0">
                    <span>All Products</span>
                    <span class="text-[10px] opacity-75">({{ $items->count() }})</span>
                </button>
                <button type="button" @click="activeAreaTab = 'Basin Area'" :class="activeAreaTab === 'Basin Area' ? 'bg-sky-600 text-white shadow-xs' : 'bg-white text-sky-800 hover:bg-sky-50 border border-sky-200'" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 flex-shrink-0">
                    <span>💧 Basin Area</span>
                    <span class="text-[10px] opacity-80">({{ $basinCount }})</span>
                </button>
                <button type="button" @click="activeAreaTab = 'WC Area'" :class="activeAreaTab === 'WC Area' ? 'bg-purple-600 text-white shadow-xs' : 'bg-white text-purple-800 hover:bg-purple-50 border border-purple-200'" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 flex-shrink-0">
                    <span>🚽 WC Area</span>
                    <span class="text-[10px] opacity-80">({{ $wcCount }})</span>
                </button>
                <button type="button" @click="activeAreaTab = 'Shower Area'" :class="activeAreaTab === 'Shower Area' ? 'bg-amber-600 text-white shadow-xs' : 'bg-white text-amber-800 hover:bg-amber-50 border border-amber-200'" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 flex-shrink-0">
                    <span>🚿 Shower Area</span>
                    <span class="text-[10px] opacity-80">({{ $showerCount }})</span>
                </button>
                @if($otherCount > 0)
                    <button type="button" @click="activeAreaTab = 'Other Area'" :class="activeAreaTab === 'Other Area' ? 'bg-slate-700 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200'" class="px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5 flex-shrink-0">
                        <span>📦 Other</span>
                        <span class="text-[10px] opacity-80">({{ $otherCount }})</span>
                    </button>
                @endif
            </div>

            <!-- Products List / Table -->
            @if($items->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50/80 text-slate-700 uppercase font-bold text-[11px] tracking-wider border-b border-slate-200">
                            <tr>
                                <th class="py-3.5 px-4 w-12 text-center">#</th>
                                <th class="py-3.5 px-4 w-20">Photo</th>
                                <th class="py-3.5 px-4">Product Details</th>
                                <th class="py-3.5 px-4">Area / Section</th>
                                <th class="py-3.5 px-4">SKU / Cat No</th>
                                <th class="py-3.5 px-4">Item Price</th>
                                <th class="py-3.5 px-4 text-center">Qty</th>
                                <th class="py-3.5 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @foreach($items as $index => $item)
                                @php
                                    $isBasin = str_contains(strtolower($item->area), 'basin');
                                    $isWc = str_contains(strtolower($item->area), 'wc') || str_contains(strtolower($item->area), 'toilet');
                                    $isShower = str_contains(strtolower($item->area), 'shower');
                                    $areaType = $isBasin ? 'Basin Area' : ($isWc ? 'WC Area' : ($isShower ? 'Shower Area' : 'Other Area'));
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition"
                                    x-show="activeAreaTab === 'all' || activeAreaTab === '{{ $areaType }}'">
                                    <td class="py-3.5 px-4 text-center font-bold text-slate-400">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <div class="w-14 h-14 bg-white rounded-xl border border-slate-200 p-1 flex items-center justify-center overflow-hidden">
                                            @if($item->display_image)
                                                <img src="{{ $item->display_image }}" alt="{{ $item->name }}" class="w-full h-full object-contain">
                                            @else
                                                <span class="text-xl text-slate-300">📦</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 max-w-md">
                                        <div class="space-y-0.5">
                                            <h4 class="text-xs font-bold text-slate-900 leading-snug">
                                                {{ $item->name }}
                                            </h4>
                                            @if($item->description)
                                                <p class="text-[11px] text-slate-500 font-normal leading-normal line-clamp-2">
                                                    {{ $item->description }}
                                                </p>
                                            @endif
                                            @if($item->product_id)
                                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-indigo-700 bg-indigo-50 px-1.5 py-0.2 rounded mt-1">
                                                    <span>📦 From Store Catalog</span>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <form action="{{ route('admin.packages.items.update-area', $item->id) }}" method="POST">
                                            @csrf
                                            <select name="area" onchange="this.form.submit()" title="Click to quickly re-assign area"
                                                class="text-xs font-black rounded-xl border py-1.5 px-2.5 cursor-pointer transition shadow-xs {{ $isBasin ? 'bg-sky-50 text-sky-800 border-sky-300' : ($isWc ? 'bg-purple-50 text-purple-800 border-purple-300' : ($isShower ? 'bg-amber-50 text-amber-800 border-amber-300' : 'bg-slate-50 text-slate-700 border-slate-300')) }}">
                                                <option value="Basin Area" {{ $isBasin ? 'selected' : '' }}>💧 Basin Area</option>
                                                <option value="WC Area" {{ $isWc ? 'selected' : '' }}>🚽 WC Area</option>
                                                <option value="Shower Area" {{ $isShower ? 'selected' : '' }}>🚿 Shower Area</option>
                                                <option value="Other Area" {{ (!$isBasin && !$isWc && !$isShower) ? 'selected' : '' }}>📦 Other Area</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if($item->cat_no)
                                            <span class="font-mono text-[11px] font-bold bg-slate-100 text-slate-700 px-2 py-0.5 rounded">
                                                {{ $item->cat_no }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 italic">--</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @php
                                            $itemPrice = $item->effective_price;
                                            $itemMrp = $item->effective_mrp;
                                            $itemDisc = $item->discount_percent;
                                        @endphp
                                        @if($itemPrice)
                                            <div class="space-y-0.5 leading-tight">
                                                <span class="font-extrabold text-slate-900 text-xs block">₹{{ number_format($itemPrice, 2) }}</span>
                                                @if($itemMrp && $itemMrp > $itemPrice)
                                                    <span class="text-[10px] text-slate-400 line-through block">₹{{ number_format($itemMrp, 2) }}</span>
                                                @endif
                                                @if($itemDisc && $itemDisc > 0)
                                                    <span class="text-[10px] font-bold text-teal-600 block">Discount {{ $itemDisc }}%</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-slate-400 italic">Included in package</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                                        {{ $item->quantity ?? 1 }}
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button type="button" @click="openEditModal({{ json_encode($item) }})" class="p-1.5 text-slate-400 hover:text-teal-600 hover:bg-slate-100 rounded-lg transition" title="Edit Item">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <form action="{{ route('admin.packages.items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Remove this product from the package?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Delete Item">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="py-16 text-center text-slate-400 p-8">
                    <span class="text-4xl block mb-2 opacity-50">📦</span>
                    <h4 class="text-sm font-bold text-slate-700">No products added in this package yet</h4>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
                        Add the products that come in this combo. You can pick from products already in your store catalogue or add them manually.
                    </p>
                    <div class="mt-4 flex items-center justify-center gap-3">
                        <button type="button" @click="openProductPicker()" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow-xs flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <span>Pick from Store Products</span>
                        </button>
                        <button type="button" @click="openAddModal()" class="bg-slate-100 hover:bg-slate-200 text-slate-800 text-xs font-bold px-4 py-2 rounded-xl transition">
                            + Add Custom Product
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Package Meta & Settings Details -->
        <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-sm space-y-6">
            <h3 class="font-extrabold text-slate-900 text-lg border-b border-slate-200 pb-3 flex items-center gap-2">
                <span>⚙️ Package Header &amp; Pricing Details</span>
            </h3>

            <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Package Name *</label>
                        <input type="text" name="name" value="{{ old('name', $package->name) }}" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3 font-semibold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Brand</label>
                        <select name="brand_id" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                            <option value="">-- No Specific Brand / Multi-Brand --</option>
                            @foreach($brands as $b)
                                <option value="{{ $b->id }}" {{ old('brand_id', $package->brand_id) == $b->id ? 'selected' : '' }}>
                                    {{ $b->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tagline / Subtitle</label>
                        <input type="text" name="tagline" value="{{ old('tagline', $package->tagline) }}" placeholder="e.g. Victorian Suite with Concealed Cistern" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    </div>
                </div>

                @php
                    $calcTotal = $package->calculated_total;
                    $refMrp = $package->mrp ?: $calcTotal;
                    $calcDisc = ($refMrp && $package->price && $refMrp > $package->price) ? round((($refMrp - $package->price) / $refMrp) * 100) : 0;
                    $calcSavings = ($refMrp && $package->price && $refMrp > $package->price) ? ($refMrp - $package->price) : 0;
                @endphp

                @if($calcTotal > 0 || $package->mrp > 0)
                    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 p-4 rounded-2xl flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <span class="text-2xl">🏷️</span>
                            <div>
                                <span class="text-xs font-black text-emerald-950 uppercase tracking-wide block">Package Discount Calculation:</span>
                                <p class="text-xs text-emerald-800">
                                    Total Items Value: <strong>₹{{ number_format($calcTotal, 2) }}</strong>
                                    @if($package->mrp && $package->mrp != $calcTotal)
                                        | Defined MRP: <strong>₹{{ number_format($package->mrp, 2) }}</strong>
                                    @endif
                                    | Package Price: <strong>₹{{ number_format($package->price, 2) }}</strong>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            @if($calcDisc > 0)
                                <span class="bg-emerald-600 text-white text-xs font-black px-3 py-1.5 rounded-xl shadow-xs">
                                    🔥 {{ $calcDisc }}% DISCOUNT
                                </span>
                                <span class="text-xs font-bold text-emerald-900 bg-white border border-emerald-200 px-3 py-1.5 rounded-xl">
                                    Customer Saves ₹{{ number_format($calcSavings) }}
                                </span>
                            @else
                                <span class="text-xs text-slate-500 italic bg-white px-3 py-1.5 rounded-xl border border-slate-200">
                                    Set Package Price lower than MRP or Items total to show discount %
                                </span>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Special Package Price (₹)</label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $package->price) }}" placeholder="e.g. 18990" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3 font-bold text-teal-600">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Original MRP (₹)</label>
                        <input type="number" step="0.01" name="mrp" value="{{ old('mrp', $package->mrp) }}" placeholder="e.g. 24500" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Display Sort Order</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $package->sort_order) }}" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Package Cover Image</label>
                        <input type="file" name="image" accept="image/*" class="w-full border border-slate-200 text-xs p-2 rounded-xl bg-slate-50">
                        @if($package->image)
                            <div class="mt-2 flex items-center gap-2">
                                <img src="{{ asset($package->image) }}" class="w-10 h-10 object-cover rounded-lg border">
                                <span class="text-[11px] text-slate-500">Current cover</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $package->is_active) ? 'checked' : '' }} class="rounded border-slate-300 text-teal-600 focus:ring-0">
                    <label for="is_active" class="text-xs font-bold text-slate-700">Publish Active on Storefront</label>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Description / Package Notes</label>
                    <textarea name="description" rows="3" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">{{ old('description', $package->description) }}</textarea>
                </div>

                <div class="border-t border-slate-200 pt-4 flex justify-end">
                    <button type="submit" class="bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold px-6 py-2.5 rounded-xl transition">
                        Update Package Header
                    </button>
                </div>
            </form>
        </div>


        <!-- ========================================================================= -->
        <!-- MODAL: PRODUCT PICKER (Select from Existing Products in Catalog)           -->
        <!-- ========================================================================= -->
        <div x-show="productPickerModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="min-h-screen px-4 text-center flex items-center justify-center py-8">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="productPickerModal = false"></div>

                <div class="bg-white rounded-3xl max-w-4xl w-full p-6 text-left align-middle shadow-2xl transform transition-all relative z-10 space-y-4 max-h-[92vh] flex flex-col">
                    
                    <!-- Header -->
                    <div class="flex items-center justify-between border-b pb-3 flex-shrink-0">
                        <div>
                            <h3 class="text-lg font-black text-slate-900 flex items-center gap-2">
                                <span>📦 Pick from Existing Products</span>
                            </h3>
                            <p class="text-xs text-slate-500">Search and tick products from your store catalogue to add to this package combo.</p>
                        </div>
                        <button type="button" @click="productPickerModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Filter / Search Row -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 flex-shrink-0 bg-slate-50 p-3 rounded-2xl border border-slate-200">
                        <div class="relative">
                            <input type="text" x-model="searchQuery" @input.debounce.300ms="fetchProducts()" placeholder="Search by name, SKU or model..." class="w-full border-slate-300 rounded-xl text-xs py-2 pl-8 pr-3">
                            <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>

                        <div>
                            <select x-model="selectedCategory" @change="fetchProducts()" class="w-full border-slate-300 rounded-xl text-xs py-2">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <select x-model="selectedBrand" @change="fetchProducts()" class="w-full border-slate-300 rounded-xl text-xs py-2">
                                <option value="">All Brands</option>
                                @foreach($brands as $b)
                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Products Table / List Form -->
                    <form action="{{ route('admin.packages.items.bulk-add', $package->id) }}" method="POST" class="flex-grow overflow-y-auto min-h-[300px] flex flex-col justify-between space-y-3">
                        @csrf

                        <!-- Assign Area Selector Bar -->
                        <div class="bg-indigo-50 border border-indigo-200 p-3 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-3 flex-shrink-0">
                            <div class="flex items-center gap-2">
                                <span class="text-lg">📍</span>
                                <div>
                                    <label class="block text-xs font-black text-indigo-950 uppercase">Assign Selected Products to Area *</label>
                                    <p class="text-[11px] text-indigo-700">Choose which bathroom zone these products belong to.</p>
                                </div>
                            </div>
                            <select name="area" class="border-indigo-300 rounded-xl text-xs font-black text-slate-800 py-2 px-4 bg-white shadow-xs focus:ring-indigo-500">
                                <option value="Basin Area">💧 Basin Area</option>
                                <option value="WC Area">🚽 WC Area</option>
                                <option value="Shower Area">🚿 Shower Area</option>
                                <option value="Other Area">📦 Other Area</option>
                            </select>
                        </div>

                        <div class="overflow-y-auto max-h-[320px] divide-y divide-slate-100 border border-slate-200 rounded-2xl">
                            <!-- Select All Bar -->
                            <div class="bg-slate-100/70 p-2.5 px-4 flex items-center justify-between text-xs font-bold text-slate-700 sticky top-0 z-10 border-b">
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" @click="selectAllProducts()" :checked="selectedProductIds.length > 0 && selectedProductIds.length === searchResults.length" class="rounded border-slate-300 text-indigo-600 focus:ring-0">
                                    <span>Select All (<span x-text="selectedProductIds.length"></span> chosen)</span>
                                </label>
                                <span class="text-[11px] text-slate-500" x-text="searchResults.length + ' products found'"></span>
                            </div>

                            <!-- Loading Indicator -->
                            <div x-show="loadingProducts" class="py-12 text-center text-slate-400">
                                <svg class="w-6 h-6 animate-spin mx-auto mb-2 text-indigo-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                <span class="text-xs font-medium">Searching products catalog...</span>
                            </div>

                            <!-- Products Items List -->
                            <template x-for="prod in searchResults" :key="prod.id">
                                <div class="p-3 px-4 flex items-center gap-3 hover:bg-indigo-50/40 transition cursor-pointer" @click="toggleProductSelect(prod.id)">
                                    <input type="checkbox" name="product_ids[]" :value="prod.id" :checked="selectedProductIds.includes(prod.id)" class="rounded border-slate-300 text-indigo-600 focus:ring-0">

                                    <div class="w-12 h-12 bg-white rounded-lg border border-slate-200 p-1 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                        <template x-if="prod.image">
                                            <img :src="prod.image" class="w-full h-full object-contain">
                                        </template>
                                        <template x-if="!prod.image">
                                            <span class="text-xs text-slate-300">NO IMG</span>
                                        </template>
                                    </div>

                                    <div class="flex-grow min-w-0">
                                        <div class="flex items-center gap-2">
                                            <span class="font-mono text-[10px] font-bold text-slate-600 bg-slate-100 px-1.5 py-0.5 rounded" x-text="'SKU: ' + prod.sku"></span>
                                            <span class="text-[10px] font-bold text-indigo-600" x-text="prod.brand_name"></span>
                                        </div>
                                        <h4 class="text-xs font-bold text-slate-900 truncate mt-0.5" x-text="prod.name"></h4>
                                        <p class="text-[11px] text-slate-500 truncate" x-text="prod.category_name"></p>
                                    </div>

                                    <div class="text-right flex-shrink-0">
                                        <span class="text-xs font-black text-slate-900" x-text="'₹' + Number(prod.price).toLocaleString()"></span>
                                        <template x-if="prod.mrp && prod.mrp > prod.price">
                                            <span class="text-[10px] text-slate-400 line-through block" x-text="'₹' + Number(prod.mrp).toLocaleString()"></span>
                                        </template>
                                    </div>
                                </div>
                            </template>

                            <div x-show="!loadingProducts && searchResults.length === 0" class="py-12 text-center text-slate-400">
                                <p class="text-xs font-semibold">No products found matching filters.</p>
                                <p class="text-[11px] text-slate-400 mt-1">Try another search term or clear the filters.</p>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="pt-4 border-t flex items-center justify-between flex-shrink-0 mt-3">
                            <span class="text-xs text-slate-500">
                                Selected: <strong class="text-indigo-600 font-bold" x-text="selectedProductIds.length"></strong> products
                            </span>
                            <div class="flex items-center gap-2">
                                <button type="button" @click="productPickerModal = false" class="px-4 py-2 border rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50">Cancel</button>
                                <button type="submit" :disabled="selectedProductIds.length === 0" class="bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 text-white text-xs font-bold px-6 py-2 rounded-xl transition shadow-sm flex items-center gap-2">
                                    <span>Add Selected to Package &rarr;</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- ========================================================================= -->
        <!-- MODAL: ADD CUSTOM PRODUCT                                                 -->
        <!-- ========================================================================= -->
        <div x-show="addItemModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="min-h-screen px-4 text-center flex items-center justify-center">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="addItemModal = false"></div>

                <div class="bg-white rounded-3xl max-w-lg w-full p-7 text-left align-middle shadow-2xl transform transition-all relative z-10 space-y-4">
                    <div class="flex items-center justify-between border-b pb-3">
                        <h3 class="text-lg font-black text-slate-900">
                            Add Product to Package
                        </h3>
                        <button type="button" @click="addItemModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <!-- Quick Auto-Fill from Catalog Dropdown -->
                    <div class="bg-indigo-50/70 border border-indigo-100 p-3 rounded-2xl">
                        <label class="block text-[11px] font-bold text-indigo-900 uppercase mb-1">
                            ⚡ Quick Auto-Fill from Existing Products:
                        </label>
                        <select @change="if($event.target.value) { fillSingleFromProduct(JSON.parse($event.target.value)) }" class="w-full border-indigo-200 rounded-xl text-xs p-2 bg-white">
                            <option value="">-- Or choose an existing product to fill details --</option>
                            @foreach($existingProducts as $ep)
                                <option value="{{ json_encode(['id' => $ep->id, 'name' => $ep->name, 'sku' => $ep->sku, 'price' => $ep->price, 'description' => $ep->short_description ?? '']) }}">
                                    {{ $ep->name }} (SKU: {{ $ep->sku }}) - ₹{{ number_format($ep->price) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <form action="{{ route('admin.packages.items.store', $package->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3.5">
                        @csrf
                        <input type="hidden" name="product_id" id="single_product_id">

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Area / Section *</label>
                                <select name="area" required class="w-full border-slate-300 rounded-xl text-xs p-2.5 font-bold text-slate-800">
                                    <option value="Basin Area">💧 Basin Area</option>
                                    <option value="WC Area">🚽 WC Area</option>
                                    <option value="Shower Area">🚿 Shower Area</option>
                                    <option value="Other Area">📦 Other Area</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Cat. No. / SKU</label>
                                <input type="text" name="cat_no" id="single_cat_no" placeholder="e.g. F1015101 or S1040166" class="w-full border-slate-300 rounded-xl text-xs p-2.5 font-mono">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Product Name *</label>
                            <input type="text" name="name" id="single_name" required placeholder="e.g. VICTOR - Pillar cock with aerator" class="w-full border-slate-300 rounded-xl text-xs p-2.5 font-semibold">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Price (₹)</label>
                                <input type="number" step="0.01" name="price" id="single_price" placeholder="e.g. 1450" class="w-full border-slate-300 rounded-xl text-xs p-2.5">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Quantity</label>
                                <input type="number" name="quantity" value="1" min="1" class="w-full border-slate-300 rounded-xl text-xs p-2.5">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Description / Dimensions (Optional)</label>
                            <input type="text" name="description" id="single_desc" placeholder="e.g. Wall hung basin 405 x 325 x 145 mm" class="w-full border-slate-300 rounded-xl text-xs p-2.5">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Product Photo (Leave empty if picked from catalog)</label>
                            <input type="file" name="image" accept="image/*" class="w-full border border-slate-200 text-xs p-2 rounded-xl bg-slate-50">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Sort Order</label>
                            <input type="number" name="sort_order" value="0" class="w-full border-slate-300 rounded-xl text-xs p-2.5">
                        </div>

                        <div class="pt-3 border-t flex justify-end gap-2">
                            <button type="button" @click="addItemModal = false" class="px-4 py-2 border rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50">Cancel</button>
                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-5 py-2 rounded-xl transition">
                                Save Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- ========================================================================= -->
        <!-- MODAL: EDIT PRODUCT                                                       -->
        <!-- ========================================================================= -->
        <div x-show="editItemModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="min-h-screen px-4 text-center flex items-center justify-center">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" @click="editItemModal = false"></div>

                <div class="bg-white rounded-3xl max-w-lg w-full p-7 text-left align-middle shadow-2xl transform transition-all relative z-10 space-y-5">
                    <div class="flex items-center justify-between border-b pb-3">
                        <h3 class="text-lg font-black text-slate-900">
                            Edit Product in Package
                        </h3>
                        <button type="button" @click="editItemModal = false" class="text-slate-400 hover:text-slate-600 p-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form :action="'/admin/packages/items/' + editItemData.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Area / Section *</label>
                                <select name="area" x-model="editItemData.area" required class="w-full border-slate-300 rounded-xl text-xs p-2.5 font-bold text-slate-800">
                                    <option value="Basin Area">💧 Basin Area</option>
                                    <option value="WC Area">🚽 WC Area</option>
                                    <option value="Shower Area">🚿 Shower Area</option>
                                    <option value="Other Area">📦 Other Area</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Cat. No. / SKU</label>
                                <input type="text" name="cat_no" x-model="editItemData.cat_no" class="w-full border-slate-300 rounded-xl text-xs p-2.5 font-mono">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Product Name *</label>
                            <input type="text" name="name" x-model="editItemData.name" required class="w-full border-slate-300 rounded-xl text-xs p-2.5 font-semibold">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Price (₹)</label>
                                <input type="number" step="0.01" name="price" x-model="editItemData.price" class="w-full border-slate-300 rounded-xl text-xs p-2.5">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Quantity</label>
                                <input type="number" name="quantity" x-model="editItemData.quantity" min="1" class="w-full border-slate-300 rounded-xl text-xs p-2.5">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Description / Dimensions (Optional)</label>
                            <input type="text" name="description" x-model="editItemData.description" class="w-full border-slate-300 rounded-xl text-xs p-2.5">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Replace Photo (Optional)</label>
                            <input type="file" name="image" accept="image/*" class="w-full border border-slate-200 text-xs p-2 rounded-xl bg-slate-50">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Sort Order</label>
                            <input type="number" name="sort_order" x-model="editItemData.sort_order" class="w-full border-slate-300 rounded-xl text-xs p-2.5">
                        </div>

                        <div class="pt-3 border-t flex justify-end gap-2">
                            <button type="button" @click="editItemModal = false" class="px-4 py-2 border rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50">Cancel</button>
                            <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold px-5 py-2 rounded-xl transition">
                                Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
