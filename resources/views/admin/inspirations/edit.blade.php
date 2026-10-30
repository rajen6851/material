<x-admin-layout>
    <x-slot name="title">Edit Inspiration - Admin</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.inspirations.index') }}" class="text-slate-400 hover:text-teal-600">
                &larr; Back to Gallery
            </a>
            <h1 class="font-serif-pristo text-3xl font-bold text-slate-900">Edit Gallery Project</h1>
        </div>

        <form action="{{ route('admin.inspirations.update', $inspiration->id) }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Project Title</label>
                    <input type="text" name="title" value="{{ $inspiration->title }}" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Location</label>
                    <input type="text" name="location" value="{{ $inspiration->location }}" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Project Type</label>
                    <input type="text" name="type" value="{{ $inspiration->type }}" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Space Slug</label>
                    <input type="text" name="space" value="{{ $inspiration->space }}" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Space Name</label>
                    <input type="text" name="space_name" value="{{ $inspiration->space_name }}" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm">{{ $inspiration->description }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Materials Used (One per line)</label>
                    <textarea name="materials" rows="5" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm">{{ is_array($inspiration->materials) ? implode("\n", $inspiration->materials) : '' }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Project Image</label>
                    @if($inspiration->image)
                        <img src="{{ asset($inspiration->image) }}" class="h-20 mb-2 rounded border">
                    @endif
                    <input type="file" name="image" class="w-full border border-slate-300 rounded-xl p-2 text-sm">
                </div>
            </div>

            <div class="pt-4 border-t flex justify-end">
                <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white font-bold px-8 py-3 rounded-xl shadow-sm transition">
                    Update Project
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
