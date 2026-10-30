<x-app-layout>
    <x-slot name="title">Compare Products - BuildMart</x-slot>

    <div class="bg-slate-50 py-12 min-h-[60vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 tracking-tight">Compare Products</h1>
                    <p class="text-sm text-slate-500 mt-2">Evaluate and compare specifications to make the best choice.</p>
                </div>
                @if(count($products) > 0)
                <form action="{{ route('compare.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-red-500 hover:text-red-600 font-bold text-sm bg-red-50 px-4 py-2 rounded-xl transition">Clear All</button>
                </form>
                @endif
            </div>

            @if(count($products) == 0)
                <div class="bg-white border border-slate-200 rounded-3xl p-12 text-center shadow-sm">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-2">No products to compare</h3>
                    <p class="text-slate-500 mb-6 max-w-md mx-auto">You haven't added any products to the comparison list yet. Browse our catalog to find products to compare.</p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-teal-600 hover:bg-teal-700 text-white font-bold px-8 py-3.5 rounded-xl transition shadow-sm">Browse Products</a>
                </div>
            @else
                <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[800px]">
                        <thead>
                            <tr class="bg-slate-50/50">
                                <th class="p-6 border-b border-r border-slate-100 w-48 shrink-0 align-bottom">
                                    <span class="text-xs font-black text-slate-400 uppercase tracking-wider">Features</span>
                                </th>
                                @foreach($products as $product)
                                <th class="p-6 border-b border-r border-slate-100 w-72 text-center relative">
                                    <form action="{{ route('compare.remove') }}" method="POST" class="absolute top-4 right-4">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit" class="w-8 h-8 bg-slate-100 hover:bg-red-100 text-slate-400 hover:text-red-500 rounded-full flex items-center justify-center transition" title="Remove">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                    
                                    <div class="aspect-square w-32 mx-auto bg-slate-50 rounded-xl p-2 mb-4 border border-slate-100">
                                        <img src="{{ asset($product->featured_image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                                    </div>
                                    <h3 class="text-sm font-black text-slate-900 leading-tight mb-2 h-10">{{ $product->name }}</h3>
                                    <div class="text-lg font-black text-teal-700 mb-4">₹{{ number_format(round($product->price)) }}</div>
                                    
                                    <a href="{{ route('products.show', $product->slug) }}" class="block w-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-2.5 rounded-lg transition">View Details</a>
                                </th>
                                @endforeach
                                @for($i = count($products); $i < 4; $i++)
                                <th class="p-6 border-b border-r border-slate-100 w-72 text-center bg-slate-50/30">
                                    <div class="aspect-square w-32 mx-auto bg-slate-100 rounded-xl mb-4 border border-slate-200 border-dashed flex items-center justify-center text-slate-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                    <h3 class="text-sm font-bold text-slate-400 mb-2">Add Product</h3>
                                    <a href="{{ route('products.index') }}" class="block w-full bg-white border border-slate-200 hover:border-teal-400 text-slate-600 hover:text-teal-600 text-xs font-bold py-2.5 rounded-lg transition">Browse</a>
                                </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition">
                                <td class="p-4 border-r border-slate-100 font-bold text-slate-700 bg-slate-50/30">Brand</td>
                                @foreach($products as $product)
                                <td class="p-4 border-r border-slate-100 text-center text-slate-600 font-medium">{{ $product->brand->name ?? 'N/A' }}</td>
                                @endforeach
                                @for($i = count($products); $i < 4; $i++)<td class="p-4 border-r border-slate-100 bg-slate-50/30"></td>@endfor
                            </tr>
                            <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition">
                                <td class="p-4 border-r border-slate-100 font-bold text-slate-700 bg-slate-50/30">Category</td>
                                @foreach($products as $product)
                                <td class="p-4 border-r border-slate-100 text-center text-slate-600 font-medium">{{ $product->category->name ?? 'N/A' }}</td>
                                @endforeach
                                @for($i = count($products); $i < 4; $i++)<td class="p-4 border-r border-slate-100 bg-slate-50/30"></td>@endfor
                            </tr>
                            <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition">
                                <td class="p-4 border-r border-slate-100 font-bold text-slate-700 bg-slate-50/30">Room / Space</td>
                                @foreach($products as $product)
                                <td class="p-4 border-r border-slate-100 text-center text-slate-600 font-medium">{{ $product->room->name ?? 'N/A' }}</td>
                                @endforeach
                                @for($i = count($products); $i < 4; $i++)<td class="p-4 border-r border-slate-100 bg-slate-50/30"></td>@endfor
                            </tr>
                            <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition">
                                <td class="p-4 border-r border-slate-100 font-bold text-slate-700 bg-slate-50/30">Dimensions</td>
                                @foreach($products as $product)
                                <td class="p-4 border-r border-slate-100 text-center text-slate-600 font-medium">{{ $product->size ?: 'N/A' }}</td>
                                @endforeach
                                @for($i = count($products); $i < 4; $i++)<td class="p-4 border-r border-slate-100 bg-slate-50/30"></td>@endfor
                            </tr>
                            <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition">
                                <td class="p-4 border-r border-slate-100 font-bold text-slate-700 bg-slate-50/30">Finish</td>
                                @foreach($products as $product)
                                <td class="p-4 border-r border-slate-100 text-center text-slate-600 font-medium">{{ $product->finish ?: 'N/A' }}</td>
                                @endforeach
                                @for($i = count($products); $i < 4; $i++)<td class="p-4 border-r border-slate-100 bg-slate-50/30"></td>@endfor
                            </tr>
                            <tr class="border-b border-slate-100 hover:bg-slate-50/50 transition">
                                <td class="p-4 border-r border-slate-100 font-bold text-slate-700 bg-slate-50/30">Material</td>
                                @foreach($products as $product)
                                <td class="p-4 border-r border-slate-100 text-center text-slate-600 font-medium">{{ $product->material ?: 'N/A' }}</td>
                                @endforeach
                                @for($i = count($products); $i < 4; $i++)<td class="p-4 border-r border-slate-100 bg-slate-50/30"></td>@endfor
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4 border-r border-slate-100 font-bold text-slate-700 bg-slate-50/30">Availability</td>
                                @foreach($products as $product)
                                <td class="p-4 border-r border-slate-100 text-center">
                                    @if($product->stock > 0)
                                        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">In Stock</span>
                                    @else
                                        <span class="text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-md">Out of Stock</span>
                                    @endif
                                </td>
                                @endforeach
                                @for($i = count($products); $i < 4; $i++)<td class="p-4 border-r border-slate-100 bg-slate-50/30"></td>@endfor
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
