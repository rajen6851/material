<x-admin-layout>
    <x-slot name="title">Add Product - Admin</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
            <div class="border-b pb-4">
                <h1 class="text-2xl font-black text-slate-900">Add New Product</h1>
                <p class="text-slate-500 text-sm">Add product with specifications, pricing and variant options.</p>
            </div>

            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Section: Basic Info --}}
                <div>
                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">Basic Information</span>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Product Name *</label>
                            <input type="text" name="name" required placeholder="e.g. Emesa White" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">SKU / Product Code *</label>
                            <input type="text" name="sku" required placeholder="e.g. EMESA-1200W" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                    </div>
                </div>

                {{-- Section: Classification --}}
                <div class="border-t pt-4">
                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">Classification</span>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Category *</label>
                            <select name="category_id" id="category_id" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sub Category</label>
                            <select name="sub_category" id="sub_category" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                <option value="">-- Select Category First --</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Room Space *</label>
                            <select name="room_id" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                <option value="">-- Select --</option>
                                @foreach($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Brand *</label>
                            <select name="brand_id" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Collection</label>
                            <select name="collection" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                <option value="">-- Select --</option>
                                @foreach($attributes['collection'] ?? [] as $col)
                                    <option value="{{ $col }}">{{ $col }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Material</label>
                            <select name="material" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                <option value="">-- Select --</option>
                                @foreach($attributes['material'] ?? [] as $mat)
                                    <option value="{{ $mat }}">{{ $mat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Finish</label>
                            <select name="finish" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                <option value="">-- Select --</option>
                                @foreach($attributes['finish'] ?? [] as $fin)
                                    <option value="{{ $fin }}">{{ $fin }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Section: Dimensions & Specs --}}
                <div class="border-t pt-4">
                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">Dimensions & Specifications</span>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Width (mm)</label>
                            <input type="number" name="width_mm" value="600" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Height (mm)</label>
                            <input type="number" name="height_mm" value="1200" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Size (mm)</label>
                            <input type="text" name="size" value="600x1200mm" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Size (inch)</label>
                            <input type="text" name="size_inch" value="24x48" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Thickness</label>
                            <input type="text" name="thickness" value="9MM" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Color</label>
                            <input type="text" name="color" placeholder="e.g. White, Beige" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pattern Type</label>
                            <select name="pattern_type" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                <option value="">-- Select --</option>
                                @foreach($attributes['pattern_type'] ?? [] as $pt)
                                    <option value="{{ $pt }}">{{ $pt }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Edge Type</label>
                            <select name="edge_type" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                <option value="">-- Select --</option>
                                @foreach($attributes['edge_type'] ?? [] as $et)
                                    <option value="{{ $et }}">{{ $et }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Area / Tile (sq.ft)</label>
                            <input type="number" name="area_tile_sqft" step="0.01" value="8" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Coverage Area</label>
                            <input type="text" name="coverage_area" placeholder="e.g. 1.44 sq.m / box" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Water Absorption</label>
                            <input type="text" name="water_absorption" placeholder="e.g. < 0.5%" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Application Area</label>
                            <select name="application_area" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                <option value="">-- Select --</option>
                                @foreach($attributes['application_area'] ?? [] as $aa)
                                    <option value="{{ $aa }}">{{ $aa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Section: Box & Pricing --}}
                <div class="border-t pt-4">
                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">Packaging & Pricing</span>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Pieces per Box</label>
                            <input type="number" name="pieces_per_box" value="2" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Coverage / Box (sq.ft)</label>
                            <input type="number" name="coverage_per_box_sqft" step="0.01" value="16" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Weight / Box (kg)</label>
                            <input type="number" name="weight_per_box_kg" step="0.01" value="30" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">GST %</label>
                            <input type="number" name="gst_percent" step="0.01" value="18" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Price / Box (₹) *</label>
                            <input type="number" name="price_per_box" step="0.01" value="880" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Price / Sq.ft (₹) *</label>
                            <input type="number" name="price" step="0.01" value="55" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Wholesale ₹/Sq.ft</label>
                            <input type="number" name="wholesale_price" step="0.01" placeholder="Trade price (pros only)" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">MRP (₹) *</label>
                            <input type="number" name="mrp" step="0.01" value="880" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Stock (Qty) *</label>
                            <input type="number" name="stock" value="250" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Price / Sq.ft (Duplicate)</label>
                            <input type="number" name="price_per_sqft" step="0.01" value="55" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Catalog Page</label>
                            <input type="text" name="catalog_page" value="1" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                    </div>
                </div>

                {{-- Section: Additional Info --}}
                <div class="border-t pt-4">
                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">Additional Details</span>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Warranty</label>
                            <input type="text" name="warranty" placeholder="e.g. 5 Years" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Delivery Time</label>
                            <input type="text" name="delivery_time" placeholder="e.g. 3-5 Business Days" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Product Image</label>
                            <input type="file" name="image" class="w-full border-slate-200 text-xs p-2">
                        </div>
                    </div>
                </div>

                {{-- Section: Visibility Toggles --}}
                <div class="border-t pt-4">
                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">Product Visibility</span>
                    <div class="flex flex-wrap gap-6">
                        <label class="inline-flex items-center gap-2 cursor-pointer group">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1" class="w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-teal-700 transition">⭐ Featured</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer group">
                            <input type="hidden" name="is_trending" value="0">
                            <input type="checkbox" name="is_trending" value="1" class="w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-teal-700 transition">🔥 Trending</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer group">
                            <input type="hidden" name="is_new" value="0">
                            <input type="checkbox" name="is_new" value="1" checked class="w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-teal-700 transition">🆕 New Arrival</span>
                        </label>
                    </div>
                </div>

                {{-- Section: SEO & Description --}}
                <div class="border-t pt-4">
                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">SEO & Description</span>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">SEO Meta Title</label>
                            <input type="text" name="seo_meta_title" placeholder="Complete Your Space..." class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">SEO Meta Description</label>
                            <input type="text" name="seo_meta_description" placeholder="Now available..." class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Short Description</label>
                        <input type="text" name="short_description" placeholder="Short intro copy..." class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    </div>
                    <div class="mt-4">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Description (Detailed)</label>
                        <textarea name="description" rows="3" placeholder="Full product description..." class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"></textarea>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="pt-4 flex gap-4 border-t">
                    <a href="{{ route('admin.products') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-3.5 rounded-xl text-center text-sm transition">Cancel</a>
                    <button type="submit" class="flex-grow bg-teal-600 hover:bg-teal-700 text-white font-bold py-3.5 rounded-xl shadow-md transition text-sm">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS: Category → Sub Category Dependent Dropdown --}}
    <script>
        const subCategoriesData = @json($subCategories->groupBy('category_id'));
        const categorySelect = document.getElementById('category_id');
        const subCategorySelect = document.getElementById('sub_category');

        categorySelect.addEventListener('change', function() {
            const catId = this.value;
            subCategorySelect.innerHTML = '<option value="">-- Select Sub Category --</option>';
            if (catId && subCategoriesData[catId]) {
                subCategoriesData[catId].forEach(function(sub) {
                    const opt = document.createElement('option');
                    opt.value = sub.name;
                    opt.textContent = sub.name;
                    subCategorySelect.appendChild(opt);
                });
            }
        });
    </script>
</x-admin-layout>
