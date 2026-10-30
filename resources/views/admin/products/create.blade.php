<x-admin-layout>
    <x-slot name="title">Add Product - Admin</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">

            {{-- Header --}}
            <div class="border-b pb-4">
                <h1 class="text-2xl font-black text-slate-900">
                    Add New Product
                </h1>

                <p class="text-slate-500 text-sm">
                    Add product with specifications, pricing, multiple images and optional color variants.
                </p>
            </div>

            <form
                action="{{ route('admin.products.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-6"
            >

                @csrf

                {{-- ========================================================= --}}
                {{-- BASIC INFORMATION --}}
                {{-- ========================================================= --}}

                <div>
                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">
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
                                value="{{ old('name') }}"
                                required
                                placeholder="e.g. Emesa White"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                            @error('name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- SKU --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                SKU / Product Code *
                            </label>

                            <input
                                type="text"
                                name="sku"
                                value="{{ old('sku') }}"
                                required
                                placeholder="e.g. EMESA-1200W"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                            @error('sku')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>


                {{-- ========================================================= --}}
                {{-- CLASSIFICATION --}}
                {{-- ========================================================= --}}

                <div class="border-t pt-4">

                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">
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
                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}
                                    >
                                        {{ $cat->name }}
                                    </option>
                                @endforeach

                            </select>

                            @error('category_id')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
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
                                    -- Select Category First --
                                </option>

                            </select>

                        </div>


                        {{-- Room --}}
                        <!--<div>-->

                        <!--    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">-->
                        <!--        Room Space *-->
                        <!--    </label>-->

                        <!--    <select-->
                        <!--        name="room_id"-->
                        <!--        required-->
                        <!--        class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"-->
                        <!--    >-->

                        <!--        <option value="">-->
                        <!--            -- Select ---->
                        <!--        </option>-->

                        <!--        @foreach($rooms as $room)-->

                        <!--            <option-->
                        <!--                value="{{ $room->id }}"-->
                        <!--                {{ old('room_id') == $room->id ? 'selected' : '' }}-->
                        <!--            >-->
                        <!--                {{ $room->name }}-->
                        <!--            </option>-->

                        <!--        @endforeach-->

                        <!--    </select>-->

                        <!--</div>-->
                        
<div>
    <label class="block text-sm font-medium text-slate-700 mb-2">
        Rooms
    </label>

    <div class="relative" id="roomDropdown">

        <!-- Dropdown Button -->
        <button
            type="button"
            onclick="toggleRoomDropdown()"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-white text-left flex items-center justify-between"
        >
            <span id="roomSelectedText" class="text-slate-600">
                Select Rooms
            </span>

            <svg
                class="w-5 h-5 text-slate-500"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 9l-7 7-7-7"
                />
            </svg>
        </button>


        <!-- Dropdown -->
        <div
            id="roomDropdownMenu"
            class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-y-auto"
        >

            @foreach($rooms as $room)

                <label
                    class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 cursor-pointer"
                >

                    <input
                        type="checkbox"
                        name="room_ids[]"
                        value="{{ $room->id }}"
                        class="room-checkbox w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                        onchange="updateRoomText()"
                        {{ in_array($room->id, old('room_ids', [])) ? 'checked' : '' }}
                    >

                    <span class="text-sm text-slate-700">
                        {{ $room->name }}
                    </span>

                </label>

            @endforeach

        </div>
    </div>


    <p class="text-xs text-slate-500 mt-2">
        Multiple rooms select kar sakte hain.
    </p>


    @error('room_ids')
        <p class="text-red-500 text-sm mt-1">
            {{ $message }}
        </p>
    @enderror

    @error('room_ids.*')
        <p class="text-red-500 text-sm mt-1">
            {{ $message }}
        </p>
    @enderror
</div>


