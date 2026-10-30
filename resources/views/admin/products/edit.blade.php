<x-admin-layout>
    <x-slot name="title">Edit Product - Admin</x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 text-sm font-semibold">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Messages --}}
        @if($errors->any())
            <div class="mb-6 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-4">
                <p class="font-bold text-sm mb-2">Please fix the following errors:</p>

                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-sm">

            {{-- Header --}}
            <div class="border-b border-slate-200 pb-5 mb-6">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                    <div>
                        <h1 class="text-2xl font-black text-slate-900">
                            Edit Product
                        </h1>

                        <p class="text-slate-500 text-sm mt-1">
                            {{ $product->name }}
                        </p>
                    </div>

                    <div class="text-xs text-slate-400">
                        Product ID: #{{ $product->id }}
                    </div>

                </div>

            </div>


            <form
                action="{{ route('admin.products.update', $product->id) }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-8"
            >

                @csrf


                {{-- ========================================================= --}}
                {{-- BASIC INFORMATION --}}
                {{-- ========================================================= --}}

                <div>

                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-4">
                        Basic Information
                    </span>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Product Name --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Product Name *
                            </label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $product->name) }}"
                                required
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- SKU --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                SKU / Product Code *
                            </label>

                            <input
                                type="text"
                                name="sku"
                                value="{{ old('sku', $product->sku) }}"
                                required
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>

                    </div>

                </div>



                {{-- ========================================================= --}}
                {{-- CLASSIFICATION --}}
                {{-- ========================================================= --}}

                <div class="border-t border-slate-200 pt-6">

                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-4">
                        Classification
                    </span>


                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">


                        {{-- Category --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Category *
                            </label>

                            <select
                                name="category_id"
                                id="category_id"
                                required
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                                <option value="">
                                    -- Select Category --
                                </option>

                                @foreach($categories as $cat)

                                    <option
                                        value="{{ $cat->id }}"
                                        {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}
                                    >
                                        {{ $cat->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Sub Category --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Sub Category
                            </label>

                            <select
                                name="sub_category"
                                id="sub_category"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                                <option value="">
                                    -- Select Sub Category --
                                </option>

                            </select>

                        </div>


                        {{-- Room --}}
                       <div>
    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
        Room Space *
    </label>

    @php
        $selectedRooms = old(
            'room_ids',
            $product->rooms->pluck('id')->toArray()
        );
    @endphp

    <div class="border border-slate-300 rounded-xl p-3 space-y-2 max-h-60 overflow-y-auto">

        @foreach($rooms as $room)
            <label class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 cursor-pointer">

                <input
                    type="checkbox"
                    name="room_ids[]"
                    value="{{ $room->id }}"
                    {{ in_array($room->id, $selectedRooms) ? 'checked' : '' }}
                    class="w-5 h-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                >

                <span class="text-sm text-slate-700">
                    {{ $room->name }}
                </span>

            </label>
        @endforeach

    </div>
</div>

```blade
{{-- Related Products --}}
<div class="col-span-1 md:col-span-2 lg:col-span-4 mt-4">

    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
        Related Products
    </label>

    @php
        $selectedRelated = old(
            'related_product_ids',
            $product->relatedProducts->pluck('id')->toArray()
        );
    @endphp

    <div class="relative">

        {{-- Dropdown Button --}}
        <button
            type="button"
            id="relatedProductButton"
            class="w-full border border-slate-300 bg-white rounded-xl text-sm p-3 text-left flex items-center justify-between hover:border-indigo-400 focus:border-indigo-500"
        >

            <span id="relatedProductText" class="text-slate-500">
                Select Related Products
            </span>

            <span class="text-slate-400">
                ▼
            </span>

        </button>


        {{-- Dropdown --}}
        <div
            id="relatedProductDropdown"
            class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-xl"
        >

            {{-- Search --}}
            <div class="p-3 border-b border-slate-200">

                <input
                    type="text"
                    id="relatedProductSearch"
                    placeholder="Search product by name or SKU..."
                    autocomplete="off"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:border-indigo-500 focus:ring-0"
                >

            </div>


            {{-- Products --}}
            <div
                id="relatedProductList"
                class="max-h-64 overflow-y-auto p-2"
            >

                @foreach($allProducts as $p)

                    @if($p->id != $product->id)

                        <label
                            class="related-product-item flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-slate-50 cursor-pointer"
                            data-name="{{ strtolower($p->name) }}"
                            data-sku="{{ strtolower($p->sku ?? '') }}"
                        >

                            <input
                                type="checkbox"
                                name="related_product_ids[]"
                                value="{{ $p->id }}"
                                class="related-product-checkbox w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                                {{ in_array($p->id, $selectedRelated) ? 'checked' : '' }}
                            >

                            <div class="flex-1 min-w-0">

                                <div class="text-sm font-medium text-slate-700 truncate">
                                    {{ $p->name }}
                                </div>

                                <div class="text-xs text-slate-400">
                                    SKU: {{ $p->sku }}
                                </div>

                            </div>

                        </label>

                    @endif

                @endforeach

            </div>


            {{-- No Result --}}
            <div
                id="relatedProductNoResult"
                class="hidden p-4 text-center text-sm text-slate-400"
            >
                No products found.
            </div>

        </div>

    </div>


    {{-- Selected Count --}}
    <div class="mt-2 text-xs text-slate-400">

        <span id="relatedProductCount">
            {{ count($selectedRelated) }}
        </span>

        product(s) selected

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const button = document.getElementById(
        'relatedProductButton'
    );

    const dropdown = document.getElementById(
        'relatedProductDropdown'
    );

    const search = document.getElementById(
        'relatedProductSearch'
    );

    const text = document.getElementById(
        'relatedProductText'
    );

    const count = document.getElementById(
        'relatedProductCount'
    );

    const noResult = document.getElementById(
        'relatedProductNoResult'
    );

    const items = document.querySelectorAll(
        '.related-product-item'
    );

    const checkboxes = document.querySelectorAll(
        '.related-product-checkbox'
    );


    /*
    |--------------------------------------------------------------------------
    | Open / Close Dropdown
    |--------------------------------------------------------------------------
    */

    button.addEventListener('click', function (event) {

        event.stopPropagation();

        dropdown.classList.toggle('hidden');

    });


    /*
    |--------------------------------------------------------------------------
    | Search Products
    |--------------------------------------------------------------------------
    */

    search.addEventListener('input', function () {

        const keyword =
            this.value.toLowerCase().trim();

        let visibleCount = 0;


        items.forEach(function (item) {

            const name =
                item.dataset.name || '';

            const sku =
                item.dataset.sku || '';


            if (
                name.includes(keyword) ||
                sku.includes(keyword)
            ) {

                item.classList.remove('hidden');

                visibleCount++;

            } else {

                item.classList.add('hidden');

            }

        });


        if (visibleCount === 0) {

            noResult.classList.remove('hidden');

        } else {

            noResult.classList.add('hidden');

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Checkbox Change
    |--------------------------------------------------------------------------
    */

    checkboxes.forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            updateRelatedProducts();

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Update Selected Text
    |--------------------------------------------------------------------------
    */

    function updateRelatedProducts() {

        const selected =
            document.querySelectorAll(
                '.related-product-checkbox:checked'
            );


        count.innerText =
            selected.length;


        if (selected.length === 0) {

            text.innerText =
                'Select Related Products';

            text.classList.add('text-slate-500');

            return;

        }


        const names = [];


        selected.forEach(function (checkbox) {

            const item =
                checkbox.closest(
                    '.related-product-item'
                );


            const name =
                item.querySelector(
                    '.text-sm'
                );


            if (name) {

                names.push(
                    name.innerText.trim()
                );

            }

        });


        if (names.length <= 3) {

            text.innerText =
                names.join(', ');

        } else {

            text.innerText =
                names.slice(0, 3).join(', ')
                + ' +'
                + (names.length - 3)
                + ' more';

        }


        text.classList.remove('text-slate-500');

    }


    /*
    |--------------------------------------------------------------------------
    | Click Outside
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function (event) {

        if (
            !dropdown.contains(event.target) &&
            !button.contains(event.target)
        ) {

            dropdown.classList.add('hidden');

        }

    });


    /*
    |--------------------------------------------------------------------------
    | Initial Selected Products
    |--------------------------------------------------------------------------
    */

    updateRelatedProducts();

});

</script>


                        {{-- Brand --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Brand *
                            </label>

                            <select
                                name="brand_id"
                                required
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                                <option value="">
                                    -- Select Brand --
                                </option>

                                @foreach($brands as $brand)

                                    <option
                                        value="{{ $brand->id }}"
                                        {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}
                                    >
                                        {{ $brand->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    {{-- Collection / Material / Finish --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">


                        {{-- Collection --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Collection
                            </label>

                            <select
                                name="collection"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                                <option value="">
                                    -- Select --
                                </option>

                                @foreach($attributes['collection'] ?? [] as $col)

                                    <option
                                        value="{{ $col }}"
                                        {{ old('collection', $product->collection) == $col ? 'selected' : '' }}
                                    >
                                        {{ $col }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Material --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Material
                            </label>

                            <select
                                name="material"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                                <option value="">
                                    -- Select --
                                </option>

                                @foreach($attributes['material'] ?? [] as $mat)

                                    <option
                                        value="{{ $mat }}"
                                        {{ old('material', $product->material) == $mat ? 'selected' : '' }}
                                    >
                                        {{ $mat }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Finish --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Finish
                            </label>

                            <select
                                name="finish"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                                <option value="">
                                    -- Select --
                                </option>

                                @foreach($attributes['finish'] ?? [] as $fin)

                                    <option
                                        value="{{ $fin }}"
                                        {{ old('finish', $product->finish) == $fin ? 'selected' : '' }}
                                    >
                                        {{ $fin }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>



                {{-- ========================================================= --}}
                {{-- WC / EWC DETAILS --}}
                {{-- ========================================================= --}}

                <div class="border-t border-slate-200 pt-6">

                    <h2 class="text-xl font-semibold text-gray-800 mb-5">
                        WC / EWC Details
                    </h2>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                        {{-- Model --}}
                        <div>

                            <label
                                for="model_article_no"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Model / Article No.
                            </label>

                            <input
                                type="text"
                                id="model_article_no"
                                name="model_article_no"
                                value="{{ old('model_article_no', $product->model_article_no) }}"
                                placeholder="Enter Model / Article No."
                                class="w-full border border-gray-300 rounded-lg px-3 py-2"
                            >

                        </div>


                        {{-- Product Type --}}
                        <div>

                            <label
                                for="product_type"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Product Type
                            </label>

                            <input
                                type="text"
                                id="product_type"
                                name="product_type"
                                value="{{ old('product_type', $product->product_type) }}"
                                placeholder="Western WC / EWC"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2"
                            >

                        </div>


                        {{-- Trap Type --}}
                        <div>

                            <label
                                for="trap_type"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Trap Type
                            </label>

                            <input
                                type="text"
                                id="trap_type"
                                name="trap_type"
                                value="{{ old('trap_type', $product->trap_type) }}"
                                placeholder="S-Trap / P-Trap"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2"
                            >

                        </div>


                        {{-- Outlet --}}
                        <div>

                            <label
                                for="outlet_type"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Outlet Type
                            </label>

                            <input
                                type="text"
                                id="outlet_type"
                                name="outlet_type"
                                value="{{ old('outlet_type', $product->outlet_type) }}"
                                placeholder="Horizontal / Vertical"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2"
                            >

                        </div>


                        {{-- Flush --}}
                        <div>

                            <label
                                for="flush_type"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Flush Type
                            </label>

                            <input
                                type="text"
                                id="flush_type"
                                name="flush_type"
                                value="{{ old('flush_type', $product->flush_type) }}"
                                placeholder="Single Flush / Dual Flush"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2"
                            >

                        </div>


                        {{-- Mounting --}}
                        <div>

                            <label
                                for="mounting_type"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Mounting Type
                            </label>

                            <input
                                type="text"
                                id="mounting_type"
                                name="mounting_type"
                                value="{{ old('mounting_type', $product->mounting_type) }}"
                                placeholder="Floor Mounted / Wall Hung"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2"
                            >

                        </div>


                        {{-- Seat Cover --}}
                        <div>

                            <label
                                for="seat_cover"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Seat Cover
                            </label>

                            <select
                                id="seat_cover"
                                name="seat_cover"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2"
                            >

                                <option value="">
                                    Select Seat Cover
                                </option>

                                <option
                                    value="Included"
                                    @selected(old('seat_cover', $product->seat_cover) == 'Included')
                                >
                                    Included
                                </option>

                                <option
                                    value="Optional"
                                    @selected(old('seat_cover', $product->seat_cover) == 'Optional')
                                >
                                    Optional
                                </option>

                            </select>

                        </div>
                        
                        <div>
    <label class="block text-sm font-medium text-slate-700 mb-2">
        Flushing System
    </label>
    <input 
        type="text" 
        name="flushing_system" 
        value="{{ old('flushing_system', $product->flushing_system ?? '') }}" 
        placeholder="e.g. Single Flush / Dual Flush"
        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500"
    >
</div>



<div>
    <label class="block text-sm font-medium text-slate-700 mb-2">
        Installation
    </label>
    <input 
        type="text" 
        name="installation" 
        value="{{ old('installation', $product->installation ?? '') }}" 
        placeholder="e.g. Floor Mounted / Wall Mounted"
        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500"
    >
</div>


                        {{-- Flush Tank --}}
                        <div>

                            <label
                                for="flush_tank"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Flush Tank
                            </label>

                            <select
                                id="flush_tank"
                                name="flush_tank"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2"
                            >

                                <option value="">
                                    Select Flush Tank
                                </option>

                                <option
                                    value="Included"
                                    @selected(old('flush_tank', $product->flush_tank) == 'Included')
                                >
                                    Included
                                </option>

                                <option
                                    value="Optional"
                                    @selected(old('flush_tank', $product->flush_tank) == 'Optional')
                                >
                                    Optional
                                </option>

                            </select>

                        </div>


                        {{-- Availability --}}
                        <div>

                            <label
                                for="availability"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Availability
                            </label>

                            <select
                                id="availability"
                                name="availability"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2"
                            >

                                <option value="">
                                    Select Availability
                                </option>

                                <option
                                    value="In Stock"
                                    @selected(old('availability', $product->availability) == 'In Stock')
                                >
                                    In Stock
                                </option>

                                <option
                                    value="Out of Stock"
                                    @selected(old('availability', $product->availability) == 'Out of Stock')
                                >
                                    Out of Stock
                                </option>

                                <option
                                    value="Pre Order"
                                    @selected(old('availability', $product->availability) == 'Pre Order')
                                >
                                    Pre Order
                                </option>

                            </select>

                        </div>


                        {{-- Weight --}}
                        <div>

                            <label
                                for="weight"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Weight (kg)
                            </label>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                id="weight"
                                name="weight"
                                value="{{ old('weight', $product->weight) }}"
                                placeholder="Enter Weight in KG"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2"
                            >

                        </div>

                    </div>

                </div>



                {{-- ========================================================= --}}
                {{-- DIMENSIONS & SPECIFICATIONS --}}
                {{-- ========================================================= --}}

                <div class="border-t border-slate-200 pt-6">

                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-4">
                        Dimensions & Specifications
                    </span>


                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">


                        {{-- Width --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Width (mm)
                            </label>

                            <input
                                type="number"
                                name="width_mm"
                                value="{{ old('width_mm', $product->width_mm) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Height --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Height (mm)
                            </label>

                            <input
                                type="number"
                                name="height_mm"
                                value="{{ old('height_mm', $product->height_mm) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Size --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Size (mm)
                            </label>

                            <input
                                type="text"
                                name="size"
                                value="{{ old('size', $product->size) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Inch --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Size (inch)
                            </label>

                            <input
                                type="text"
                                name="size_inch"
                                value="{{ old('size_inch', $product->size_inch) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>

                    </div>


                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">


                        {{-- Thickness --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Thickness
                            </label>

                            <input
                                type="text"
                                name="thickness"
                                value="{{ old('thickness', $product->thickness) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Pattern --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Pattern Type
                            </label>

                            <select
                                name="pattern_type"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                                <option value="">
                                    -- Select --
                                </option>

                                @foreach($attributes['pattern_type'] ?? [] as $pt)

                                    <option
                                        value="{{ $pt }}"
                                        {{ old('pattern_type', $product->pattern_type) == $pt ? 'selected' : '' }}
                                    >
                                        {{ $pt }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- Edge --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Edge Type
                            </label>

                            <select
                                name="edge_type"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                                <option value="">
                                    -- Select --
                                </option>

                                @foreach($attributes['edge_type'] ?? [] as $et)

                                    <option
                                        value="{{ $et }}"
                                        {{ old('edge_type', $product->edge_type) == $et ? 'selected' : '' }}
                                    >
                                        {{ $et }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">


                        {{-- Area Tile --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Area / Tile (sq.ft)
                            </label>

                            <input
                                type="number"
                                name="area_tile_sqft"
                                step="0.01"
                                value="{{ old('area_tile_sqft', $product->area_tile_sqft) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Coverage --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Coverage Area
                            </label>

                            <input
                                type="text"
                                name="coverage_area"
                                value="{{ old('coverage_area', $product->coverage_area) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Water Absorption --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Water Absorption
                            </label>

                            <input
                                type="text"
                                name="water_absorption"
                                value="{{ old('water_absorption', $product->water_absorption) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Application --}}
                        @php

    $selectedApplications = old(
        'application_area',
        $product->application_area ?? []
    );

    if (!is_array($selectedApplications)) {

        $selectedApplications = $selectedApplications
            ? [$selectedApplications]
            : [];

    }

@endphp
                      {{-- Application Area --}}
<div class="relative">

    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
        Application Area
    </label>

    <div class="relative">

        <button
            type="button"
            id="applicationAreaButton"
            class="w-full border border-slate-300 bg-white rounded-xl text-sm p-3 text-left flex items-center justify-between"
        >

            <span id="applicationAreaText">
                Select Application Area
            </span>

            <span>▼</span>

        </button>


        <div
            id="applicationAreaDropdown"
            class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-y-auto"
        >

            @foreach($attributes['application_area'] ?? [] as $aa)

                <label
                    class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 cursor-pointer"
                >

                    <input
                        type="checkbox"
                        name="application_area[]"
                        value="{{ $aa }}"
                        class="application-area-checkbox w-4 h-4"
                        {{ in_array($aa, $selectedApplications) ? 'checked' : '' }}
                    >

                    <span class="text-sm text-slate-700">
                        {{ $aa }}
                    </span>

                </label>

            @endforeach

        </div>

    </div>

</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const button = document.getElementById('applicationAreaButton');

    const dropdown = document.getElementById('applicationAreaDropdown');

    const text = document.getElementById('applicationAreaText');


    if (!button || !dropdown) {
        return;
    }


    button.addEventListener('click', function (event) {

        event.stopPropagation();

        dropdown.classList.toggle('hidden');

    });


    function updateApplicationText() {

        const checked = document.querySelectorAll(
            '.application-area-checkbox:checked'
        );


        if (checked.length === 0) {

            text.innerText = 'Select Application Area';

            return;
        }


        const values = Array.from(checked).map(function (checkbox) {

            return checkbox.value;

        });


        text.innerText = values.join(', ');

    }


    document.querySelectorAll(
        '.application-area-checkbox'
    ).forEach(function (checkbox) {

        checkbox.addEventListener('change', function () {

            updateApplicationText();

        });

    });


    document.addEventListener('click', function (event) {

        if (
            !dropdown.contains(event.target) &&
            !button.contains(event.target)
        ) {

            dropdown.classList.add('hidden');

        }

    });


    // Existing values show
    updateApplicationText();

});

</script>

                    </div>

                </div>



                {{-- ========================================================= --}}
                {{-- PACKAGING & PRICING --}}
                {{-- ========================================================= --}}

                <div class="border-t border-slate-200 pt-6">

                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-4">
                        Packaging & Pricing
                    </span>


                    {{-- Packaging --}}
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">


                        {{-- Pieces --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Pieces per Box
                            </label>

                            <input
                                type="number"
                                name="pieces_per_box"
                                min="0"
                                value="{{ old('pieces_per_box', $product->pieces_per_box) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Coverage Box --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Coverage / Box (sq.ft)
                            </label>

                            <input
                                type="number"
                                name="coverage_per_box_sqft"
                                id="coverage_per_box_sqft"
                                step="0.01"
                                min="0"
                                value="{{ old('coverage_per_box_sqft', $product->coverage_per_box_sqft) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Weight Box --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Weight / Box (kg)
                            </label>

                            <input
                                type="number"
                                name="weight_per_box_kg"
                                step="0.01"
                                min="0"
                                value="{{ old('weight_per_box_kg', $product->weight_per_box_kg) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- GST --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                GST %
                            </label>

                            <input
                                type="number"
                                name="gst_percent"
                                step="0.01"
                                min="0"
                                value="{{ old('gst_percent', $product->gst_percent ?? 18) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>

                    </div>


                    {{-- Pricing --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-5">


                        {{-- Price Box --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Price / Box (₹)
                            </label>

                            <input
                                type="number"
                                name="price_per_box"
                                id="price_per_box"
                                step="0.01"
                                min="0"
                                value="{{ old('price_per_box', $product->price_per_box) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Stock --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Stock (Qty) *
                            </label>

                            <input
                                type="number"
                                name="stock"
                                min="0"
                                value="{{ old('stock', $product->stock) }}"
                                required
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Wholesale --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Wholesale ₹/Sq.ft
                            </label>

                            <input
                                type="number"
                                name="wholesale_price"
                                step="0.01"
                                min="0"
                                value="{{ old('wholesale_price', $product->wholesale_price) }}"
                                placeholder="Trade price"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- MRP --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                MRP / Sq.ft (₹) *
                            </label>

                            <input
                                type="number"
                                name="mrp"
                                id="mrp"
                                step="0.01"
                                min="0"
                                value="{{ old('mrp', $product->mrp) }}"
                                required
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                            <p class="text-[11px] text-slate-400 mt-1">
                                Maximum Retail Price
                            </p>

                        </div>


                        {{-- Discount --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Discount (%)
                            </label>

                            <input
                                type="number"
                                name="discount"
                                id="discount"
                                step="0.01"
                                min="0"
                                max="100"
                                value="{{ old('discount', $product->discount ?? 0) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                            <p class="text-[11px] text-slate-400 mt-1">
                                Enter discount percentage
                            </p>

                        </div>


                        {{-- Selling Price --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Selling Price / Sq.ft (₹) *
                            </label>

                            <input
                                type="number"
                                name="price"
                                id="price"
                                step="0.01"
                                min="0"
                                value="{{ old('price', $product->price) }}"
                                readonly
                                required
                                class="w-full bg-slate-100 border-slate-300 rounded-xl text-sm p-3"
                            >

                            <p class="text-[11px] text-slate-400 mt-1">
                                Auto calculated from MRP and discount
                            </p>

                        </div>

                    </div>


                    {{-- Discount Summary --}}
                    <div class="mt-5 rounded-xl bg-slate-50 border border-slate-200 p-4">

                        <div class="flex flex-wrap items-center justify-between gap-2">

                            <div>

                                <p class="text-xs font-bold text-slate-500 uppercase">
                                    Discount
                                </p>

                                <p class="text-sm text-slate-500 mt-1">
                                    Percentage applied on MRP
                                </p>

                            </div>

                            <div class="text-right">

                                <p
                                    id="discount_summary"
                                    class="text-xl font-black text-emerald-600"
                                >
                                    0%
                                </p>

                                <p class="text-[11px] text-slate-400">
                                    Discount %
                                </p>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- ========================================================= --}}
                {{-- PRODUCT IMAGES --}}
                {{-- ========================================================= --}}

                <div class="border-t border-slate-200 pt-6">

                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2 mb-5">

                        <div>

                            <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-1">
                                Product Images
                            </span>

                            <h2 class="text-lg font-bold text-slate-800">
                                Manage Product Gallery
                            </h2>

                            <p class="text-xs text-slate-400 mt-1">
                                Har image ke saath color assign kar sakte ho.
                            </p>

                        </div>

                    </div>


                    {{-- INFO BOX --}}
                    <div class="mb-5 rounded-xl bg-teal-50 border border-teal-100 p-4">

                        <div class="flex gap-3">

                            <div class="text-teal-600 text-lg">
                                ℹ️
                            </div>

                            <div class="text-sm text-teal-800">

                                <p class="font-bold mb-1">
                                    Image Color Mapping
                                </p>

                                <p class="text-xs leading-5">
                                    Agar product ke images alag-alag colors ke hain,
                                    to har image ke liye color select karein.
                                    Example:
                                    White → 2 images,
                                    Black → 3 images,
                                    Ivory → 2 images.
                                </p>

                                <p class="text-xs mt-2">
                                    Normal product ke liye
                                    <strong>No Color</strong>
                                    select karein.
                                </p>

                            </div>

                        </div>

                    </div>



                    {{-- ===================================================== --}}
                    {{-- EXISTING IMAGES --}}
                    {{-- ===================================================== --}}

                    <div>

                        <div class="flex items-center justify-between mb-3">

                            <h3 class="text-sm font-bold text-slate-700">
                                Existing Product Images
                            </h3>

                            <span class="text-xs text-slate-400">
                                {{ $product->images->count() }} image(s)
                            </span>

                        </div>


                        @if($product->images->count() > 0)

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                                @foreach($product->images as $image)

                                    <div
                                        class="relative border border-slate-200 rounded-2xl p-3 bg-white shadow-sm"
                                    >

                                        {{-- IMAGE --}}
                                        <div class="relative">

                                            <img
                                                src="{{ asset($image->image_path) }}"
                                                alt="{{ $product->name }}"
                                                class="w-full h-40 object-contain rounded-xl bg-slate-50 border"
                                            >


                                            {{-- Primary --}}
                                            @if($image->is_primary)

                                                <span
                                                    class="absolute top-2 left-2 bg-teal-600 text-white text-[10px] px-2 py-1 rounded-full font-bold shadow"
                                                >
                                                    Primary
                                                </span>

                                            @endif

                                        </div>


                                        {{-- Image ID --}}
                                        <p class="text-[10px] text-slate-400 mt-2">
                                            Image #{{ $image->id }}
                                        </p>


                                        {{-- IMAGE COLOR --}}
                                        <div class="mt-3">

                                            <label
                                                class="block text-xs font-semibold text-slate-600 mb-1"
                                            >
                                                Image Color
                                            </label>

                                            <select
                                                name="existing_colors[{{ $image->id }}]"
                                                class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:border-teal-500 focus:ring-teal-500"
                                            >

                                                <option value="">
                                                    No Color
                                                </option>

                                                @foreach($colors as $color)

                                                    <option
                                                        value="{{ $color->value }}"
                                                        @selected(
                                                            old(
                                                                "existing_colors.{$image->id}",
                                                                $image->color
                                                            ) == $color->value
                                                        )
                                                    >
                                                        {{ $color->value }}
                                                    </option>

                                                @endforeach

                                            </select>

                                        </div>


                                        {{-- DELETE --}}
                                        <label
                                            class="flex items-center gap-2 mt-3 text-xs text-red-600 cursor-pointer select-none"
                                        >

                                            <input
                                                type="checkbox"
                                                name="delete_images[]"
                                                value="{{ $image->id }}"
                                                class="w-4 h-4 rounded border-slate-300 text-red-600 focus:ring-red-500"
                                            >

                                            Delete this image

                                        </label>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="border border-dashed border-slate-300 rounded-2xl p-8 text-center">

                                <div class="text-3xl mb-2">
                                    🖼️
                                </div>

                                <p class="text-sm font-semibold text-slate-600">
                                    No existing images
                                </p>

                                <p class="text-xs text-slate-400 mt-1">
                                    Add images below.
                                </p>

                            </div>

                        @endif

                    </div>



                    {{-- ===================================================== --}}
                    {{-- ADD NEW IMAGES --}}
                    {{-- ===================================================== --}}

                    <div class="mt-8 border-t border-slate-200 pt-6">

                        <div class="mb-4">

                            <h3 class="text-sm font-bold text-slate-700">
                                Add More Images
                            </h3>

                            <p class="text-xs text-slate-400 mt-1">
                                Har new image ke liye optional color select karein.
                            </p>

                        </div>


                        <div
                            id="image-upload-list"
                            class="space-y-3"
                        >


                            {{-- FIRST ROW --}}
                            <div
                                class="image-upload-row flex flex-col lg:flex-row gap-3 items-start p-3 bg-slate-50 border border-slate-200 rounded-xl"
                            >

                                {{-- File --}}
                                <div class="flex-1 w-full">

                                    <label class="block text-[11px] font-bold text-slate-500 mb-1">
                                        Image
                                    </label>

                                    <input
                                        type="file"
                                        name="images[]"
                                        accept="image/*"
                                        class="block w-full text-sm text-slate-600
                                               file:mr-4 file:py-2 file:px-4
                                               file:rounded-lg file:border-0
                                               file:bg-white file:text-slate-700
                                               file:font-semibold
                                               file:border file:border-slate-200"
                                    >

                                </div>


                                {{-- Color --}}
                                <div class="w-full lg:w-52">

                                    <label class="block text-[11px] font-bold text-slate-500 mb-1">
                                        Image Color
                                    </label>

                                    <select
                                        name="colors[]"
                                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-white"
                                    >

                                        <option value="">
                                            No Color
                                        </option>

                                        @foreach($colors as $color)

                                            <option value="{{ $color->value }}">
                                                {{ $color->value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                {{-- Remove --}}
                                <div class="w-full lg:w-auto lg:pt-5">

                                    <button
                                        type="button"
                                        onclick="removeImageRow(this)"
                                        class="w-full lg:w-auto px-4 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold transition"
                                    >
                                        Remove
                                    </button>

                                </div>

                            </div>

                        </div>


                        {{-- Add Button --}}
                        <button
                            type="button"
                            onclick="addImageRow()"
                            class="mt-4 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold transition"
                        >
                            + Add Another Image
                        </button>


                        <p class="text-xs text-slate-400 mt-3">
                            Maximum 2MB per image. Color optional hai.
                        </p>

                    </div>

                </div>



                {{-- ========================================================= --}}
                {{-- ADDITIONAL DETAILS --}}
                {{-- ========================================================= --}}

                <div class="border-t border-slate-200 pt-6">

                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-4">
                        Additional Details
                    </span>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                        {{-- Warranty --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Warranty
                            </label>

                            <input
                                type="text"
                                name="warranty"
                                value="{{ old('warranty', $product->warranty) }}"
                                placeholder="e.g. 5 Years"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Delivery --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Delivery Time
                            </label>

                            <input
                                type="text"
                                name="delivery_time"
                                value="{{ old('delivery_time', $product->delivery_time) }}"
                                placeholder="e.g. 3-5 Days"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>

                    </div>

                </div>



                {{-- ========================================================= --}}
                {{-- VISIBILITY --}}
                {{-- ========================================================= --}}

                <div class="border-t border-slate-200 pt-6">

                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-4">
                        Product Visibility
                    </span>


                    <div class="flex flex-wrap gap-6">


                        {{-- Featured --}}
                        <label class="inline-flex items-center gap-2 cursor-pointer group">

                            <input
                                type="hidden"
                                name="is_featured"
                                value="0"
                            >

                            <input
                                type="checkbox"
                                name="is_featured"
                                value="1"
                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500"
                            >

                            <span class="text-sm font-semibold text-slate-700 group-hover:text-teal-700 transition">
                                ⭐ Featured
                            </span>

                        </label>


                        {{-- Trending --}}
                        <label class="inline-flex items-center gap-2 cursor-pointer group">

                            <input
                                type="hidden"
                                name="is_trending"
                                value="0"
                            >

                            <input
                                type="checkbox"
                                name="is_trending"
                                value="1"
                                {{ old('is_trending', $product->is_trending) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500"
                            >

                            <span class="text-sm font-semibold text-slate-700 group-hover:text-teal-700 transition">
                                🔥 Trending
                            </span>

                        </label>


                        {{-- New --}}
                        <label class="inline-flex items-center gap-2 cursor-pointer group">

                            <input
                                type="hidden"
                                name="is_new"
                                value="0"
                            >

                            <input
                                type="checkbox"
                                name="is_new"
                                value="1"
                                {{ old('is_new', $product->is_new) ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500"
                            >

                            <span class="text-sm font-semibold text-slate-700 group-hover:text-teal-700 transition">
                                🆕 New Arrival
                            </span>

                        </label>

                    </div>

                </div>



                {{-- ========================================================= --}}
                {{-- SEO & DESCRIPTION --}}
                {{-- ========================================================= --}}

                <div class="border-t border-slate-200 pt-6">

                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-4">
                        SEO & Description
                    </span>


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                        {{-- SEO Title --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                SEO Meta Title
                            </label>

                            <input
                                type="text"
                                name="seo_meta_title"
                                value="{{ old('seo_meta_title', $product->seo_meta_title) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- SEO Description --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                SEO Meta Description
                            </label>

                            <input
                                type="text"
                                name="seo_meta_description"
                                value="{{ old('seo_meta_description', $product->seo_meta_description) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>

                    </div>


                    {{-- Short Description --}}
                    <div class="mt-4">

                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                            Short Description
                        </label>

                        <input
                            type="text"
                            name="short_description"
                            value="{{ old('short_description', $product->short_description) }}"
                            class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                        >

                    </div>


                    {{-- Description --}}
                    <div class="mt-4">

                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                            Description (Detailed)
                        </label>

                        <textarea
                            name="description"
                            rows="5"
                            class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                        >{{ old('description', $product->description) }}</textarea>

                    </div>

                </div>



                {{-- ========================================================= --}}
                {{-- SUBMIT --}}
                {{-- ========================================================= --}}

                <div class="pt-6 flex flex-col sm:flex-row gap-4 border-t border-slate-200">

                    <a
                        href="{{ route('admin.products') }}"
                        class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-3.5 rounded-xl text-center text-sm transition"
                    >
                        Cancel
                    </a>


                    <button
                        type="submit"
                        class="flex-grow bg-teal-600 hover:bg-teal-700 text-white font-bold py-3.5 rounded-xl shadow-md transition text-sm"
                    >
                        Update Product
                    </button>

                </div>

            </form>

        </div>

    </div>



    {{-- ============================================================= --}}
    {{-- JS: ADD / REMOVE IMAGE ROW --}}
    {{-- ============================================================= --}}

    <script>

        function addImageRow() {

            const container = document.getElementById('image-upload-list');

            if (!container) {
                return;
            }


            const row = document.createElement('div');

            row.className =
                'image-upload-row flex flex-col lg:flex-row gap-3 items-start p-3 bg-slate-50 border border-slate-200 rounded-xl';


            row.innerHTML = `

                <div class="flex-1 w-full">

                    <label class="block text-[11px] font-bold text-slate-500 mb-1">
                        Image
                    </label>

                    <input
                        type="file"
                        name="images[]"
                        accept="image/*"
                        class="block w-full text-sm text-slate-600
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-lg file:border-0
                               file:bg-white file:text-slate-700
                               file:font-semibold
                               file:border file:border-slate-200"
                    >

                </div>


                <div class="w-full lg:w-52">

                    <label class="block text-[11px] font-bold text-slate-500 mb-1">
                        Image Color
                    </label>

                    <select
                        name="colors[]"
                        class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-white"
                    >

                        <option value="">
                            No Color
                        </option>

                        @foreach($colors as $color)

                            <option value="{{ $color->value }}">
                                {{ $color->value }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="w-full lg:w-auto lg:pt-5">

                    <button
                        type="button"
                        onclick="removeImageRow(this)"
                        class="w-full lg:w-auto px-4 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold transition"
                    >
                        Remove
                    </button>

                </div>

            `;


            container.appendChild(row);

        }



        function removeImageRow(button) {

            const row = button.closest('.image-upload-row');

            if (row) {
                row.remove();
            }

        }

    </script>



    {{-- ============================================================= --}}
    {{-- JS: CATEGORY → SUB CATEGORY --}}
    {{-- ============================================================= --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const subCategoriesData =
                @json($subCategories->groupBy('category_id'));

            const categorySelect =
                document.getElementById('category_id');

            const subCategorySelect =
                document.getElementById('sub_category');

            const currentSubCategory =
                @json(old('sub_category', $product->sub_category));


            function populateSubCategories(catId, selectedValue) {

                subCategorySelect.innerHTML =
                    '<option value="">-- Select Sub Category --</option>';


                if (
                    catId &&
                    subCategoriesData[catId]
                ) {

                    subCategoriesData[catId].forEach(function (sub) {

                        const option =
                            document.createElement('option');

                        option.value =
                            sub.name;

                        option.textContent =
                            sub.name;


                        if (
                            sub.name === selectedValue
                        ) {

                            option.selected = true;

                        }


                        subCategorySelect.appendChild(option);

                    });

                }

            }


            // Initial load
            populateSubCategories(
                categorySelect.value,
                currentSubCategory
            );


            // Category change
            categorySelect.addEventListener(
                'change',
                function () {

                    populateSubCategories(
                        this.value,
                        null
                    );

                }
            );

        });

    </script>



    {{-- ============================================================= --}}
    {{-- JS: MRP → DISCOUNT → SELLING PRICE --}}
    {{-- ============================================================= --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const mrpInput =
                document.getElementById('mrp');

            const discountInput =
                document.getElementById('discount');

            const priceInput =
                document.getElementById('price');

            const coverageInput =
                document.getElementById('coverage_per_box_sqft');

            const pricePerBoxInput =
                document.getElementById('price_per_box');

            const discountSummary =
                document.getElementById('discount_summary');


            if (
                !mrpInput ||
                !discountInput ||
                !priceInput
            ) {
                return;
            }


            function calculateSellingPrice() {

                const mrp =
                    parseFloat(mrpInput.value) || 0;

                const discount =
                    parseFloat(discountInput.value) || 0;


                // Keep discount between 0 and 100
                const validDiscount =
                    Math.max(
                        0,
                        Math.min(100, discount)
                    );


                // Discount amount
                const discountAmount =
                    (mrp * validDiscount) / 100;


                // Selling price
                const sellingPrice =
                    Math.round(mrp - discountAmount);


                // Update price
                priceInput.value =
                    sellingPrice.toFixed(2);


                // Update summary
                if (discountSummary) {
                    discountSummary.textContent =
                        validDiscount.toFixed(2) + '%';
                }

                // Auto calculate Price / Box = Selling Price * Coverage / Box
                if (coverageInput && pricePerBoxInput) {
                    const coverage = parseFloat(coverageInput.value) || 0;
                    if (coverage > 0) {
                        const pricePerBox = Math.round(sellingPrice * coverage);
                        pricePerBoxInput.value = pricePerBox;
                    }
                }

            }


            mrpInput.addEventListener(
                'input',
                calculateSellingPrice
            );


            discountInput.addEventListener(
                'input',
                calculateSellingPrice
            );

            if (coverageInput) {
                coverageInput.addEventListener(
                    'input',
                    calculateSellingPrice
                );
            }


            // Initial calculation
            calculateSellingPrice();

        });

    </script>

</x-admin-layout>