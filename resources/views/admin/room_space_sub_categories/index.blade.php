<x-admin-layout>
    <x-slot name="title">Room Space Sub Categories - Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-center border-b pb-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Room Space Sub Categories</h1>
                <p class="text-slate-500 text-sm">Manage all room space sub categories</p>
            </div>
            <a href="{{ route('admin.room-space-sub-categories.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 px-5 rounded-xl transition text-sm flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add New Sub Category
            </a>
        </div>

        @if($subCategories->count())
        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
            <h3 class="font-extrabold text-slate-900 text-lg border-b pb-3 mb-4">All Sub Categories</h3>

            <div class="overflow-x-auto text-xs">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-slate-50 text-slate-500 font-bold uppercase">
                            <th class="py-3 px-4">#</th>
                            <th class="py-3 px-4">Image</th>
                            <th class="py-3 px-4">Name</th>
                            <th class="py-3 px-4">Slug</th>
                            <th class="py-3 px-4">Description</th>
                            <th class="py-3 px-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($subCategories as $index => $sub)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-3 px-4 text-slate-400 font-mono">{{ $subCategories->firstItem() + $index }}</td>
                                <td class="py-3 px-4">
                                    @if($sub->image_path)
                                        <img src="{{ asset('storage/' . $sub->image_path) }}" alt="{{ $sub->name }}" class="w-10 h-10 object-cover border rounded bg-slate-50">
                                    @else
                                        <div class="w-10 h-10 bg-slate-100 border rounded flex items-center justify-center text-slate-400 text-[10px]">N/A</div>
                                    @endif
                                </td>
                                <td class="py-3 px-4 font-bold text-slate-800 text-sm">{{ $sub->name }}</td>
                                <td class="py-3 px-4 font-mono text-slate-400">{{ $sub->slug }}</td>
                                <td class="py-3 px-4 text-slate-500 max-w-xs truncate">{{ $sub->description }}</td>
                                <td class="py-3 px-4 text-right flex justify-end gap-2">
                                    <a href="{{ route('admin.room-space-sub-categories.edit', $sub->id) }}" class="bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-slate-700 font-bold px-3 py-1.5 rounded-lg transition">Edit</a>
                                    <form action="{{ route('admin.room-space-sub-categories.destroy', $sub->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this sub-category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold px-3 py-1.5 rounded-lg transition">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">{{ $subCategories->links() }}</div>
        </div>
        @else
        <div class="bg-white border border-slate-200 rounded-3xl p-12 shadow-sm text-center">
            <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h3 class="font-bold text-slate-700 text-lg mb-1">No Sub Categories Yet</h3>
            <p class="text-slate-400 text-sm mb-4">Click "Add New Sub Category" to create one.</p>
            <a href="{{ route('admin.room-space-sub-categories.create') }}" class="inline-block bg-teal-600 hover:bg-teal-700 text-white font-bold py-2 px-5 rounded-xl transition text-sm">+ Add New</a>
        </div>
        @endif
    </div>
</x-admin-layout>