<!-- Related Products -->
<div>
    <label class="block text-sm font-medium text-slate-700 mb-2 mt-4">
        Related Products
    </label>

    <div class="relative" id="relatedProductDropdown">
        <button
            type="button"
            onclick="toggleRelatedProductDropdown()"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-white text-left flex items-center justify-between"
        >
            <span id="relatedProductSelectedText" class="text-slate-600 truncate max-w-[90%]">
                Select Related Products
            </span>
            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <div id="relatedProductDropdownMenu" class="hidden absolute z-50 mt-2 w-full bg-white border border-slate-200 rounded-xl shadow-lg max-h-60 overflow-y-auto">
            @foreach($allProducts as $p)
                <label class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 cursor-pointer border-b border-slate-100 last:border-0">
                    <input
                        type="checkbox"
                        name="related_product_ids[]"
                        value="{{ $p->id }}"
                        class="related-product-checkbox w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                        onchange="updateRelatedProductText()"
                        {{ in_array($p->id, old('related_product_ids', [])) ? 'checked' : '' }}
                    >
                    <span class="text-sm text-slate-700 truncate">
                        {{ $p->name }} <span class="text-xs text-slate-400">({{ $p->sku }})</span>
                    </span>
                </label>
            @endforeach
        </div>
    </div>
</div>

<script>
    function toggleRelatedProductDropdown() {
        const menu = document.getElementById('relatedProductDropdownMenu');
        menu.classList.toggle('hidden');
    }

    function updateRelatedProductText() {
        const checked = document.querySelectorAll('.related-product-checkbox:checked');
        const textElement = document.getElementById('relatedProductSelectedText');
        
        if (checked.length === 0) {
            textElement.textContent = 'Select Related Products';
            textElement.classList.replace('text-indigo-700', 'text-slate-600');
            textElement.classList.replace('font-bold', 'font-normal');
        } else {
            textElement.textContent = `${checked.length} selected`;
            textElement.classList.replace('text-slate-600', 'text-indigo-700');
            textElement.classList.replace('font-normal', 'font-bold');
        }
    }
    
    document.addEventListener('click', function(event) {
        const rpDropdown = document.getElementById('relatedProductDropdown');
        const rpMenu = document.getElementById('relatedProductDropdownMenu');
        if (rpDropdown && rpMenu && !rpDropdown.contains(event.target)) {
            rpMenu.classList.add('hidden');
        }
        
        const roomDropdown = document.getElementById('roomDropdown');
        const roomMenu = document.getElementById('roomDropdownMenu');
        if (roomDropdown && roomMenu && !roomDropdown.contains(event.target)) {
            roomMenu.classList.add('hidden');
        }
    });
    function toggleRoomDropdown() {
        const menu = document.getElementById('roomDropdownMenu');

        menu.classList.toggle('hidden');
    }


    function updateRoomText() {

        const checked = document.querySelectorAll(
            '.room-checkbox:checked'
        );

        const text = document.getElementById('roomSelectedText');

        if (checked.length === 0) {

            text.textContent = 'Select Rooms';

        } else {

            const names = Array.from(checked).map(function (checkbox) {

                return checkbox
                    .closest('label')
                    .querySelector('span')
                    .textContent
                    .trim();

            });

            text.textContent = names.join(', ');
        }
    }


    // Initial selected values
    document.addEventListener('DOMContentLoaded', function () {
        updateRoomText();
    });


    // Dropdown ke bahar click karne par close
    document.addEventListener('click', function (event) {

        const dropdown = document.getElementById('roomDropdown');
        const menu = document.getElementById('roomDropdownMenu');

        if (!dropdown.contains(event.target)) {
            menu.classList.add('hidden');
        }

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
                                        {{ old('brand_id') == $brand->id ? 'selected' : '' }}
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
                                        {{ old('collection') == $col ? 'selected' : '' }}
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
                                        {{ old('material') == $mat ? 'selected' : '' }}
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
                                        {{ old('finish') == $fin ? 'selected' : '' }}
                                    >
                                        {{ $fin }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- TOILET / PRODUCT TYPE DETAILS --}}
                {{-- ========================================================= --}}

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Model --}}
                    <div>

                        <label class="block text-sm font-medium">
                            Model / Article No.
                        </label>

                        <input
                            type="text"
                            name="model_article_no"
                            value="{{ old('model_article_no') }}"
                            class="w-full border rounded-lg p-2"
                            placeholder="Enter Model / Article No."
                        >

                    </div>


                    {{-- Product Type --}}
                    <div>

                        <label class="block text-sm font-medium">
                            Product Type
                        </label>

                        <input
                            type="text"
                            name="product_type"
                            value="{{ old('product_type') }}"
                            class="w-full border rounded-lg p-2"
                            placeholder="Western WC / EWC"
                        >

                    </div>


                    {{-- Trap --}}
                    <div>

                        <label class="block text-sm font-medium">
                            Trap Type
                        </label>

                        <input
                            type="text"
                            name="trap_type"
                            value="{{ old('trap_type') }}"
                            class="w-full border rounded-lg p-2"
                            placeholder="S-Trap / P-Trap"
                        >

                    </div>


                    {{-- Outlet --}}
                    <div>

                        <label class="block text-sm font-medium">
                            Outlet Type
                        </label>

                        <input
                            type="text"
                            name="outlet_type"
                            value="{{ old('outlet_type') }}"
                            class="w-full border rounded-lg p-2"
                            placeholder="Horizontal / Vertical"
                        >

                    </div>


                    {{-- Flush --}}
                    <div>

                        <label class="block text-sm font-medium">
                            Flush Type
                        </label>

                        <input
                            type="text"
                            name="flush_type"
                            value="{{ old('flush_type') }}"
                            class="w-full border rounded-lg p-2"
                            placeholder="Single Flush / Dual Flush"
                        >

                    </div>


                    {{-- Mounting --}}
                    <div>

                        <label class="block text-sm font-medium">
                            Mounting Type
                        </label>

                        <input
                            type="text"
                            name="mounting_type"
                            value="{{ old('mounting_type') }}"
                            class="w-full border rounded-lg p-2"
                            placeholder="Floor Mounted / Wall Hung"
                        >

                    </div>


                    {{-- Seat Cover --}}
                    <div>

                        <label class="block text-sm font-medium">
                            Seat Cover
                        </label>

                        <input
                            type="text"
                            name="seat_cover"
                            value="{{ old('seat_cover') }}"
                            class="w-full border rounded-lg p-2"
                            placeholder="Included / Optional"
                        >

                    </div>
                    
                    <div>
    <label class="block text-sm font-medium text-slate-700 mb-2">
        Flushing System
    </label>
    <input 
        type="text" 
        name="flushing_system" 
        value="{{ old('flushing_system') }}" 
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
        value="{{ old('installation') }}" 
        placeholder="e.g. Floor Mounted / Wall Mounted"
        class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-indigo-500 focus:ring-indigo-500"
    >
