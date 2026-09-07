<x-admin-layout>
    <x-slot name="title">Add Room Space Sub Category - Admin</x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex justify-between items-center border-b pb-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900">Add Sub Category</h1>
                <p class="text-slate-500 text-sm">Create a new room space sub category</p>
            </div>
            <a href="{{ route('admin.room-space-sub-categories.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-2.5 px-5 rounded-xl transition text-sm">&larr; Back to List</a>
        </div>

        <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-6">
            <form action="{{ route('admin.room-space-sub-categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Sub Category Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Living Room, Bedroom" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Description</label>
                    <textarea name="description" rows="4" placeholder="Optional description..." class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">{{ old('description') }}</textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full border-slate-200 text-xs p-2">
                    @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-xl transition text-sm">Save Sub Category</button>
            </form>
        </div>
    </div>
</x-admin-layout>
