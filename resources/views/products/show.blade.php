
<x-app-layout>
    <x-slot name="title">{{ $product->name }} - BuildMart</x-slot>

    @php
        $isProfessional = auth()->check() && auth()->user()->isProfessional();
        $isTiles = (int) $product->category_id === 1;

        $retailPrice = (float) $product->price;
        $professionalPrice = (float) ($product->wholesale_price ?: $product->price);

        $displayPrice = $isProfessional
            ? $professionalPrice
            : $retailPrice;
    @endphp


    <!-- ========================================================= -->
    <!-- BREADCRUMB -->
    <!-- ========================================================= -->

    <div class="bg-[#f5f1eb] border-b border-[#ded7cd] py-3 text-[11px] uppercase tracking-wider text-[#736c63] font-bold">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <nav class="flex gap-2 items-center flex-wrap">

                <a href="/" class="hover:text-[#b58d56]">
                    Home
                </a>

                <span>&gt;</span>

                <a
                    href="/products?category={{ $product->category->slug ?? 'tiles' }}"
                    class="hover:text-[#b58d56]"
                >
                    {{ $product->category->name ?? 'Tiles' }}
                </a>

                <span>&gt;</span>

                <a
                    href="/products?room={{ $product->room->slug ?? 'general' }}"
                    class="hover:text-[#b58d56]"
                >
                    {{ $product->room->name ?? 'General' }} Tiles
                </a>

                <span>&gt;</span>

                <span class="text-[#2b2723]">
                    {{ $product->name }}
                </span>

            </nav>

        </div>

    </div>



    <!-- ========================================================= -->
    <!-- PRODUCT SHOWCASE -->
    <!-- ========================================================= -->

    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12"
        x-data="{
            quantity: 1,
            unitPrice: {{ $displayPrice }},
            
            // Tile Calculator State
            coveragePerBox: {{ $product->coverage_per_box_sqft ?: 1 }},
            piecesPerBox: {{ $product->pieces_per_box ?: 1 }},
            inputArea: '',
            unit: 'sqft', // sqft or sqm
            
            get calculatedAreaWithWastage() {
                let area = parseFloat(this.inputArea) || 0;
                let areaInSqft = this.unit === 'sqm' ? area * 10.7639 : area;
                return areaInSqft;
            },
            
            get calculatedBoxes() {
                if (this.calculatedAreaWithWastage <= 0) return 0;
                return Math.ceil(this.calculatedAreaWithWastage / this.coveragePerBox);
            },
            
            get totalCoverageSqft() {
                return this.calculatedBoxes * this.coveragePerBox;
            },
            
            updateQuantityFromCalculator() {
                if(this.calculatedBoxes > 0) {
                    this.quantity = this.totalCoverageSqft;
                }
            },

            get totalTax() {
                return this.quantity * this.unitPrice;
            }
        }"
    >

        <div
            class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start bg-white border border-[#ded7cd] rounded-2xl p-8 shadow-sm"
        >


            <!-- ================================================= -->
            <!-- LEFT SIDE - PRODUCT IMAGES -->
            <!-- ================================================= -->

            <div>

                <div
                    x-data="{
                        images: [
                            @foreach($product->images as $image)
                                {
                                    id: {{ $image->id }},
                                    url: @js(asset($image->image_path)),
                                    color: @js($image->color)
                                },
                            @endforeach
                        ],

                        activeImage: 0,

                        selectedColor: null,

                        init() {

                            /*
                            |--------------------------------------------------------------------------
                            | If any image has color
                            |--------------------------------------------------------------------------
                            */

                            if (this.isColorBased && this.colors.length > 0) {

                                this.selectedColor = this.colors[0];

                                const firstIndex = this.images.findIndex(
                                    image => image.color === this.selectedColor
                                );

                                if (firstIndex >= 0) {
                                    this.activeImage = firstIndex;
                                }

                            }

                        },


                        /*
                        |--------------------------------------------------------------------------
                        | Check Color Based Product
                        |--------------------------------------------------------------------------
                        */

                        get isColorBased() {

                            return this.images.some(
                                image => image.color && image.color.trim() !== ''
                            );

                        },


                        /*
                        |--------------------------------------------------------------------------
                        | Unique Colors
                        |--------------------------------------------------------------------------
                        */

                        get colors() {

                            return [
                                ...new Set(
                                    this.images
                                        .map(image => image.color)
                                        .filter(color => color && color.trim() !== '')
                                )
                            ];

                        },


                        /*
                        |--------------------------------------------------------------------------
                        | Filter Images By Color
                        |--------------------------------------------------------------------------
                        */

                        get filteredImages() {

                            if (!this.isColorBased || !this.selectedColor) {
                                return this.images;
                            }

                            return this.images.filter(
                                image => image.color === this.selectedColor
                            );

                        },


                        /*
                        |--------------------------------------------------------------------------
                        | Active Image
                        |--------------------------------------------------------------------------
                        */

                        get activeImageObject() {

                            return this.images[this.activeImage] || null;

                        },


                        /*
                        |--------------------------------------------------------------------------
                        | Select Color
                        |--------------------------------------------------------------------------
                        */

                        selectColor(color) {

                            this.selectedColor = color;

                            const index = this.images.findIndex(
                                image => image.color === color
                            );

                            if (index >= 0) {
                                this.activeImage = index;
                            }

                        },


                        /*
                        |--------------------------------------------------------------------------
                        | Select Thumbnail
                        |--------------------------------------------------------------------------
                        */

                        selectImage(image) {

                            const index = this.images.findIndex(
                                item => item.id === image.id
                            );

                            if (index >= 0) {

                                this.activeImage = index;

                                /*
                                | If color based product,
                                | keep selected color in sync
                                */

                                if (
                                    this.isColorBased &&
                                    image.color
                                ) {
                                    this.selectedColor = image.color;
                                }

                            }

                        },


                        /*
                        |--------------------------------------------------------------------------
                        | Active Thumbnail
                        |--------------------------------------------------------------------------
                        */

                        isActive(image) {

                            return this.activeImageObject &&
                                   this.activeImageObject.id === image.id;

                        }

                    }"
                >


                    <!-- ========================================= -->
                    <!-- MAIN PRODUCT IMAGE -->
                    <!-- ========================================= -->
                    
                    <!-- ========================================= -->
<!-- MAIN PRODUCT IMAGE - HOVER ZOOM -->
<!-- ========================================= -->

<div
    class="bg-[#f5f1eb] rounded-2xl border aspect-square relative overflow-hidden group cursor-zoom-in"
    x-data="{
        zoom: false,
        originX: 50,
        originY: 50,

                moveImage(event) {
            const rect = event.currentTarget.getBoundingClientRect();
            
            // Handle both mouse and touch events
            let clientX = event.clientX;
            let clientY = event.clientY;
            
            if (event.touches && event.touches.length > 0) {
                clientX = event.touches[0].clientX;
                clientY = event.touches[0].clientY;
            }

            this.originX = ((clientX - rect.left) / rect.width) * 100;
            this.originY = ((clientY - rect.top) / rect.height) * 100;
        },

        resetZoom() {
            this.zoom = false;
            this.originX = 50;
            this.originY = 50;
        }
    }"
        @mouseenter="zoom = true"
    @mousemove="moveImage($event)"
    @mouseleave="resetZoom()"
    @touchstart="zoom = true; moveImage($event)"
    @touchmove="moveImage($event)"
    @touchend="resetZoom()"