</div>


                    {{-- Flush Tank --}}
                    <div>

                        <label class="block text-sm font-medium">
                            Flush Tank
                        </label>

                        <input
                            type="text"
                            name="flush_tank"
                            value="{{ old('flush_tank') }}"
                            class="w-full border rounded-lg p-2"
                            placeholder="Included / Optional"
                        >

                    </div>


                    {{-- Availability --}}
                    <div>

                        <label class="block text-sm font-medium">
                            Availability
                        </label>

                        <input
                            type="text"
                            name="availability"
                            value="{{ old('availability') }}"
                            class="w-full border rounded-lg p-2"
                            placeholder="In Stock / Out of Stock"
                        >

                    </div>


                    {{-- Weight --}}
                    <div>

                        <label class="block text-sm font-medium">
                            Weight (kg)
                        </label>

                        <input
                            type="number"
                            step="0.01"
                            name="weight"
                            value="{{ old('weight') }}"
                            class="w-full border rounded-lg p-2"
                            placeholder="Enter Weight"
                        >

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- DIMENSIONS --}}
                {{-- ========================================================= --}}

                <div class="border-t pt-4">

                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">
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
                                value="{{ old('width_mm', 600) }}"
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
                                value="{{ old('height_mm', 1200) }}"
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
                                value="{{ old('size', '600x1200mm') }}"
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
                                value="{{ old('size_inch', '24x48') }}"
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
                                value="{{ old('thickness', '9MM') }}"
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
                                        {{ old('pattern_type') == $pt ? 'selected' : '' }}
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
                                        {{ old('edge_type') == $et ? 'selected' : '' }}
                                    >
                                        {{ $et }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">

                        {{-- Area --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Area / Tile (sq.ft)
                            </label>

                            <input
                                type="number"
                                name="area_tile_sqft"
                                step="0.01"
                                value="{{ old('area_tile_sqft', 8) }}"
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
                                value="{{ old('coverage_area') }}"
                                placeholder="e.g. 1.44 sq.m / box"
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
                                value="{{ old('water_absorption') }}"
                                placeholder="e.g. < 0.5%"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Application --}}
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

                <label class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 cursor-pointer">

                    <input
                        type="checkbox"
                        name="application_area[]"
                        value="{{ $aa }}"
                        class="application-area-checkbox w-4 h-4"
                        {{ in_array($aa, old('application_area', [])) ? 'checked' : '' }}
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


    updateApplicationText();

});

