<x-admin-layout>
    <x-slot name="title">Manage Brands - Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Brands Manager</h1>
                <p class="text-slate-500 text-sm">Create and manage the brands shown across the storefront.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            <!-- Left: Add Brand Form -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4 lg:sticky lg:top-8">
                <h3 class="font-extrabold text-slate-900 text-lg border-b pb-3">Add New Brand</h3>

                <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Brand Name</label>
                        <input type="text" name="name" required placeholder="e.g. Kajaria" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Brand Logo</label>
                        <input type="file" name="logo" class="w-full border-slate-200 text-xs p-2">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Description</label>
                        <textarea name="description" rows="3" placeholder="Short description..." class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-xl transition text-sm">Save Brand</button>
                </form>
            </div>

            <!-- Right: Brands List -->
            <div class="lg:col-span-2 bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                <h3 class="font-extrabold text-slate-900 text-lg border-b pb-3 mb-4">All Brands</h3>

                @if($brands->isEmpty())
                    <p class="text-center py-12 text-slate-400 text-sm">No brands yet. Add your first brand to get started.</p>
                @else
                    <div class="overflow-x-auto text-xs">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b bg-slate-50 text-slate-500 font-bold uppercase">
                                    <th class="py-3 px-4">Brand</th>
                                    <th class="py-3 px-4">Slug</th>
                                    <th class="py-3 px-4">Products</th>
                                    <th class="py-3 px-4 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($brands as $brand)
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-3">
                                                @if($brand->logo)
                                                    <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}" class="w-10 h-10 object-contain border rounded p-1 bg-white">
                                                @else
                                                    <div class="w-10 h-10 rounded bg-slate-100 flex items-center justify-center font-black text-slate-400">{{ strtoupper(substr($brand->name, 0, 1)) }}</div>
                                                @endif
                                                <div>
                                                    <span class="font-bold text-slate-800 text-sm block">{{ $brand->name }}</span>
                                                    @if($brand->description)
                                                        <span class="text-slate-400 text-[10px]">{{ \Illuminate\Support\Str::limit($brand->description, 50) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 font-mono text-slate-400">{{ $brand->slug }}</td>
                                        <td class="py-3 px-4">
                                            <span class="bg-teal-50 text-teal-700 font-bold px-2.5 py-1 rounded-full text-[10px]">{{ $brand->products_count }} products</span>
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('admin.brands.edit', $brand->id) }}" class="bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-slate-700 font-bold px-3 py-1.5 rounded-lg transition">Edit</a>
                                                <form action="{{ route('admin.brands.delete', $brand->id) }}" method="POST" onsubmit="return confirm('Delete brand \'{{ $brand->name }}\'?');">
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
    </div>
</x-admin-layout>