<x-app-layout>
    <x-slot name="title">{{ $blog->meta_title ?? $blog->title }} - Pristo</x-slot>
    <x-slot name="meta_description">{{ $blog->meta_description }}</x-slot>

    <!-- Hero Header -->
    <div class="bg-[#171615] text-[#f7f4ef] py-14 md:py-20 border-b border-[#2b2825]">
        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-[#a39e97] text-xs gap-2 items-center mb-4">
                <a href="/" class="hover:text-[#c09b5a] transition">Home</a>
                <span>/</span>
                <a href="{{ route('blog') }}" class="hover:text-[#c09b5a] transition">Blog</a>
                <span>/</span>
                <span class="text-[#c09b5a] font-semibold truncate max-w-[200px]">{{ $blog->title }}</span>
            </nav>

            <div class="max-w-4xl space-y-4">
                <span class="text-[10px] uppercase font-bold tracking-[0.28em] text-[#c09b5a] block">PRISTO JOURNAL &bull; {{ $blog->created_at->format('M d, Y') }}</span>
                <h1 class="font-serif-pristo text-3xl sm:text-4xl md:text-5xl font-bold text-white tracking-tight leading-tight">
                    {{ $blog->title }}
                </h1>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-[900px] mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16">
        
        @if($blog->image)
            <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="w-full rounded-3xl shadow-sm mb-12 border border-[#ded7cd]">
        @endif

        <article class="prose prose-sm sm:prose-base max-w-none text-[#55504a] leading-relaxed space-y-6">
            {!! $blog->content !!}
        </article>

        <div class="mt-16 pt-8 border-t border-[#f0ebe3] flex justify-between items-center">
            <a href="{{ route('blog') }}" class="text-[#c09b5a] font-bold text-sm hover:underline">
                &larr; Back to all articles
            </a>
            <div class="flex gap-4">
                <!-- Social Share Links -->
                <span class="text-xs text-[#a39e97] font-bold uppercase tracking-widest mt-1">Share</span>
                <a href="#" class="w-8 h-8 rounded-full bg-[#f0ebe3] flex items-center justify-center text-[#171615] hover:bg-[#c09b5a] hover:text-white transition">IN</a>
                <a href="#" class="w-8 h-8 rounded-full bg-[#f0ebe3] flex items-center justify-center text-[#171615] hover:bg-[#c09b5a] hover:text-white transition">FB</a>
            </div>
        </div>
    </div>
</x-app-layout>
