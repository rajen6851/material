<x-admin-layout>
    <x-slot name="title">Manage Blogs - Admin</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        
        <div class="flex justify-between items-center mb-8">
            <h1 class="font-serif-pristo text-3xl font-bold text-slate-900">Manage Blogs</h1>
            <a href="{{ route('admin.blogs.create') }}" class="bg-teal-700 hover:bg-teal-800 text-white font-bold px-6 py-2.5 rounded-xl text-sm transition">
                + Write New Blog
            </a>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-4 py-3 rounded-xl text-sm font-semibold mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white border border-slate-200 rounded-3xl overflow-hidden shadow-sm">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold border-b">
                    <tr>
                        <th class="px-6 py-4">Image</th>
                        <th class="px-6 py-4">Title</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($blogs as $blog)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            @if($blog->image)
                                <img src="{{ asset($blog->image) }}" class="w-16 h-12 object-cover rounded-md border">
                            @else
                                <div class="w-16 h-12 bg-slate-200 rounded-md border flex items-center justify-center text-[10px] text-slate-500">No Img</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-800">{{ $blog->title }}</td>
                        <td class="px-6 py-4">
                            @if($blog->is_published)
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-1 rounded-full uppercase">Published</span>
                            @else
                                <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase">Draft</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="text-teal-600 hover:text-teal-800 font-bold text-xs uppercase">Edit</a>
                            <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-xs uppercase">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-500">No blogs published yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
