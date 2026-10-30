<x-admin-layout>
    <x-slot name="title">Add Inspiration - Admin</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.inspirations.index') }}" class="text-slate-400 hover:text-teal-600">
                &larr; Back to Gallery
            </a>
            <h1 class="font-serif-pristo text-3xl font-bold text-slate-900">Add Gallery Project</h1>
        </div>

        <form action="{{ route('admin.inspirations.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Project Title</label>
                    <input type="text" name="title" required placeholder="e.g. The Indiranagar Sky Villa" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm font-semibold">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Location</label>
                    <input type="text" name="location" placeholder="e.g. Indiranagar, Bangalore" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Project Type</label>
                    <input type="text" name="type" placeholder="e.g. Luxury Villa" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Space Slug</label>
                    <input type="text" name="space" placeholder="e.g. bathroom, kitchen" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Space Name</label>
                    <input type="text" name="space_name" placeholder="e.g. Bathroom & Wellness" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Materials Used (One per line)</label>
                    <textarea name="materials" rows="5" placeholder="Italian Marble..." class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Project Image</label>
                    <input type="file" name="image" class="w-full border border-slate-300 rounded-xl p-2 text-sm">
                </div>
            </div>

            <div class="pt-4 border-t flex justify-end">
                <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white font-bold px-8 py-3 rounded-xl shadow-sm transition">
                    Save Project
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
