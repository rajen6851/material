<x-admin-layout>
    <x-slot name="title">Edit Category - Admin</x-slot>

    <div class="max-w-2xl mx-auto py-16">
        <div class="bg-white border border-slate-200 rounded-3xl p-6 md:p-8 shadow-sm space-y-6">
            <div class="border-b pb-4">
                <h1 class="text-2xl font-black text-slate-900">Edit Category</h1>
                <p class="text-slate-500 text-sm">Update the name or upload a new category thumbnail.</p>
            </div>

            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Category Name</label>
                    <input type="text" name="name" value="{{ $category->name }}" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Upload New Image (Optional)</label>
                    <input type="file" name="image" class="w-full border-slate-200 text-xs p-2">
                </div>

                <div class="pt-4 flex gap-4 border-t">
                    <a href="{{ route('admin.categories') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold py-3.5 rounded-xl text-center text-sm transition">Cancel</a>
                    <button type="submit" class="flex-grow bg-teal-600 hover:bg-teal-700 text-white font-bold py-3.5 rounded-xl shadow-md transition text-sm">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