>

    @if($product->images->count() > 0)

        <template x-if="activeImageObject">

            <div class="w-full h-full flex items-center justify-center overflow-hidden">

                <img
                    :src="activeImageObject.url"
                    alt="{{ $product->name }}"

                    class="max-h-full max-w-full object-contain rounded-xl select-none pointer-events-none"

                    :style="`
                        transform: scale(${zoom ? 1.8 : 1});
                        transform-origin: ${originX}% ${originY}%;
                        transition: transform 0.25s ease-out;
                    `"
                >

            </div>

        </template>

    @else

        <div class="w-full h-full flex items-center justify-center overflow-hidden">

            <img
                src="{{ asset('images/products/product1a.svg') }}"
                alt="{{ $product->name }}"

                class="max-h-full max-w-full object-contain rounded-xl select-none pointer-events-none"

                :style="`
                    transform: scale(${zoom ? 1.8 : 1});
                    transform-origin: ${originX}% ${originY}%;
                    transition: transform 0.25s ease-out;
                `"
            >

        </div>

    @endif


    <!-- Zoom Icon -->

    <div
        class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm
               border border-[#ded7cd] rounded-full w-10 h-10
               flex items-center justify-center shadow-md
               opacity-0 group-hover:opacity-100
               transition-opacity duration-300 pointer-events-none"
    >

        <svg
            class="w-5 h-5 text-[#2b2723]"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <circle
                cx="11"
                cy="11"
                r="7"
                stroke-width="2"
            ></circle>

            <path
                d="M20 20L16 16"
                stroke-width="2"
                stroke-linecap="round"
            ></path>

            <path
                d="M11 8V14M8 11H14"
                stroke-width="2"
                stroke-linecap="round"
            ></path>
        </svg>

    </div>


    <!-- Small Hint -->

    <div
        class="absolute bottom-4 left-4
               bg-black/60 text-white text-[10px]
               px-3 py-1.5 rounded-full
               opacity-0 group-hover:opacity-100
               transition-opacity duration-300
               pointer-events-none"
    >
        Move cursor to zoom
    </div>

</div>



                   

                    <!-- ========================================= -->
                    <!-- COLOR SELECTOR -->
                    <!-- ONLY COLOR PRODUCTS -->
                    
                    
                    <!-- ========================================= -->

                    <div
                        class="mt-5"
                        x-show="isColorBased && colors.length > 0"
                        x-cloak
                    >

                        <div class="flex items-center justify-between mb-3">

                            <div>

                                <p class="text-xs font-bold text-[#736c63] uppercase tracking-wide">
                                    Available Colors
                                </p>

                                <p
                                    class="text-sm font-black text-[#171615] mt-1"
                                    x-text="selectedColor || 'Select Color'"
                                ></p>

                            </div>

                        </div>


                        <div class="flex flex-wrap gap-2">

                            <template
                                x-for="color in colors"
                                :key="color"
                            >

                                <button
                                    type="button"
                                    @click="selectColor(color)"
                                    class="px-4 py-2 rounded-xl border text-xs font-bold transition-all duration-200"
                                    :class="selectedColor === color
                                        ? 'border-[#b58d56] bg-[#eae3d8] text-[#b58d56] ring-2 ring-[#b58d56]/20'
                                        : 'border-[#ded7cd] bg-white text-[#615a52] hover:border-[#b58d56]'"
                                >

                                    <span x-text="color"></span>

                                </button>

                            </template>

                        </div>

                    </div>



                    <!-- ========================================= -->
                    <!-- IMAGE THUMBNAILS -->
                    <!-- ========================================= -->

                    <div
                        class="mt-4 grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 gap-3"
                        x-show="filteredImages.length > 1"
                        x-cloak
                    >

                        <template
                            x-for="image in filteredImages"
                            :key="image.id"
                        >

                            <button
                                type="button"
                                @click="selectImage(image)"
                                class="relative bg-[#f5f1eb] border rounded-xl p-2 aspect-square overflow-hidden transition-all duration-200"
                                :class="isActive(image)
                                    ? 'border-[#b58d56] ring-2 ring-[#b58d56]/40'
                                    : 'border-[#ded7cd] hover:border-[#b58d56]'"
                            >

                                <img
                                    :src="image.url"
                                    alt="{{ $product->name }}"
                                    class="w-full h-full object-contain rounded-lg"
                                >


                                <!-- Active Overlay -->

                                <span
                                    x-show="isActive(image)"
                                    class="absolute inset-0 bg-[#b58d56]/10 pointer-events-none rounded-xl"
                                ></span>

                            </button>

                        </template>

                    </div>



                    <!-- ========================================= -->
                    <!-- NORMAL PRODUCT INFO -->
                    <!-- ========================================= -->

                    <div
                        class="mt-3"
                        x-show="!isColorBased && images.length > 1"
                        x-cloak
                    >

                        <p class="text-[10px] text-[#a39e97] font-medium">
                            Multiple product images available
                        </p>

                    </div>



                    <!-- ========================================= -->
                    <!-- COLOR PRODUCT INFO -->
                    <!-- ========================================= -->

                    <div
                        class="mt-3"
                        x-show="isColorBased && colors.length > 0"
                        x-cloak
                    >

                        <p class="text-[10px] text-[#a39e97] font-medium">
                            Select a color to view its images.
                        </p>

                    </div>

                </div>

            </div>



            <!-- ================================================= -->
            <!-- RIGHT SIDE - PRODUCT DETAILS -->
            <!-- ================================================= -->

            <div class="space-y-6">


                <!-- ============================================= -->
                <!-- TITLE + BRAND -->
                <!-- ============================================= -->

                <div>

                    <div class="flex justify-between items-center mb-1 gap-4">

                        <h1 class="font-serif-pristo text-3xl md:text-4xl font-bold text-[#171615]">
                            {{ $product->name }}
                        </h1>

                        <span class="text-[#b58d56] font-bold text-sm tracking-wide uppercase whitespace-nowrap">

                            {{ $product->brand->name ?? 'Premium' }}

                        </span>

                    </div>
                    
                    <div class="flex items-center gap-2 mt-2">
                        <form action="{{ route('compare.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="text-xs font-bold text-[#736c63] hover:text-[#b58d56] flex items-center gap-1 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                Add to Compare
                            </button>
                        </form>
                    </div>

                </div>



                <!-- ============================================= -->
                <!-- SPECS -->
                <!-- ============================================= -->

                <div
                    class="grid grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-6 border-y py-4 text-xs font-semibold text-[#736c63]"
                >
                    
                        @if($product->sku)
        <div>
            <span class="block text-[#a39e97] font-medium"> Product Code</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->sku }}
            </span>
        </div>
    @endif
    
                    
                      @if($product->category->name)
        <div>
            <span class="block text-[#a39e97] font-medium"> Category</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->category->name }}
            </span>
        </div>
    @endif
    
    
    @if($product->sub_category)
        <div>
            <span class="block text-[#a39e97] font-medium">Sub Category</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->sub_category }}
            </span>
        </div>
    @endif
    
   @if($product->rooms)
    <div>
        <span class="block text-[#a39e97] font-medium">Room</span>
        <span class="text-[#2b2723] font-bold">
        {{ $product->rooms->pluck('name')->join(', ') }}
        </span>
    </div>
@endif
    
    
    @if($product->brand)
        <div>
            <span class="block text-[#a39e97] font-medium">Brand</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->brand->name }}
            </span>
        </div>
    @endif
    
    @if(!empty($product->application_area))
    <div>
        <span class="block text-[#a39e97] font-medium">
            Application Area
        </span>

        <span class="text-[#2b2723] font-bold">
            @php
                $applicationAreas = is_array($product->application_area)
                    ? $product->application_area
                    : (json_decode($product->application_area, true) ?? [$product->application_area]);
            @endphp

            {{ implode(', ', $applicationAreas) }}
        </span>
    </div>
@endif
    
      @if($product->Collection)
        <div>
            <span class="block text-[#a39e97] font-medium">Collection</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->Collection }}
            </span>
        </div>
    @endif
    
    
    @if($product->material)
        <div>
            <span class="block text-[#a39e97] font-medium">Material</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->material }}
            </span>
        </div>
    @endif
    
    
   

    @if($product->size)
        <div>
            <span class="block text-[#a39e97] font-medium">Size</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->size }}
                @if($product->size_inch)
                    ({{ $product->size_inch }})
                @endif
            </span>
        </div>
    @endif

    @if($product->collection)
        <div>
            <span class="block text-[#a39e97] font-medium">Collection</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->collection }}
            </span>
        </div>
    @endif

  

    @if($product->finish)
        <div>
            <span class="block text-[#a39e97] font-medium">Finish</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->finish }}
            </span>
        </div>
    @endif

    @if($product->thickness)
        <div>
            <span class="block text-[#a39e97] font-medium">Thickness</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->thickness }}
            </span>
        </div>
    @endif

    @if($product->area_tile_sqft)
        <div>
            <span class="block text-[#a39e97] font-medium">Area / Tile</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->area_tile_sqft }} sq.ft
            </span>
        </div>
    @endif

    @if($product->pieces_per_box)
        <div>
            <span class="block text-[#a39e97] font-medium">Pieces / Box</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->pieces_per_box }} pcs
            </span>
        </div>
    @endif

    @if($product->coverage_per_box_sqft)
        <div>
            <span class="block text-[#a39e97] font-medium">Coverage / Box</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->coverage_per_box_sqft }} sq.ft
            </span>
        </div>
    @endif

    @if($product->weight_per_box_kg)
        <div>
            <span class="block text-[#a39e97] font-medium">Weight / Box</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->weight_per_box_kg }} kg
            </span>
        </div>
    @endif

    @if($product->price_per_box)
        <div>
            <span class="block text-[#a39e97] font-medium">Price / Box</span>
            <span class="text-[#2b2723] font-bold">
                ₹{{ number_format($product->price_per_box, 2) }}
            </span>
        </div>
    @endif

    @if($product->edge_type)
        <div>
            <span class="block text-[#a39e97] font-medium">Edge Type</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->edge_type }}
            </span>
        </div>
    @endif

    @if($product->pattern_type)
        <div>
            <span class="block text-[#a39e97] font-medium">Pattern Type</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->pattern_type }}
            </span>
        </div>
    @endif

    @if($product->model_article_no)
        <div>
            <span class="block text-[#a39e97] font-medium">Model / Article No.</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->model_article_no }}
            </span>
        </div>
    @endif

    @if($product->product_type)
        <div>
            <span class="block text-[#a39e97] font-medium">Product Type</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->product_type }}
            </span>
        </div>
    @endif

    @if($product->trap_type)
        <div>
            <span class="block text-[#a39e97] font-medium">Trap Type</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->trap_type }}
            </span>
        </div>
    @endif

    @if($product->outlet_type)
        <div>
            <span class="block text-[#a39e97] font-medium">Outlet Type</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->outlet_type }}
            </span>
        </div>
    @endif

    @if($product->flush_type)
        <div>
            <span class="block text-[#a39e97] font-medium">Flush Type</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->flush_type }}
            </span>
        </div>
    @endif

    @if($product->mounting_type)
        <div>
            <span class="block text-[#a39e97] font-medium">Mounting Type</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->mounting_type }}
            </span>
        </div>
    @endif

    @if($product->seat_cover)
        <div>
            <span class="block text-[#a39e97] font-medium">Seat Cover</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->seat_cover }}
            </span>
        </div>
    @endif
    
      @if($product->installation)
        <div>
            <span class="block text-[#a39e97] font-medium">installation</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->installation }}
            </span>
        </div>
    @endif
    
      @if($product->flushing_system)
        <div>
            <span class="block text-[#a39e97] font-medium">flushing system</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->flushing_system }}
            </span>
        </div>
    @endif

    @if($product->flush_tank)
        <div>
            <span class="block text-[#a39e97] font-medium">Flush Tank</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->flush_tank }}
            </span>
        </div>
    @endif

    @if($product->availability)
        <div>
            <span class="block text-[#a39e97] font-medium">Availability</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->availability }}
            </span>
        </div>
    @endif

    @if($product->weight !== null && $product->weight !== '')
        <div>
            <span class="block text-[#a39e97] font-medium">Weight</span>
            <span class="text-[#2b2723] font-bold">
                {{ $product->weight }} kg
            </span>
        </div>
    @endif



                </div>



                <!-- ============================================= -->
                <!-- PRICE -->
                <!-- ============================================= -->

                <div class="flex items-baseline justify-between">

                    <div>

                        @php
                            $mrp = (float) $product->mrp;
                            $sellingPrice = (float) $product->price;
                            $discount = (float) $product->discount;
                        @endphp


                        @if($mrp > 0)

                            <div class="flex items-center gap-3 flex-wrap">
                                 <!-- MRP -->

                                <span class="text-sm font-semibold text-[#a39e97] line-through">

                                    ₹{{ number_format(round($mrp)) }}

                                </span>


                                <!-- SELLING PRICE -->

                                <span class="text-2xl font-black text-[#171615]">

                                    ₹{{ number_format(round($sellingPrice)) }}

                                </span>


                                @if($isTiles)

                                    <span class="text-sm font-semibold text-[#736c63]">
                                        / sq.ft
                                    </span>

                                @endif


                                <!-- DISCOUNT -->

                                @if($discount > 0)

                                    <span class="text-sm font-bold text-emerald-600">

                                        Discount {{ number_format($discount, 0) }}%

                                    </span>

                                @endif

                            </div>


                            <p class="text-[10px] text-[#a39e97] font-medium">

                                MRP{{ $isTiles ? ' / sq.ft' : '' }}

                            </p>

                        @else

                            <span class="text-2xl font-black text-[#171615]">

                                ₹{{ number_format(round($sellingPrice)) }}

                            </span> </span>


                            @if($isTiles)

                                <span class="text-sm font-semibold text-[#736c63]">
                                    / sq.ft
                                </span>

                            @endif


                            <p class="text-[10px] text-[#a39e97] font-medium">
                                Inclusive of all taxes
                            </p>

                        @endif

                    </div>


                    <!-- STOCK -->

                    <div class="text-right">

                        <span class="text-emerald-600 font-bold text-xs">
                            In Stock
                        </span>

                        <p class="text-[10px] text-[#a39e97] font-medium">

                            ({{ $product->stock }}
                            @if($isTiles)
                                sq.ft
                            @else
                                units
                            @endif
                            available)

                        </p>

                    </div>

                </div>

                <!-- ================================================= -->
                <!-- SERVICE AREA CHECKER -->
                <!-- ================================================= -->
                <div x-data="{
                    pincode: '',
                    status: null, // 'loading', 'success', 'error'
                    message: '',
                    checkPincode() {
                        if(this.pincode.length < 6) return;
                        this.status = 'loading';
                        fetch('/api/check-pincode?pincode=' + this.pincode)
                            .then(res => res.json())
                            .then(data => {
                                this.status = data.status;
                                this.message = data.message;
                            })
                            .catch(err => {
                                this.status = 'error';
                                this.message = 'Error verifying PIN code.';
                            });
                    }
                }" class="bg-[#f5f1eb] border border-[#ded7cd] rounded-2xl p-4 my-4">
                    <label class="block text-xs font-bold text-[#2b2723] mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#a39e97]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Check Delivery Area
                    </label>
                    <div class="flex gap-2">
                        <input type="text" x-model="pincode" maxlength="6" placeholder="Enter PIN code" class="w-full bg-white border-[#ded7cd] rounded-xl text-sm focus:ring-[#b58d56] focus:border-[#b58d56]">
                        <button type="button" @click="checkPincode()" class="bg-[#171615] hover:bg-[#2b2723] text-white text-xs font-bold px-4 py-2 rounded-xl transition whitespace-nowrap shrink-0">
                            Check
                        </button>
                    </div>
                    
                    <div x-show="status === 'loading'" class="mt-2 text-[10px] text-[#736c63] font-bold animate-pulse" x-cloak>Verifying...</div>
                    <div x-show="status === 'success'" class="mt-2 text-[10px] text-emerald-600 font-bold bg-emerald-50 px-3 py-1.5 rounded-lg inline-block" x-cloak x-text="message"></div>
                    <div x-show="status === 'error'" class="mt-2 text-[10px] text-red-600 font-bold bg-red-50 px-3 py-1.5 rounded-lg inline-block" x-cloak x-text="message"></div>
                </div>

                <!-- ================================================= -->
                <!-- PROFESSIONAL USER -->
                <!-- ================================================= -->

                @if($isProfessional)

                    @if($product->wholesale_price)

                        <div
                            class="bg-[#171615]/5 border border-[#ded7cd] rounded-2xl p-4 space-y-2 text-xs font-semibold"
                        >

                            <div class="flex items-center justify-between">

                                <span class="text-[#b58d56]">
                                    Trade / Wholesale Rate
                                </span>

                                <span class="text-[#171615] font-black text-sm">

                                    ₹{{ number_format(round($product->wholesale_price)) }}

                                    @if($isTiles)
                                        / sq.ft
                                    @endif

                                </span>

                            </div>


                            <div class="flex items-center justify-between">

                                <span class="text-[#b58d56]">
                                    Retail Rate
                                </span>

                                <span class="text-[#171615] font-bold">

                                    ₹{{ number_format(round($product->price)) }}

                                    @if($isTiles)
                                        / sq.ft
                                    @endif

                                </span>

                            </div>


                            <div class="flex items-center justify-between">

                                <span class="text-[#b58d56]">
                                    You Save on Trade
                                </span>

                                <span class="text-emerald-700 font-black">

                                    @php
                                        $saving = $product->price > 0
                                            ? (($product->price - $product->wholesale_price) / $product->price) * 100
                                            : 0;
                                    @endphp

                                    {{ number_format(max($saving, 0), 1) }}%

                                </span>

                            </div>

                        </div>

                    @endif



                    <!-- QUANTITY -->

                    <div class="flex items-center gap-3">

                        <span class="text-xs font-bold text-[#736c63]">
                            Quantity
                            @if($isTiles)
                                (sq.ft)
                            @endif
                        </span>


                        <div
                            class="flex items-center border border-[#ded7cd] rounded-xl overflow-hidden h-10 bg-[#f5f1eb]"
                        >

                            <button
                                type="button"
                                @click="quantity > 1 ? quantity-- : null"
                                class="px-3 text-[#615a52] font-bold hover:bg-[#eae3d8] transition"
                            >
                                &minus;
                            </button>


                            <input
                                type="number"
                                x-model="quantity"
                                class="w-16 border-none text-center bg-transparent focus:ring-0 font-bold text-[#2b2723] text-sm"
                                readonly
                            >


                            <button
                                type="button"
                                @click="quantity++"
                                class="px-3 text-[#615a52] font-bold hover:bg-[#eae3d8] transition"
                            >
                                &plus;
                            </button>

                        </div>

                    </div>



                    <!-- PRO ACTIONS -->

                    <div class="space-y-3">

                        <a
                            href="/quotation-requests/create?product_id={{ $product->id }}"
                            class="w-full bg-[#171615] hover:bg-[#2b2723] text-white font-bold h-12 rounded-xl transition text-sm flex items-center justify-center"
                        >
                            Request Bulk Quotation
                        </a>


                        <a
                            href="{{ route('showroom.book') }}"
                            class="w-full bg-[#c09b5a] hover:bg-[#a58245] text-white font-bold h-12 rounded-xl transition text-sm flex items-center justify-center gap-2 shadow-sm"
                        >
                            <span>🏢</span>
                            <span>
                                Book Trade Showroom Visit (B2B)
                            </span>
                        </a>


                        <p class="text-[10px] text-[#a39e97] text-center">

                            Bulk quotes are confirmed by our trade desk with final pricing.

                        </p>

                    </div>



                    <!-- TRADE PRICE SUMMARY -->

                    <div
                        class="bg-[#f5f1eb] border p-5 rounded-2xl space-y-3 text-xs font-semibold text-[#615a52]"
                    >

                        <h4 class="font-serif-pristo text-xl font-bold border-b pb-2">
                            Trade Price Estimate
                        </h4>


                        <div class="flex justify-between">

                            <span>
                                Trade rate
                                @if($isTiles)
                                    (1 sq.ft)
                                @endif
                            </span>

                            <span class="text-[#171615] font-bold">

                                ₹{{ number_format(round($professionalPrice)) }}

                            </span>

                        </div>


                        <div class="flex justify-between">

                            <span>
                                Quantity
                            </span>

                            <span
                                class="text-[#171615] font-bold"
                                x-text="quantity + '{{ $isTiles ? ' sq.ft' : '' }}'"
                            >
                                1
                            </span>

                        </div>


                        <div
                            class="flex justify-between border-t pt-2 text-[#171615] font-bold text-sm"
                        >

                            <span>
                                Est. Total
                            </span>

                            <span
                                class="text-[#b58d56] font-black"
                                x-text="'₹' + Math.round(totalTax)"
                            >
                                ₹0.00
                            </span>

                        </div>

                    </div>


                @else


                    <!-- ================================================= -->
                    <!-- NORMAL CUSTOMER -->
                    <!-- ================================================= -->

                    <div class="space-y-6">

                        <!-- QUANTITY -->
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-bold text-[#736c63]">
                                Quantity
                                @if($isTiles) (sq.ft) @endif
                            </span>
                            <div class="flex items-center border border-[#ded7cd] rounded-xl overflow-hidden h-10 bg-[#f5f1eb]">
                                <button type="button" @click="quantity > 1 ? quantity-- : null" class="px-3 text-[#615a52] font-bold hover:bg-[#eae3d8] transition">&minus;</button>
                                <input type="number" x-model="quantity" class="w-16 border-none text-center bg-transparent focus:ring-0 font-bold text-[#2b2723] text-sm" readonly>
                                <button type="button" @click="quantity++" class="px-3 text-[#615a52] font-bold hover:bg-[#eae3d8] transition">&plus;</button>
                            </div>
                        </div>

                        <!-- PRICE SUMMARY -->
                        <div class="bg-[#f5f1eb] border p-5 rounded-2xl space-y-3 text-xs font-semibold text-[#615a52]">
                            <h4 class="font-serif-pristo text-xl font-bold border-b pb-2">Price Summary</h4>
                            <div class="flex justify-between">
                                <span>Price @if($isTiles) (1 sq.ft) @endif</span>
                                <span class="text-[#171615] font-bold">₹{{ number_format(round($product->price)) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Quantity</span>
                                <span class="text-[#171615] font-bold" x-text="quantity + '{{ $isTiles ? ' sq.ft' : '' }}'">1</span>
                            </div>
                            <div class="flex justify-between border-t pt-2 text-[#171615] font-bold text-sm">
                                <span>Total (Incl. Tax)</span>
                                <span class="text-[#b58d56] font-black" x-text="'₹' + Math.round(totalTax)">₹0.00</span>
                            </div>
                        </div>

                        <!-- ADD TO CART + BUY NOW -->
                        <div class="flex flex-col sm:flex-row gap-4">
                           <form action="/cart/add" method="POST" class="flex-1">
    @csrf

    <input
        type="hidden"
        name="product_id"
        value="{{ $product->id }}"
    >

    <input
        type="hidden"
        name="quantity"
        :value="quantity"
    >

    <button
        type="submit"
        style="color: #ffffff !important;"
        class="w-full bg-[#171615] hover:bg-[#2b2723] font-bold h-12 rounded-xl transition text-sm"
    >
        Add to Cart
    </button>
</form>
                            <form action="/buy-now" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" :value="quantity">
                                <button type="submit" class="w-full bg-[#b58d56] hover:bg-[#c09b5a] !text-white font-bold h-12 rounded-xl transition text-sm">
                                    Buy Now
                                </button>
                            </form>
                        </div>

                        <!-- WISHLIST & SHOWROOM -->
                        <div class="grid grid-cols-2 gap-4">
                            <a href="/wishlist/add/{{ $product->id }}" class="flex items-center justify-center gap-2 bg-white border border-[#ded7cd] text-xs font-bold text-[#736c63] hover:text-red-500 hover:border-red-500 h-11 rounded-xl transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                <span>Wishlist</span>
                            </a>
                            <a href="{{ route('showroom.book') }}" class="flex items-center justify-center gap-2 bg-[#faf7f2] border border-[#ded7cd] text-xs font-bold text-[#171615] hover:border-[#b58d56] h-11 rounded-xl transition shadow-sm">
                                <span>📍</span>
                                <span>Showroom</span>
                            </a>
                        </div>

                    </div>

                    </div>

                @endif

            </div>

        </div>



        <!-- ========================================================= -->
        <!-- DESCRIPTION / INFO / REVIEWS -->
        <!-- ========================================================= -->

        <div
            class="mt-12 bg-white border border-[#ded7cd] rounded-2xl p-8"
            x-data="{ activeTab: 'desc' }"
        >

            <div class="flex border-b text-sm font-bold text-[#a39e97] gap-6">

                <button
                    @click="activeTab = 'desc'"
                    :class="activeTab === 'desc'
                        ? 'border-b-2 border-[#b58d56] text-[#b58d56] pb-3'
                        : 'pb-3'"
                    class="focus:outline-none"
                >
                    Description
                </button>


               

               

            </div>


            <div class="mt-6 text-sm text-[#615a52] leading-relaxed">

                <div x-show="activeTab === 'desc'">
                    
                     <p>
                        {{ $product->short_description }}
                    </p>
<br>
                    <p>
                        {{ $product->description }}
                    </p>
                    
                     <p>
                        <strong>Coverage Area:</strong>
                        {{ $product->coverage_area ?: 'N/A' }}
                    </p>


                    <p>
                        <strong>Warranty:</strong>
                        {{ $product->warranty ?: 'N/A' }}
                    </p>


                    <p>
                        <strong>Estimated Delivery:</strong>
                        {{ $product->delivery_time ?: 'N/A' }}

                        <span class="text-xs text-[#b58d56] font-bold">
                            (Shipping Charges Applicable at actuals)
                        </span>
                    </p>
                    
                    

                </div>


               

            </div>

        </div>


```blade
<!-- ========================================================= -->
<!-- TILE REQUIREMENT CALCULATOR -->
<!-- ========================================================= -->

