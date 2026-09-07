<x-admin-layout>
    <x-slot name="title">Manage Categories - Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            
            <!-- Left: Add Forms -->
            <div class="space-y-6 lg:sticky lg:top-8">
                <!-- Add Category -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-slate-900 text-lg border-b pb-3">Add Category</h3>
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Category Name</label>
                            <input type="text" name="name" required placeholder="e.g. Tiles, Sanitaryware" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Category Image</label>
                            <input type="file" name="image" class="w-full border-slate-200 text-xs p-2">
                        </div>
                        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-xl transition text-sm">Save Category</button>
                    </form>
                </div>

                <!-- Add Sub Category -->
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-slate-900 text-lg border-b pb-3">Add Sub Category</h3>
                    <form action="{{ route('admin.sub-categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Parent Category</label>
                            <select name="category_id" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sub Category Name</label>
                            <input type="text" name="name" required placeholder="e.g. Floor Tiles, Wash Basins" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Image (Optional)</label>
                            <input type="file" name="image" class="w-full border-slate-200 text-xs p-2">
                        </div>
                        <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-bold py-3 rounded-xl transition text-sm">Save Sub Category</button>
                    </form>
                </div>
            </div>

            <!-- Right: Categories + SubCategories List -->
            <div class="lg:col-span-2 space-y-6">
                @foreach($categories as $cat)
                <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                    <!-- Category Header -->
                    <div class="flex items-center justify-between border-b pb-3 mb-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset($cat->image) }}" alt="img" class="w-10 h-10 object-cover border rounded bg-slate-50">
                            <div>
                                <h3 class="font-extrabold text-slate-900 text-lg">{{ $cat->name }}</h3>
                                <span class="text-slate-400 text-[10px] font-mono">{{ $cat->slug }}</span>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.categories.edit', $cat->id) }}" class="bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-slate-700 font-bold px-3 py-1.5 rounded-lg transition text-xs">Edit</a>
                            <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" onsubmit="return confirm('Delete category \'{{ $cat->name }}\' and all its subcategories?');">
                                @csrf
                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold px-3 py-1.5 rounded-lg transition text-xs">Delete</button>
                            </form>
                        </div>
                    </div>

                    <!-- Sub Categories Table -->
                    @if($cat->subCategories->count())
                    <div class="overflow-x-auto text-xs">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b bg-slate-50 text-slate-500 font-bold uppercase">
                                    <th class="py-2 px-3">#</th>
                                    <th class="py-2 px-3">Sub Category</th>
                                    <th class="py-2 px-3">Slug</th>
                                    <th class="py-2 px-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($cat->subCategories as $idx => $sub)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-2 px-3 text-slate-400 font-mono">{{ $idx + 1 }}</td>
                                    <td class="py-2 px-3 font-bold text-slate-800 text-sm flex items-center gap-2">
                                        @if($sub->image)
                                            <img src="{{ asset($sub->image) }}" alt="" class="w-6 h-6 rounded border object-cover">
                                        @endif
                                        {{ $sub->name }}
                                    </td>
                                    <td class="py-2 px-3 font-mono text-slate-400">{{ $sub->slug }}</td>
                                    <td class="py-2 px-3 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.sub-categories.edit', $sub->id) }}" class="bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-slate-700 font-bold px-2 py-1 rounded-lg transition text-[10px]">Edit</a>
                                            <form action="{{ route('admin.sub-categories.delete', $sub->id) }}" method="POST" onsubmit="return confirm('Delete sub category?');">
                                                @csrf
                                                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold px-2 py-1 rounded-lg transition text-[10px]">Del</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-slate-400 text-xs text-center py-3">No sub categories yet.</p>
                    @endif
                </div>
                @endforeach
            </div>

        </div>
    </div>
</x-admin-layout>
