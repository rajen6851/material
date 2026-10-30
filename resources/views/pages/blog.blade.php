<x-app-layout>
    <x-slot name="title">Blog & Insights - Pristo Enterprises</x-slot>

    <!-- Hero Header -->
    <div class="bg-[#171615] text-[#f7f4ef] py-14 md:py-20 border-b border-[#2b2825]">
        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-[#a39e97] text-xs gap-2 items-center mb-4">
                <a href="/" class="hover:text-[#c09b5a] transition">Home</a>
                <span>/</span>
                <span class="text-[#c09b5a] font-semibold">Blog</span>
            </nav>

            <div class="max-w-3xl space-y-3">
                <span class="text-[10px] uppercase font-bold tracking-[0.28em] text-[#c09b5a] block">INSPIRATION & TRENDS</span>
                <h1 class="font-serif-pristo text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight leading-tight">
                    Architectural Journal
                </h1>
                <p class="text-xs sm:text-sm text-[#a39e97] leading-relaxed pt-1">
                    Discover the latest trends in luxury sanitaryware, modern kitchen design, and premium tiling.
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        
        @if($blogs->isEmpty())
            <div class="text-center py-20 bg-white border border-[#ded7cd] rounded-3xl shadow-xs">
                <span class="text-4xl block mb-4">📝</span>
                <h2 class="font-serif-pristo text-2xl font-bold text-[#171615] mb-2">Articles Coming Soon</h2>
                <p class="text-[#78716c] text-sm">Our editorial team is preparing high-quality insights for you. Please check back later.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($blogs as $blog)
                <div class="bg-white border border-[#ded7cd] rounded-3xl overflow-hidden shadow-xs hover:shadow-lg transition group">
                    <a href="{{ route('blog.show', $blog->slug) }}" class="block relative aspect-video overflow-hidden bg-[#faf8f5]">
                        @if($blog->image)
                            <img src="{{ asset($blog->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-[#c09b5a] text-opacity-30">
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                            </div>
                        @endif
                    </a>
                    <div class="p-6">
                        <div class="text-[10px] text-[#c09b5a] font-bold uppercase tracking-widest mb-2">{{ $blog->created_at->format('M d, Y') }}</div>
                        <h3 class="font-serif-pristo text-xl font-bold text-[#171615] mb-3 line-clamp-2">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="hover:text-[#c09b5a] transition">{{ $blog->title }}</a>
                        </h3>
                        <p class="text-sm text-[#78716c] line-clamp-3 mb-4">
                            {{ Str::limit(strip_tags($blog->content), 120) }}
                        </p>
                        <a href="{{ route('blog.show', $blog->slug) }}" class="text-xs font-bold text-[#171615] uppercase tracking-widest hover:text-[#c09b5a] transition flex items-center gap-2">
                            Read Article <span>&rarr;</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $blogs->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