@if($isTiles)

<div
    class="mt-12 bg-white border border-[#ded7cd] rounded-2xl p-6 sm:p-8 shadow-sm"
    x-data="{
        tileType: '{{ $product->sub_category ?? 'Floor Tile' }}',

        sizeMode: 'product',

        productWidth: {{ (float) ($product->width_mm ?: 600) }},
        productHeight: {{ (float) ($product->height_mm ?: 600) }},

        customWidth: 600,
        customHeight: 600,

        length: 12,
        height: 10,
        width: 10,

        tilesPerBox: {{ (int) ($product->pieces_per_box ?: 2) }},
        pricePerBox: {{ (float) ($product->price_per_box ?: 0) }},

        calculated: false,

        get tileWidth() {
            return this.sizeMode === 'product'
                ? this.productWidth
                : this.customWidth;
        },

        get tileHeight() {
            return this.sizeMode === 'product'
                ? this.productHeight
                : this.customHeight;
        },

        get tileAreaSqft() {
            if (this.tileWidth <= 0 || this.tileHeight <= 0) {
                return 0;
            }

            return (this.tileWidth / 304.8) * (this.tileHeight / 304.8);
        },

        // Floor: Length × Width
        // Wall: Length × Height
        get roomArea() {
            if (this.length <= 0) {
                return 0;
            }

            if (this.tileType === 'Wall Tile') {
                if (this.height <= 0) {
                    return 0;
                }

                return this.length * this.height;
            }

            if (this.width <= 0) {
                return 0;
            }

            return this.length * this.width;
        },

        // Wall Volume = Length × Height × Width
        get wallVolume() {
            if (
                this.length <= 0 ||
                this.height <= 0 ||
                this.width <= 0
            ) {
                return 0;
            }

            return this.length * this.height * this.width;
        },

        get tilesNeeded() {
            if (this.tileAreaSqft <= 0 || this.roomArea <= 0) {
                return 0;
            }

            return Math.ceil(this.roomArea / this.tileAreaSqft);
        },

        get boxesNeeded() {
            if (this.tilesPerBox <= 0 || this.tilesNeeded <= 0) {
                return 0;
            }

            return Math.ceil(this.tilesNeeded / this.tilesPerBox);
        },

        get costEstimate() {
            if (this.pricePerBox <= 0 || this.boxesNeeded <= 0) {
                return 0;
            }

            return this.boxesNeeded * this.pricePerBox;
        },

        calculate() {
            this.calculated = true;
        }
    }"
