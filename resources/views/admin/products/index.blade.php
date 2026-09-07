<x-admin-layout>
    <x-slot name="title">Manage Products - Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Products Inventory</h1>
                <p class="text-slate-500 text-sm">Manage tiles, sanitary, faucets, and spec variants.</p>
            </div>
            <a href="{{ route('admin.products.create') }}" class="bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-sm transition">
                Add Product
            </a>
        </div>

        <div class="bg-white border rounded-2xl overflow-hidden shadow-sm">
            @if($products->isEmpty())
                <p class="text-center py-12 text-slate-400">No products found. Click Add Product to seed the inventory.</p>
            @else
                <div class="overflow-x-auto text-xs">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-slate-50 text-slate-500 font-bold uppercase">
                                <th class="py-3.5 px-6">Product Info</th>
                                <th class="py-3.5 px-6">SKU</th>
                                <th class="py-3.5 px-6">Category/Room</th>
                                <th class="py-3.5 px-6">Price / Stock</th>
                                <th class="py-3.5 px-6">Specs (Variants)</th>
                                <th class="py-3.5 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($products as $prod)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-3 px-6 flex items-center gap-3">
                                        <img src="{{ asset($prod->featured_image) }}" alt="img" class="w-10 h-10 object-contain border rounded p-1 bg-slate-50">
                                        <span class="font-bold text-slate-800 text-sm">{{ $prod->name }}</span>
                                    </td>
                                    <td class="py-3 px-6 font-mono font-bold">{{ $prod->sku }}</td>
                                    <td class="py-3 px-6">
                                        <span class="block text-slate-800 font-semibold">{{ $prod->category->name }}</span>
                                        <span class="block text-slate-400">{{ $prod->room->name }}</span>
                                    </td>
                                    <td class="py-3 px-6">
                                        <span class="block text-slate-800 font-bold">₹{{ number_format($prod->price, 2) }}</span>
                                        <span class="block text-slate-400">Stock: {{ $prod->stock }}</span>
                                    </td>
                                    <td class="py-3 px-6 text-[10px] text-slate-500 space-y-0.5">
                                        <p>Size: {{ $prod->size }}</p>
                                        <p>Finish: {{ $prod->finish }}</p>
                                        <p>Material: {{ $prod->material }}</p>
                                    </td>
                                    <td class="py-3 px-6 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.products.edit', $prod->id) }}" class="bg-slate-100 hover:bg-teal-50 hover:text-teal-600 text-slate-700 font-bold px-3 py-1.5 rounded-lg transition">Edit</a>
                                            <form action="{{ route('admin.products.delete', $prod->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold px-3 py-1.5 rounded-lg transition">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