</script>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- PACKAGING & PRICING --}}
                {{-- ========================================================= --}}

                <div class="border-t pt-4">

                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">
                        Packaging & Pricing
                    </span>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                        {{-- Pieces --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Pieces per Box
                            </label>

                            <input
                                type="number"
                                name="pieces_per_box"
                                value="{{ old('pieces_per_box', 2) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Coverage / Box --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Coverage / Box (sq.ft)
                            </label>

                            <input
                                type="number"
                                name="coverage_per_box_sqft"
                                id="coverage_per_box_sqft"
                                step="0.01"
                                value="{{ old('coverage_per_box_sqft', 16) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Weight / Box --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Weight / Box (kg)
                            </label>

                            <input
                                type="number"
                                name="weight_per_box_kg"
                                step="0.01"
                                value="{{ old('weight_per_box_kg', 30) }}"
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
                                value="{{ old('gst_percent', 18) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>

                    </div>


                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">

                        {{-- Price / Box --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Price / Box (₹) *
                            </label>

                            <input
                                type="number"
                                name="price_per_box"
                                id="price_per_box"
                                step="0.01"
                                value="{{ old('price_per_box', 880) }}"
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
                                value="{{ old('wholesale_price') }}"
                                placeholder="Trade price"
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
                                value="{{ old('stock', 250) }}"
                                required
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- MRP --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                MRP (₹) *
                            </label>

                            <input
                                type="number"
                                name="mrp"
                                id="mrp"
                                step="0.01"
                                value="{{ old('mrp', 880) }}"
                                required
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

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
                                value="{{ old('discount', 0) }}"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>


                        {{-- Selling Price --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Selling Price (₹) / Sq.ft *
                            </label>

                            <input
                                type="number"
                                name="price"
                                id="price"
                                step="0.01"
                                value="{{ old('price', 880) }}"
                                readonly
                                required
                                class="w-full bg-slate-100 border-slate-300 rounded-xl text-sm p-3"
                            >

                        </div>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- ADDITIONAL DETAILS --}}
                {{-- ========================================================= --}}

                <div class="border-t pt-4">

                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">
                        Additional Details
                    </span>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                        {{-- Warranty --}}
                        <div>

                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">
                                Warranty
                            </label>

                            <input
                                type="text"
                                name="warranty"
                                value="{{ old('warranty') }}"
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
                                value="{{ old('delivery_time') }}"
                                placeholder="e.g. 3-5 Business Days"
                                class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                            >

                        </div>

                    </div>


                    {{-- ===================================================== --}}
                    {{-- PRODUCT IMAGES + OPTIONAL COLORS --}}
                    {{-- ===================================================== --}}

                    <div class="mt-6">

                        <label class="block text-sm font-semibold text-slate-700 mb-2">
                            Product Images
                        </label>

                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4 mb-4">

                            <div class="flex items-start gap-3">

                                <div class="text-xl">
                                    🖼️
                                </div>

                                <div>

                                    <p class="text-sm font-semibold text-slate-800">
                                        Color-wise images are optional
                                    </p>

                                    <p class="text-xs text-slate-500 mt-1">
                                        Agar product ke different colors hain to har image ke saath color select karein.
                                        Agar product normal hai, to <strong>No Color / General</strong> select karein.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- IMAGE ROWS --}}
                        <div id="image-upload-list" class="space-y-3">

                            {{-- First Image --}}
                            <div class="image-upload-row bg-white border border-slate-200 rounded-xl p-3">

                                <div class="flex flex-col md:flex-row gap-3 items-start">

                                    {{-- Image --}}
                                    <div class="flex-1 w-full">

                                        <label class="block text-xs font-bold text-slate-500 mb-1">
                                            Product Image
                                        </label>

                                        <input
                                            type="file"
                                            name="images[]"
                                            accept="image/*"
                                            required
                                            class="block w-full text-sm text-slate-600
                                                   file:mr-4 file:py-2 file:px-4
                                                   file:rounded-lg file:border-0
                                                   file:bg-slate-100 file:text-slate-700
                                                   hover:file:bg-slate-200"
                                        >

                                    </div>


                                    {{-- Color --}}
                                    <div class="w-full md:w-52">

                                        <label class="block text-xs font-bold text-slate-500 mb-1">
                                            Image Color
                                        </label>

                                        <select
                                            name="colors[]"
                                            class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm"
                                        >

                                            <option value="">
                                                No Color / General
                                            </option>

                                            @foreach($colors as $color)

                                                <option value="{{ $color->value }}">
                                                    {{ $color->value }}
                                                </option>

                                            @endforeach

                                        </select>

                                    </div>


                                    {{-- Remove --}}
                                    <div class="pt-0 md:pt-5">

                                        <button
                                            type="button"
                                            onclick="removeImageRow(this)"
                                            class="px-3 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold"
                                        >
                                            Remove
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Add Image --}}
                        <button
                            type="button"
                            onclick="addImageRow()"
                            class="mt-3 px-4 py-2.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition"
                        >
                            + Add Another Image
                        </button>


                        <p class="text-xs text-slate-400 mt-2">
                            Maximum 2MB per image. Color select karna optional hai.
                        </p>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- VISIBILITY --}}
                {{-- ========================================================= --}}

                <div class="border-t pt-4">

                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">
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
                                {{ old('is_featured') ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500"
                            >

                            <span class="text-sm font-semibold text-slate-700">
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
                                {{ old('is_trending') ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500"
                            >

                            <span class="text-sm font-semibold text-slate-700">
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
                                {{ old('is_new') !== null ? (old('is_new') ? 'checked' : '') : 'checked' }}
                                class="w-5 h-5 rounded border-slate-300 text-teal-600 focus:ring-teal-500"
                            >

                            <span class="text-sm font-semibold text-slate-700">
                                🆕 New Arrival
                            </span>

                        </label>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- SEO & DESCRIPTION --}}
                {{-- ========================================================= --}}

                <div class="border-t pt-4">

                    <span class="block text-[10px] font-black text-teal-600 uppercase tracking-wider mb-3">
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
                                value="{{ old('seo_meta_title') }}"
                                placeholder="Complete Your Space..."
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
                                value="{{ old('seo_meta_description') }}"
                                placeholder="Now available..."
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
                            value="{{ old('short_description') }}"
                            placeholder="Short intro copy..."
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
                            rows="3"
                            placeholder="Full product description..."
                            class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"
                        >{{ old('description') }}</textarea>

                    </div>

                </div>


                {{-- ========================================================= --}}
                {{-- SUBMIT --}}
                {{-- ========================================================= --}}

                <div class="pt-4 flex gap-4 border-t">

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
                        Save Product
                    </button>

                </div>

            </form>

        </div>
    </div>


    {{-- ============================================================= --}}
    {{-- PRICE CALCULATION --}}
    {{-- ============================================================= --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const mrpInput = document.getElementById('mrp');
            const discountInput = document.getElementById('discount');
            const priceInput = document.getElementById('price');
            const coverageInput = document.getElementById('coverage_per_box_sqft');
            const pricePerBoxInput = document.getElementById('price_per_box');

            function calculateSellingPrice() {

                if (!mrpInput || !discountInput || !priceInput) {
                    return;
                }

                const mrp = parseFloat(mrpInput.value) || 0;

                const discount = parseFloat(discountInput.value) || 0;

                const discountAmount = (mrp * discount) / 100;

                const sellingPrice = Math.round(mrp - discountAmount);

                priceInput.value = sellingPrice.toFixed(2);

                if (coverageInput && pricePerBoxInput) {
                    const coverage = parseFloat(coverageInput.value) || 0;
                    if (coverage > 0) {
                        const pricePerBox = Math.round(sellingPrice * coverage);
                        pricePerBoxInput.value = pricePerBox;
                    }
                }
            }

            mrpInput.addEventListener('input', calculateSellingPrice);

            discountInput.addEventListener('input', calculateSellingPrice);

            if (coverageInput) {
                coverageInput.addEventListener('input', calculateSellingPrice);
            }

            calculateSellingPrice();

        });

    </script>


    {{-- ============================================================= --}}
    {{-- IMAGE UPLOAD JAVASCRIPT --}}
    {{-- ============================================================= --}}

    <script>

        function addImageRow() {

            const container = document.getElementById('image-upload-list');

            const row = document.createElement('div');

            row.className =
                'image-upload-row bg-white border border-slate-200 rounded-xl p-3';

            row.innerHTML = `
                <div class="flex flex-col md:flex-row gap-3 items-start">

                    <div class="flex-1 w-full">

                        <label class="block text-xs font-bold text-slate-500 mb-1">
                            Product Image
                        </label>

                        <input
                            type="file"
                            name="images[]"
                            accept="image/*"
                            required
                            class="block w-full text-sm text-slate-600
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-lg file:border-0
                                   file:bg-slate-100 file:text-slate-700
                                   hover:file:bg-slate-200"
                        >

                    </div>


                    <div class="w-full md:w-52">

                        <label class="block text-xs font-bold text-slate-500 mb-1">
                            Image Color
                        </label>

                        <select
                            name="colors[]"
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm"
                        >

                            <option value="">
                                No Color / General
                            </option>

                            @foreach($colors as $color)

                                <option value="{{ $color->value }}">
                                    {{ $color->value }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="pt-0 md:pt-5">

                        <button
                            type="button"
                            onclick="removeImageRow(this)"
                            class="px-3 py-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-sm font-semibold"
                        >
                            Remove
                        </button>

                    </div>

                </div>
            `;

            container.appendChild(row);
        }


        function removeImageRow(button) {

            const row = button.closest('.image-upload-row');

            if (!row) {
                return;
            }

            const container = document.getElementById('image-upload-list');

            // At least one row should remain
            if (container.querySelectorAll('.image-upload-row').length <= 1) {

                const fileInput = row.querySelector('input[type="file"]');

                const colorSelect = row.querySelector('select[name="colors[]"]');

                if (fileInput) {
                    fileInput.value = '';
                }

                if (colorSelect) {
                    colorSelect.value = '';
                }

                return;
            }

            row.remove();
        }

    </script>


    {{-- ============================================================= --}}
    {{-- CATEGORY → SUB CATEGORY --}}
    {{-- ============================================================= --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const subCategoriesData = @json($subCategories->groupBy('category_id'));

            const categorySelect =
                document.getElementById('category_id');

            const subCategorySelect =
                document.getElementById('sub_category');


            if (!categorySelect || !subCategorySelect) {
                return;
            }


            function loadSubCategories(catId) {

                subCategorySelect.innerHTML =
                    '<option value="">-- Select Sub Category --</option>';


                if (
                    catId &&
                    subCategoriesData[catId]
                ) {

                    subCategoriesData[catId].forEach(function (sub) {

                        const opt =
                            document.createElement('option');

                        opt.value = sub.name;

                        opt.textContent = sub.name;

                        subCategorySelect.appendChild(opt);

                    });

                }

            }


            categorySelect.addEventListener(
                'change',
                function () {

                    loadSubCategories(this.value);

                }
            );


            // Load old value after validation error
            const oldSubCategory =
                @json(old('sub_category'));


            if (categorySelect.value) {

                loadSubCategories(categorySelect.value);

                if (oldSubCategory) {

                    subCategorySelect.value =
                        oldSubCategory;

                }

            }

        });

    </script>

</x-admin-layout>