>

    <!-- ========================================================= -->
    <!-- HEADER -->
    <!-- ========================================================= -->

    <div>
        <h2 class="text-xl sm:text-2xl font-black text-[#171615] tracking-tight">
            Tile Requirement Calculator
        </h2>

        <p class="text-xs sm:text-sm text-[#a39e97] font-medium mt-1">
            Calculate the tiles and boxes required for your project.
        </p>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-7">

        <!-- ===================================================== -->
        <!-- LEFT INPUTS -->
        <!-- ===================================================== -->

        <div class="lg:col-span-1 space-y-5">

            <!-- TILE TYPE -->

            <div>
                <label class="block text-xs font-bold text-[#736c63] uppercase mb-2">
                    What is the type of tile?
                </label>

                <div class="grid grid-cols-2 gap-3">

                    <label
                        class="cursor-pointer border rounded-xl p-3 text-center transition-all"
                        :class="tileType === 'Floor Tile'
                            ? 'border-[#b58d56] bg-[#eae3d8] text-[#b58d56]'
                            : 'border-[#ded7cd] bg-white text-[#615a52] hover:border-[#b58d56]'"
                    >
                        <input
                            type="radio"
                            value="Floor Tile"
                            x-model="tileType"
                            class="sr-only"
                        >

                        <span class="text-xs font-bold">
                            Floor Tile
                        </span>
                    </label>


                    <label
                        class="cursor-pointer border rounded-xl p-3 text-center transition-all"
                        :class="tileType === 'Wall Tile'
                            ? 'border-[#b58d56] bg-[#eae3d8] text-[#b58d56]'
                            : 'border-[#ded7cd] bg-white text-[#615a52] hover:border-[#b58d56]'"
                    >
                        <input
                            type="radio"
                            value="Wall Tile"
                            x-model="tileType"
                            class="sr-only"
                        >

                        <span class="text-xs font-bold">
                            Wall Tile
                        </span>
                    </label>

                </div>
            </div>


            <!-- ================================================= -->
            <!-- TILE SIZE -->
            <!-- ================================================= -->

            <div>
                <label class="block text-xs font-bold text-[#736c63] uppercase mb-2">
                    What is the size of your tile?
                </label>

                <div class="grid grid-cols-2 gap-3 mb-3">

                    <label
                        class="cursor-pointer border rounded-xl p-3 text-center transition-all"
                        :class="sizeMode === 'product'
                            ? 'border-[#b58d56] bg-[#eae3d8] text-[#b58d56]'
                            : 'border-[#ded7cd] bg-white text-[#615a52] hover:border-[#b58d56]'"
                    >
                        <input
                            type="radio"
                            value="product"
                            x-model="sizeMode"
                            class="sr-only"
                        >

                        <span class="text-xs font-bold">
                            Product Size
                        </span>
                    </label>


                    <label
                        class="cursor-pointer border rounded-xl p-3 text-center transition-all"
                        :class="sizeMode === 'custom'
                            ? 'border-[#b58d56] bg-[#eae3d8] text-[#b58d56]'
                            : 'border-[#ded7cd] bg-white text-[#615a52] hover:border-[#b58d56]'"
                    >
                        <input
                            type="radio"
                            value="custom"
                            x-model="sizeMode"
                            class="sr-only"
                        >

                        <span class="text-xs font-bold">
                            Custom Size
                        </span>
                    </label>

                </div>


                <!-- PRODUCT SIZE -->

                <div
                    x-show="sizeMode === 'product'"
                    x-cloak
                >
                    <div class="bg-[#f5f1eb] border border-[#ded7cd] rounded-xl p-4">

                        <p class="text-[10px] font-bold text-[#a39e97] uppercase">
                            Product Tile Size
                        </p>

                        <p class="text-lg font-black text-[#171615] mt-1">
                            <span x-text="productWidth"></span>
                            ×
                            <span x-text="productHeight"></span>

                            <span class="text-xs font-semibold text-[#a39e97]">
                                mm
                            </span>
                        </p>

                    </div>
                </div>


                <!-- CUSTOM SIZE -->

                <div
                    x-show="sizeMode === 'custom'"
                    x-cloak
                    class="grid grid-cols-2 gap-3"
                >

                    <div>
                        <label class="text-[10px] font-bold text-[#a39e97] uppercase">
                            Width (mm)
                        </label>

                        <input
                            type="number"
                            min="1"
                            step="1"
                            x-model.number="customWidth"
                            class="w-full border-[#ded7cd] rounded-xl text-sm p-3 mt-1 focus:border-[#b58d56] focus:ring-0"
                        >
                    </div>


                    <div>
                        <label class="text-[10px] font-bold text-[#a39e97] uppercase">
                            Height (mm)
                        </label>

                        <input
                            type="number"
                            min="1"
                            step="1"
                            x-model.number="customHeight"
                            class="w-full border-[#ded7cd] rounded-xl text-sm p-3 mt-1 focus:border-[#b58d56] focus:ring-0"
                        >
                    </div>

                </div>
            </div>


            <!-- ================================================= -->
            <!-- FLOOR AREA / WALL DIMENSIONS -->
            <!-- ================================================= -->

            <div>
                <label
                    class="block text-xs font-bold text-[#736c63] uppercase mb-2"
                    x-text="tileType === 'Wall Tile'
                        ? 'Enter your wall dimensions'
                        : 'What is the total area you are planning to tile?'"
                >
                </label>

                <div class="grid grid-cols-2 gap-3">

                    <!-- LENGTH -->

                    <div>
                        <input
                            type="number"
                            min="0"
                            step="0.1"
                            x-model.number="length"
                            placeholder="Length"
                            class="w-full border-[#ded7cd] rounded-xl text-sm p-3 focus:border-[#b58d56] focus:ring-0"
                        >

                        <span class="text-[10px] text-[#a39e97] font-semibold">
                            Length (ft)
                        </span>
                    </div>


                    <!-- HEIGHT: WALL ONLY -->

                    <div
                        x-show="tileType === 'Wall Tile'"
                        x-cloak
                    >
                        <input
                            type="number"
                            min="0"
                            step="0.1"
                            x-model.number="height"
                            placeholder="Height"
                            class="w-full border-[#ded7cd] rounded-xl text-sm p-3 focus:border-[#b58d56] focus:ring-0"
                        >

                        <span class="text-[10px] text-[#a39e97] font-semibold">
                            Height (ft)
                        </span>
                    </div>


                    <!-- WIDTH -->

                    <div>
                        <input
                            type="number"
                            min="0"
                            step="0.1"
                            x-model.number="width"
                            placeholder="Width"
                            class="w-full border-[#ded7cd] rounded-xl text-sm p-3 focus:border-[#b58d56] focus:ring-0"
                        >

                        <span
                            class="text-[10px] text-[#a39e97] font-semibold"
                            x-text="tileType === 'Wall Tile'
                                ? 'Thickness / Width (ft)'
                                : 'Width (ft)'"
                        >
                        </span>
                    </div>

                </div>


                <!-- ================================================= -->
                <!-- WALL VOLUME CALCULATOR -->
                <!-- ================================================= -->

                <div
                    x-show="tileType === 'Wall Tile'"
                    x-cloak
                    class="mt-4 bg-[#f5f1eb] border border-[#ded7cd] rounded-xl p-4"
                >

                    <p class="text-[10px] font-bold text-[#a39e97] uppercase tracking-wider">
                        Total Wall Volume
                    </p>

                    <p class="text-2xl font-black text-[#171615] mt-1">
                        <span
                            x-text="wallVolume.toLocaleString('en-IN', {
                                maximumFractionDigits: 2
                            })"
                        ></span>

                        <span class="text-xs font-semibold text-[#a39e97]">
                            cu. ft.
                        </span>
                    </p>


                    <div class="mt-3 border-t border-[#ded7cd] pt-3">

                        <p class="text-xs text-[#736c63] leading-relaxed">
                            <strong>Calculation:</strong>

                            <span x-text="length"></span>
                            ×
                            <span x-text="height"></span>
                            ×
                            <span x-text="width"></span>
                            =

                            <strong>
                                <span
                                    x-text="wallVolume.toLocaleString('en-IN', {
                                        maximumFractionDigits: 2
                                    })"
                                ></span>
                                cu. ft.
                            </strong>
                        </p>

                        <p class="text-[10px] text-[#a39e97] mt-2">
                            Formula: Length × Height × Width (all dimensions in feet).
                        </p>

                    </div>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- TILES PER BOX -->
            <!-- ================================================= -->

            <div>
                <label class="block text-xs font-bold text-[#736c63] uppercase mb-2">
                    Tiles per box
                </label>

                <input
                    type="number"
                    min="1"
                    step="1"
                    x-model.number="tilesPerBox"
                    class="w-full border-[#ded7cd] rounded-xl text-sm p-3 focus:border-[#b58d56] focus:ring-0"
                >

                <p class="text-[10px] text-[#a39e97] mt-1">
                    Number of tiles included in one box.
                </p>
            </div>


            <!-- ================================================= -->
            <!-- PRICE PER BOX -->
            <!-- ================================================= -->

            <div>
                <label class="block text-xs font-bold text-[#736c63] uppercase mb-2">
                    Price per box
                </label>

                <div class="relative">

                    <span class="absolute left-3 top-3 text-sm font-bold text-[#a39e97]">
                        ₹
                    </span>

                    <input
                        type="number"
                        min="0"
                        step="0.01"
                        x-model.number="pricePerBox"
                        class="w-full border-[#ded7cd] rounded-xl text-sm p-3 pl-8 focus:border-[#b58d56] focus:ring-0"
                    >

                </div>
            </div>


            <!-- ================================================= -->
            <!-- CALCULATE BUTTON -->
            <!-- ================================================= -->

            <button
                type="button"
                @click="calculate()"
                class="w-full bg-[#b58d56] hover:bg-[#c09b5a] !text-white font-bold py-3 rounded-xl transition text-sm"
            >
                Calculate
            </button>

        </div>


        <!-- ===================================================== -->
        <!-- RIGHT RESULT -->
        <!-- ===================================================== -->

        <div
            class="lg:col-span-2 bg-[#f5f1eb] border border-[#ded7cd] rounded-2xl p-5 sm:p-6"
            x-show="calculated"
            x-cloak
        >

            <!-- RESULT HEADER -->

            <div class="mb-5">

                <p class="text-xs font-bold text-[#a39e97] uppercase tracking-wider">
                    Your Tiling Project Estimate
                </p>

                <p class="text-sm text-[#736c63] mt-1">
                    Based on your selected tile type, tile size and dimensions.
                </p>

            </div>


            <!-- TILE INFO -->

            <div class="bg-white border border-[#ded7cd] rounded-xl p-4 mb-4">

                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <p class="text-[10px] font-bold text-[#a39e97] uppercase">
                            Tile Type
                        </p>

                        <p
                            class="text-base font-black text-[#171615] mt-1"
                            x-text="tileType"
                        ></p>
                    </div>


                    <div class="text-right">
                        <p class="text-[10px] font-bold text-[#a39e97] uppercase">
                            Tile Size
                        </p>

                        <p class="text-base font-black text-[#171615] mt-1">
                            <span x-text="tileWidth"></span>
                            ×
                            <span x-text="tileHeight"></span>

                            <span class="text-xs font-semibold text-[#a39e97]">
                                mm
                            </span>
                        </p>
                    </div>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- RESULT CARDS -->
            <!-- ================================================= -->

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                <!-- TOTAL AREA -->

                <div class="bg-white border border-[#ded7cd] rounded-xl p-5">

                    <p
                        class="text-[10px] font-bold text-[#a39e97] uppercase tracking-wider"
                        x-text="tileType === 'Wall Tile'
                            ? 'Total Wall Area'
                            : 'Total Floor Area'"
                    >
                    </p>

                    <p class="text-2xl font-black text-[#171615] mt-1">

                        <span x-text="roomArea.toFixed(2)"></span>

                        <span class="text-xs font-semibold text-[#a39e97]">
                            sq.ft
                        </span>

                    </p>

                </div>


                <!-- ONE TILE AREA -->

                <div class="bg-white border border-[#ded7cd] rounded-xl p-5">

                    <p class="text-[10px] font-bold text-[#a39e97] uppercase tracking-wider">
                        One Tile Area
                    </p>

                    <p class="text-2xl font-black text-[#171615] mt-1">

                        <span x-text="tileAreaSqft.toFixed(3)"></span>

                        <span class="text-xs font-semibold text-[#a39e97]">
                            sq.ft
                        </span>

                    </p>

                </div>


                <!-- TILES NEEDED -->

                <div class="bg-white border border-[#ded7cd] rounded-xl p-5">

                    <p class="text-[10px] font-bold text-[#a39e97] uppercase tracking-wider">
                        Tiles Needed
                    </p>

                    <p class="text-2xl font-black text-[#b58d56] mt-1">

                        <span x-text="tilesNeeded"></span>

                        <span class="text-xs font-semibold text-[#a39e97]">
                            tiles
                        </span>

                    </p>

                </div>


                <!-- BOXES NEEDED -->

                <div class="bg-white border border-[#ded7cd] rounded-xl p-5">

                    <p class="text-[10px] font-bold text-[#a39e97] uppercase tracking-wider">
                        Boxes Needed
                    </p>

                    <p class="text-2xl font-black text-[#b58d56] mt-1">

                        <span x-text="boxesNeeded"></span>

                        <span class="text-xs font-semibold text-[#a39e97]">
                            boxes
                        </span>

                    </p>

                </div>


                <!-- WALL VOLUME RESULT -->

                <div
                    x-show="tileType === 'Wall Tile'"
                    x-cloak
                    class="sm:col-span-2 bg-white border border-[#ded7cd] rounded-xl p-5"
                >

                    <p class="text-[10px] font-bold text-[#a39e97] uppercase tracking-wider">
                        Total Wall Volume
                    </p>

                    <p class="text-2xl font-black text-[#171615] mt-1">

                        <span
                            x-text="wallVolume.toLocaleString('en-IN', {
                                maximumFractionDigits: 2
                            })"
                        ></span>

                        <span class="text-xs font-semibold text-[#a39e97]">
                            cu. ft.
                        </span>

                    </p>

                    <p class="text-xs text-[#736c63] mt-2">
                        Calculation:

                        <span x-text="length"></span>
                        ×
                        <span x-text="height"></span>
                        ×
                        <span x-text="width"></span>
                        =

                        <strong>
                            <span
                                x-text="wallVolume.toLocaleString('en-IN', {
                                    maximumFractionDigits: 2
                                })"
                            ></span>
                            cu. ft.
                        </strong>
                    </p>

                </div>


                <!-- ESTIMATED COST -->

                <div
                    class="sm:col-span-2 bg-white border border-[#ded7cd] rounded-xl p-5"
                    x-show="costEstimate > 0"
                    x-cloak
                >

                    <div class="flex items-center justify-between gap-4">

                        <div>
                            <p class="text-[10px] font-bold text-[#a39e97] uppercase tracking-wider">
                                Estimated Material Cost
                            </p>

                            <p class="text-xs text-[#a39e97] mt-1">
                                Based on price per box
                            </p>
                        </div>

                        <p class="text-2xl font-black text-[#171615]">
                            ₹<span
                                x-text="costEstimate.toLocaleString('en-IN', {
                                    maximumFractionDigits: 0
                                })"
                            ></span>
                        </p>

                    </div>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- CALCULATION DETAILS -->
            <!-- ================================================= -->

            <div class="mt-5 bg-[#eae3d8] border border-[#b58d56]/20 rounded-xl px-4 py-3">

                <p class="text-xs text-[#736c63] leading-relaxed">

                    <strong>Tile Calculation:</strong>

                    <span x-text="roomArea.toFixed(2)"></span>
                    sq.ft ÷

                    <span x-text="tileAreaSqft.toFixed(3)"></span>
                    sq.ft per tile =

                    <strong>
                        <span x-text="tilesNeeded"></span>
                        tiles
                    </strong>

                    →

                    approximately

                    <strong>
                        <span x-text="boxesNeeded"></span>
                        boxes
                    </strong>.

                </p>


                <p
                    x-show="tileType === 'Wall Tile'"
                    x-cloak
                    class="text-xs text-[#736c63] leading-relaxed mt-2"
                >

                    <strong>Wall Area Formula:</strong>

                    <span x-text="length"></span>
                    ×
                    <span x-text="height"></span>
                    =

                    <strong>
                        <span x-text="roomArea.toFixed(2)"></span>
                        sq.ft
                    </strong>.

                </p>


                <p
                    x-show="tileType === 'Wall Tile'"
                    x-cloak
                    class="text-xs text-[#736c63] leading-relaxed mt-2"
                >

                    <strong>Wall Volume Formula:</strong>

                    Length × Height × Width =

                    <strong>
                        <span
                            x-text="wallVolume.toLocaleString('en-IN', {
                                maximumFractionDigits: 2
                            })"
                        ></span>
                        cu. ft.
                    </strong>.

                </p>

            </div>

        </div>

    </div>

