
<x-app-layout>
    <x-slot name="title">Browse Tiles & Sanitary - BuildMart</x-slot>

    <!-- Header -->
    <div class="bg-slate-900 text-white py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <nav class="flex flex-wrap text-slate-400 text-[10px] sm:text-xs gap-1.5 items-center mb-3 sm:mb-4">
                <a href="/" class="hover:text-teal-400">Home</a>
                <span>/</span>

                @if(request('category'))
                    <a href="/products" class="hover:text-teal-400">Products</a>
                    <span>/</span>

                    <span class="text-slate-300">
                        {{ $selectedCategoryName ?? 'Category' }}
                    </span>

                    @if(request('subcategory'))
                        <span>/</span>

                        <span class="text-teal-300">
                            {{ $selectedSubCategoryName ?? 'Subcategory' }}
                        </span>
                    @endif
                @else
                    <span class="text-slate-300">All Products</span>
                @endif
            </nav>

            <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold tracking-tight">
                @if(request('subcategory') && isset($selectedSubCategoryName))
                    {{ $selectedSubCategoryName }}
                @elseif(request('category') && isset($selectedCategoryName))
                    {{ $selectedCategoryName }}
                @else
                    Our Catalog
                @endif
            </h1>

            <p class="text-slate-400 text-xs sm:text-sm mt-2 max-w-xl">
                Find premium tiles, sanitaryware, and bathware matching the mockups.
            </p>

        </div>
    </div>


    <!-- Main -->
    <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-6 sm:py-12">

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-10 items-start">


            <!-- FILTER -->
            <aside class="w-full lg:w-64 flex-shrink-0 bg-white border border-slate-200 rounded-2xl p-4 sm:p-6 shadow-sm lg:sticky lg:top-24">

                <form action="/products" method="GET" class="space-y-5 sm:space-y-6">

                    <!-- Search -->
                    <div class="relative">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search products..."
                            class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 focus:border-teal-500 focus:bg-white focus:ring-0 rounded-xl text-xs font-semibold"
                        >

                        <button
                            type="submit"
                            class="absolute left-3 top-2.5 text-slate-400 hover:text-teal-600"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>
                        </button>

                    </div>


                    <!-- Filter Header -->
                    <div class="flex items-center justify-between border-b pb-4">

                        <h3 class="font-extrabold text-slate-900 text-base">
                            Filters
                        </h3>

                        <a
                            href="/products"
                            class="text-xs font-bold text-teal-600 hover:text-teal-700"
                        >
                            Clear All
                        </a>

                    </div>


                    <!-- Category -->
                    <div>

                        <h4 class="font-bold text-slate-800 text-sm mb-3">
                            Category
                        </h4>

                        <div class="space-y-2 max-h-40 overflow-y-auto pr-1">

                            @foreach($categories as $cat)

                                <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-600 cursor-pointer">

                                    <input
                                        type="radio"
                                        name="category"
                                        value="{{ $cat->slug }}"
                                        {{ request('category') === $cat->slug ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="rounded border-slate-300 text-teal-600 focus:ring-0"
                                    >

                                    <span class="break-words">
                                        {{ $cat->name }}
                                    </span>

                                </label>

                            @endforeach

                        </div>

                    </div>


                    <!-- Sub Category -->
                 @if($subCategories->isNotEmpty())

                        <div>

                            <h4 class="font-bold text-slate-800 text-sm mb-3">
                                Sub Category
                            </h4>

                            <div class="space-y-2 max-h-40 overflow-y-auto pr-1">

                                @foreach($subCategories as $subcat)

                                    <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-600 cursor-pointer">

                                        <input
                                            type="radio"
                                            name="subcategory"
                                            value="{{ $subcat->slug }}"
                                            {{ request('subcategory') === $subcat->slug ? 'checked' : '' }}
                                            onchange="this.form.submit()"
                                            class="rounded border-slate-300 text-teal-600 focus:ring-0"
                                        >

                                        <span class="break-words">
                                            {{ $subcat->name }}
                                        </span>

                                    </label>

                                @endforeach

                            </div>

                        </div>

                    @endif 


                    <!-- Brand -->
                    <div>

                        <h4 class="font-bold text-slate-800 text-sm mb-3">
                            Brand
                        </h4>

                        <div class="space-y-2 max-h-40 overflow-y-auto pr-1">

                            @foreach($brands as $brand)

                                <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-600 cursor-pointer">

                                    <input
                                        type="radio"
                                        name="brand"
                                        value="{{ $brand->slug }}"
                                        {{ request('brand') === $brand->slug ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="rounded border-slate-300 text-teal-600 focus:ring-0"
                                    >

                                    <span class="break-words">
                                        {{ $brand->name }}
                                    </span>

                                </label>

                            @endforeach

                        </div>

                    </div>


                    <!-- Material -->
                    <!-- <div>

                        <h4 class="font-bold text-slate-800 text-sm mb-3">
                            Material
                        </h4>

                        <div class="space-y-2 max-h-40 overflow-y-auto pr-1">

                            @foreach($materials as $material)

                                <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-600 cursor-pointer">

                                    <input
                                        type="radio"
                                        name="material"
                                        value="{{ $material }}"
                                        {{ request('material') === $material ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="rounded border-slate-300 text-teal-600 focus:ring-0"
                                    >

                                    <span class="break-words">
                                        {{ $material }}
                                    </span>

                                </label>

                            @endforeach

                        </div>

                    </div> -->


                    <!-- Color -->
                    <!-- <div>

                        <h4 class="font-bold text-slate-800 text-sm mb-3">
                            Color
                        </h4>

                        <div class="space-y-2 max-h-40 overflow-y-auto pr-1">

                            @foreach($colors as $color)

                                <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-600 cursor-pointer">

                                    <input
                                        type="radio"
                                        name="color"
                                        value="{{ $color }}"
                                        {{ request('color') === $color ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="rounded border-slate-300 text-teal-600 focus:ring-0"
                                    >

                                    <span class="break-words">
                                        {{ $color }}
                                    </span>

                                </label>

                            @endforeach

                        </div>

                    </div> -->


                    <!-- Price -->
                    <div>

                        <h4 class="font-bold text-slate-800 text-sm mb-3">
                            Price Range
                        </h4>

                        <div class="space-y-2 text-xs font-semibold text-slate-600">

                            @foreach([
                                'under-1000' => 'Under ₹1000',
                                '1000-2500'   => '₹1000 - ₹2500',
                                '2500-5000'   => '₹2500 - ₹5000',
                                'above-5000' => 'Above ₹5000'
                            ] as $value => $label)

                                <label class="flex items-center gap-2 cursor-pointer">

                                    <input
                                        type="radio"
                                        name="price_range"
                                        value="{{ $value }}"
                                        {{ request('price_range') === $value ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="rounded-full border-slate-300 text-teal-600 focus:ring-0"
                                    >

                                    <span>{{ $label }}</span>

                                </label>

                            @endforeach

                        </div>

                    </div>


                    <!-- Size -->
                    <!-- <div>

                        <h4 class="font-bold text-slate-800 text-sm mb-3">
                            Size
                        </h4>

                        <div class="space-y-2 max-h-40 overflow-y-auto pr-1">

                            @foreach($sizes as $sizeVal)

                                <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-600 cursor-pointer">

                                    <input
                                        type="radio"
                                        name="size"
                                        value="{{ $sizeVal }}"
                                        {{ request('size') === $sizeVal ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="rounded border-slate-300 text-teal-600 focus:ring-0"
                                    >

                                    <span>{{ $sizeVal }}</span>

                                </label>

                            @endforeach

                        </div>

                    </div> -->


                    <!-- Finish -->
                    <!-- <div>

                        <h4 class="font-bold text-slate-800 text-sm mb-3">
                            Finish
                        </h4>

                        <div class="space-y-2 max-h-40 overflow-y-auto pr-1">

                            @foreach($finishes as $finishVal)

                                <label class="flex items-center gap-2.5 text-xs font-semibold text-slate-600 cursor-pointer">

                                    <input
                                        type="radio"
                                        name="finish"
                                        value="{{ $finishVal }}"
                                        {{ request('finish') === $finishVal ? 'checked' : '' }}
                                        onchange="this.form.submit()"
                                        class="rounded border-slate-300 text-teal-600 focus:ring-0"
                                    >

                                    <span>{{ $finishVal }}</span>

                                </label>

                            @endforeach

                        </div>

                    </div> -->


                    @if(request('sort'))

                        <input
                            type="hidden"
                            name="sort"
                            value="{{ request('sort') }}"
                        >

                    @endif

                </form>

            </aside>


            <!-- PRODUCTS -->
            <div class="flex-1 w-full min-w-0">


                <!-- SORT BAR -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 bg-white border border-slate-200 p-3 sm:p-4 rounded-2xl mb-5 sm:mb-8 shadow-sm">

                    <p class="text-slate-500 font-semibold text-xs sm:text-sm">

                        {{ request('search') ? 'Results for "' . request('search') . '"' : 'All Products' }}

                        <span class="text-slate-400 font-medium">
                            ({{ $products->total() }})
                        </span>

                    </p>


                    <div class="flex items-center justify-between sm:justify-end gap-2">

                        <label
                            for="sort"
                            class="text-slate-500 font-semibold text-xs flex-shrink-0"
                        >
                            Sort By:
                        </label>

                        <select
                            id="sort"
                            onchange="window.location.href = updateQueryStringParameter(window.location.href, 'sort', this.value)"
                            class="border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-xs py-2 px-3 w-full sm:w-40 bg-white"
                        >

                            <option value="default" {{ request('sort') == 'default' ? 'selected' : '' }}>
                                Popular
                            </option>

                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>
                                Top Rated
                            </option>

                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                Price: Low to High
                            </option>

                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                Price: High to Low
                            </option>

                        </select>

                    </div>

                </div>


                <!-- PRODUCTS -->
                @if($products->isEmpty())

                    <div class="bg-white border rounded-2xl p-10 sm:p-16 text-center max-w-xl mx-auto shadow-sm my-8">

                        <h3 class="text-xl font-bold text-slate-800 mb-2">
                            No Products Found
                        </h3>

                        <a
                            href="/products"
                            class="inline-block bg-teal-600 hover:bg-teal-700 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition mt-6"
                        >
                            View All Products
                        </a>

                    </div>

                @else

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">

                        @foreach($products as $product)

                            <div class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl transition duration-300 flex flex-col h-full overflow-hidden">


                                <!-- IMAGE -->
                                <a
                                    href="/products/{{ $product->slug }}"
                                    class="aspect-square bg-slate-50 relative block overflow-hidden p-3 sm:p-4"
                                >

                                    <img
                                        src="{{ asset($product->featured_image) }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-contain rounded-xl group-hover:scale-105 transition duration-500"
                                    >

                                </a>


                                <!-- DETAILS -->
                                <div class="p-4 sm:p-5 flex flex-col flex-grow min-w-0">


                                    <!-- NAME -->
                                    <a
                                        href="/products/{{ $product->slug }}"
                                        class="font-extrabold text-slate-800 hover:text-teal-600 text-sm line-clamp-2 mb-1 leading-snug"
                                    >
                                        {{ $product->name }}
                                    </a>


                                    <!-- SPECS -->
                                    <div class="flex flex-wrap items-center gap-x-1.5 gap-y-1 text-[10px] text-slate-400 font-semibold mb-2">

                                        <span>
                                            {{ $product->brand->name ?? 'Generic' }}
                                        </span>

                                        <span>&bull;</span>

                                        <span>
                                            {{ $product->size ?: '600x600mm' }}
                                        </span>

                                        <span>&bull;</span>

                                        <span>
                                            {{ $product->finish ?: 'Glossy' }}
                                        </span>

                                    </div>


                                    <!-- RATING -->
                                    <div class="flex items-center gap-0.5 text-amber-500 text-[10px] mb-3">

                                        @for($i = 1; $i <= 5; $i++)

                                            <svg
                                                class="w-3 h-3 {{ $i <= $product->rating ? 'fill-current' : 'text-slate-200' }}"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>

                                        @endfor

                                    </div>


                                    <!-- PRICE + ACTION -->
                                    <div class="mt-auto pt-3 sm:pt-4 border-t border-slate-100 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">


                                        @php
                                            $isTiles = (int) $product->category_id === 1;
                                        @endphp


                                        <!-- PRICE -->
                                        <div class="min-w-0">

                                            <div class="text-base sm:text-sm font-black text-slate-900 leading-none">

                                                ₹{{ number_format(round($product->price)) }}

                                                @if($isTiles)

                                                    <span class="text-[10px] sm:text-xs font-semibold text-slate-500">
                                                        / sq.ft
                                                    </span>

                                                @endif

                                            </div>


                                            @if($product->discount > 0)

                                                <div class="text-[10px] text-slate-400 line-through mt-1">

                                                    ₹{{ number_format(round($product->mrp)) }}

                                                    @if($isTiles)
                                                        / sq.ft
                                                    @endif

                                                </div>

                                                <div class="text-[10px] sm:text-xs font-bold text-emerald-600 mt-0.5">

                                                    Discount {{ number_format($product->discount, 0) }}%

                                                </div>

                                            @endif

                                        </div>


                                        <!-- BUTTON -->
                                        @if(auth()->check() && auth()->user()->isProfessional())

                                            <a
                                                href="/quotation-requests/create?product_id={{ $product->id }}"
                                                class="w-full sm:w-auto text-center bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition whitespace-nowrap"
                                            >
                                                Request Quote
                                            </a>

                                        @else

                                            <form
                                                action="/cart/add"
                                                method="POST"
                                                class="w-full sm:w-auto"
                                            >

                                                @csrf

                                                <input
                                                    type="hidden"
                                                    name="product_id"
                                                    value="{{ $product->id }}"
                                                >

                                                <input
                                                    type="hidden"
                                                    name="quantity"
                                                    value="1"
                                                >

                                                <button
                                                    type="submit"
                                                    class="w-full sm:w-auto bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-sm transition whitespace-nowrap"
                                                >
                                                    Add to Cart
                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    <!-- PAGINATION -->
                    <div class="mt-8 sm:mt-12 overflow-x-auto">

                        {{ $products->links() }}

                    </div>

                @endif

            </div>

        </div>

    </div>


    <script>

        function updateQueryStringParameter(uri, key, value) {

            var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");

            var separator = uri.indexOf('?') !== -1 ? "&" : "?";

            if (uri.match(re)) {

                return uri.replace(
                    re,
                    '$1' + key + "=" + value + '$2'
                );

            } else {

                return uri + separator + key + "=" + value;

            }

        }

    </script>

</x-app-layout>
