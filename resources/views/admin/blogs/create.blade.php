<x-admin-layout>
    <x-slot name="title">Write Blog - Admin</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('admin.blogs.index') }}" class="text-slate-400 hover:text-teal-600">
                &larr; Back to Blogs
            </a>
            <h1 class="font-serif-pristo text-3xl font-bold text-slate-900">Write New Blog</h1>
        </div>

        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-3xl p-8 shadow-sm space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Blog Title</label>
                    <input type="text" name="title" required class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm font-semibold">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Featured Image</label>
                    <input type="file" name="image" class="w-full border border-slate-300 rounded-xl p-2 text-sm">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Content (HTML supported)</label>
                    <textarea name="content" required rows="10" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">SEO Meta Title</label>
                    <input type="text" name="meta_title" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">SEO Meta Description</label>
                    <input type="text" name="meta_description" class="w-full border-slate-300 focus:border-teal-500 focus:ring-0 rounded-xl p-3 text-sm">
                </div>
            </div>

            <div class="pt-4 border-t flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm font-bold text-slate-700 cursor-pointer">
                    <input type="checkbox" name="is_published" value="1" checked class="rounded border-slate-300 text-teal-600 focus:ring-0 w-5 h-5">
                    Publish Immediately
                </label>
                
                <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white font-bold px-8 py-3 rounded-xl shadow-sm transition">
                    Save Blog
                </button>
            </div>
        </form>

    </div>
</x-admin-layout>