</div>

@endif
```

        <!-- RELATED PRODUCTS SECTION -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mt-16 sm:mt-24 border-t border-[#ded7cd] pt-12 sm:pt-16">
            <h2 class="font-serif-pristo text-2xl sm:text-3xl font-bold text-[#171615] mb-8">Related Products</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relProduct)
                <div class="group bg-[#f5f1eb] rounded-2xl border border-[#ded7cd] shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 flex flex-col h-full overflow-hidden">
                    <a href="{{ route('products.show', $relProduct->slug) }}" class="aspect-square bg-white relative block overflow-hidden p-4">
                        <img src="{{ asset($relProduct->featured_image) }}" alt="{{ $relProduct->name }}" class="w-full h-full object-contain mix-blend-multiply group-hover:scale-105 transition duration-500">
                    </a>
                    
                    <div class="p-5 flex flex-col flex-grow">
                        <a href="{{ route('products.show', $relProduct->slug) }}" class="font-bold text-[#171615] hover:text-[#b58d56] text-sm line-clamp-2 mb-2 leading-snug">
                            {{ $relProduct->name }}
                        </a>
                        
                        <div class="text-[10px] text-[#736c63] font-bold uppercase tracking-wider mb-auto">
                            {{ $relProduct->brand->name ?? 'Pristo' }}
                        </div>
                        
                        <div class="mt-auto pt-4 border-t border-[#ded7cd] flex items-center justify-between">
                            <div>
                                <div class="font-black text-[#171615] text-lg leading-none">
                                    ₹{{ number_format(round($relProduct->price)) }}
                                    @if((int) $relProduct->category_id === 1)
                                        <span class="text-[10px] sm:text-xs font-semibold text-[#736c63]">/ sq.ft</span>
                                    @endif
                                </div>
                                @if($relProduct->discount > 0)
                                    <div class="flex items-center gap-2 mt-1">
                                        <div class="text-[10px] text-[#a39e97] line-through">
                                            ₹{{ number_format(round($relProduct->mrp)) }}
                                            @if((int) $relProduct->category_id === 1)
                                                / sq.ft
                                            @endif
                                        </div>
                                        <div class="text-[9px] font-bold text-[#171615] bg-[#c09b5a]/20 px-1.5 py-0.5 rounded border border-[#c09b5a]/30">
                                            -{{ rtrim(rtrim(number_format($relProduct->discount, 2), '0'), '.') }}%
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('products.show', $relProduct->slug) }}" class="flex-shrink-0 w-8 h-8 rounded-full bg-white border border-[#ded7cd] text-[#171615] flex items-center justify-center group-hover:border-[#b58d56] group-hover:bg-[#b58d56] group-hover:text-white transition-all duration-300">
                                ➔
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

</x-app-layout>


