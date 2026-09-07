<x-admin-layout>
    <x-slot name="title">Manage Banners - Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            
            <!-- Left: Add Banner Form -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm space-y-4">
                <h3 class="font-extrabold text-slate-900 text-lg border-b pb-3">Add Banner Slider</h3>
                
                <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Banner Title</label>
                        <input type="text" name="title" required placeholder="e.g. Luxury Tiles up to 40% Off" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Subtitle</label>
                        <input type="text" name="subtitle" placeholder="e.g. Best price vitrified slabs" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Action Link</label>
                        <input type="text" name="link" placeholder="e.g. /products?category=tiles" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl text-sm p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Banner Image</label>
                        <input type="file" name="image" required class="w-full border-slate-200 text-xs p-2">
                    </div>
                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-xl transition text-sm">Save Banner</button>
                </form>
            </div>

            <!-- Right: Banners List -->
            <div class="lg:col-span-2 bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
                <h3 class="font-extrabold text-slate-900 text-lg border-b pb-3 mb-4">Homepage Banner Sliders</h3>
                
                <div class="overflow-x-auto text-xs">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-slate-50 text-slate-500 font-bold uppercase">
                                <th class="py-3 px-4">Banner Image</th>
                                <th class="py-3 px-4">Title / Subtitle</th>
                                <th class="py-3 px-4">Redirect Link</th>
                                <th class="py-3 px-4 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @foreach($banners as $banner)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-3 px-4">
                                        <img src="{{ asset($banner->image) }}" alt="img" class="w-20 h-12 object-cover border rounded bg-slate-50">
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="font-bold text-slate-800 text-sm block">{{ $banner->title }}</span>
                                        <span class="text-slate-400 block mt-0.5">{{ $banner->subtitle }}</span>
                                    </td>
                                    <td class="py-3 px-4 font-mono text-slate-500">{{ $banner->link }}</td>
                                    <td class="py-3 px-4 text-right flex justify-end gap-2">
                                        <a href="{{ route('admin.banners.edit', $banner->id) }}" class="bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-slate-700 font-bold px-3 py-1.5 rounded-lg transition">Edit</a>
                                        <form action="{{ route('admin.banners.delete', $banner->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                            @csrf
                                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 font-bold px-3 py-1.5 rounded-lg transition">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
