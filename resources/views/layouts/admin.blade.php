<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Admin Command Center - BuildMart' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS & JS via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased bg-slate-50 text-slate-800 min-h-screen flex flex-col">

        <!-- Top Minimal Admin Header -->
        <header class="bg-[#0d2238] text-white py-3 px-8 flex justify-between items-center shadow-md z-30 relative border-b border-slate-800">
            <div class="flex items-center gap-2">
                <span class="w-8 h-8 bg-teal-600 rounded-lg flex items-center justify-center text-white font-extrabold text-base shadow-sm">M</span>
                <span class="font-black text-lg tracking-tight">Material<span class="text-teal-500">Deck</span> <span class="text-xs bg-[#1e344d] text-teal-400 px-2 py-0.5 rounded font-bold uppercase ml-2">Admin Panel</span></span>
            </div>
            
            <div class="flex items-center gap-4 text-xs font-semibold">
                <a href="/" class="text-slate-300 hover:text-teal-400 transition">View Storefront</a>
                <span class="h-4 w-px bg-slate-700"></span>
                <span class="text-slate-300">Admin: <strong class="text-white">{{ auth()->user()->name }}</strong></span>
            </div>
        </header>

        <!-- Sidebar + Content Wrapper -->
        <div class="flex flex-col lg:flex-row flex-grow relative z-20">
            
            <!-- Left Sticky Sidebar (Exactly as mockup menu) -->
            <aside class="w-full lg:w-72 bg-[#0d2238] text-slate-300 flex flex-col justify-between p-6 border-r border-slate-800 min-h-screen lg:sticky lg:top-0">
                <div class="space-y-6">
                    <!-- Title -->
                    <div class="pb-3 border-b border-slate-800">
                        <span class="text-white font-extrabold text-sm uppercase tracking-wider block">Admin Command Center</span>
                    </div>

                    <!-- Navigation Items -->
                    <nav class="space-y-1 font-semibold text-xs text-slate-300">
                        <a href="/admin/dashboard" class="w-full py-2.5 rounded-xl pl-4 transition flex items-center gap-3 {{ request()->is('admin/dashboard') ? 'bg-teal-700/30 text-white border-l-4 border-teal-500 pl-3 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            <span>Dashboard View</span>
                        </a>

                        <!-- Catalog Manager Section -->
                        <div class="space-y-0.5 pt-3">
                            <span class="text-slate-500 text-[10px] uppercase font-bold tracking-wider pl-4 block mb-1">Catalog Management</span>
                            <a href="/admin/products" class="w-full py-2 pl-8 rounded-lg transition flex items-center gap-2 {{ request()->is('admin/products*') ? 'text-teal-400 font-bold bg-slate-800/50' : 'text-slate-300 hover:text-white hover:bg-slate-800/30' }}">
                                <span>&bull; Product Manager (CRUD)</span>
                            </a>
                            <a href="/admin/categories" class="w-full py-2 pl-8 rounded-lg transition flex items-center gap-2 {{ request()->is('admin/categories*') ? 'text-teal-400 font-bold bg-slate-800/50' : 'text-slate-300 hover:text-white hover:bg-slate-800/30' }}">
                                <span>&bull; Categories list</span>
                            </a>
                            <a href="/admin/banners" class="w-full py-2 pl-8 rounded-lg transition flex items-center gap-2 {{ request()->is('admin/banners*') ? 'text-teal-400 font-bold bg-slate-800/50' : 'text-slate-300 hover:text-white hover:bg-slate-800/30' }}"><span>&bull; Banner sliders</span></a>
                            <a href="/admin/room-spaces" class="w-full py-2 pl-8 rounded-lg transition flex items-center gap-2 {{ request()->is('admin/room-spaces*') ? 'text-teal-400 font-bold bg-slate-800/50' : 'text-slate-300 hover:text-white hover:bg-slate-800/30' }}"><span>&bull; Room Space</span></a>
                            <a href="/admin/product-attributes" class="w-full py-2 pl-8 rounded-lg transition flex items-center gap-2 {{ request()->is('admin/product-attributes*') ? 'text-teal-400 font-bold bg-slate-800/50' : 'text-slate-300 hover:text-white hover:bg-slate-800/30' }}"><span>&bull; Variant Options</span></a>
                            <a href="/admin/brands" class="w-full py-2 pl-8 rounded-lg transition flex items-center gap-2 {{ request()->is('admin/brands*') ? 'text-teal-400 font-bold bg-slate-800/50' : 'text-slate-300 hover:text-white hover:bg-slate-800/30' }}"><span>&bull; Brands</span></a>
                        </div>

                        <!-- Orders Fulfillment -->
                        <div class="space-y-0.5 pt-3">
                            <span class="text-slate-500 text-[10px] uppercase font-bold tracking-wider pl-4 block mb-1">Order Fulfillment</span>
                            <a href="/admin/orders" class="w-full py-2.5 rounded-xl pl-4 transition flex items-center gap-3 {{ request()->is('admin/orders*') ? 'bg-teal-700/30 text-white border-l-4 border-teal-500 pl-3 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                <span>Fulfillment Queue</span>
                            </a>
                        </div>

                        <!-- Quotations Desk -->
                        <div class="pt-3">
                            <a href="/admin/quotations" class="w-full py-2.5 rounded-xl pl-4 transition flex items-center gap-3 {{ request()->is('admin/quotations*') ? 'bg-teal-700/30 text-white border-l-4 border-teal-500 pl-3 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span>Quotations Desk</span>
                            </a>
                        </div>

                        <!-- Showroom Visits -->
                        <div class="pt-2">
                            <a href="/admin/visits" class="w-full py-2.5 rounded-xl pl-4 transition flex items-center gap-3 {{ request()->is('admin/visits*') ? 'bg-teal-700/30 text-white border-l-4 border-teal-500 pl-3 font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span>Showroom Visits</span>
                            </a>
                        </div>

                        <!-- System metrics labels -->
                        <div class="text-slate-500 text-[10px] uppercase font-bold tracking-wider pl-4 pt-5 block space-y-1">
                            <span class="block text-slate-500">System Admin</span>
                            <a href="/admin/coupons" class="block py-1.5 {{ request()->is('admin/coupons*') ? 'text-teal-400' : 'text-slate-400' }} hover:text-white transition">Coupons &amp; Promos</a>
                            <span class="block py-1.5 text-slate-400 hover:text-white transition cursor-pointer">Website Settings</span>
                            <span class="block py-1.5 text-slate-400 hover:text-white transition cursor-pointer">Reports &amp; Analytics</span>
                            <span class="block py-1.5 text-slate-400 hover:text-white transition cursor-pointer">SEO Tools</span>
                            <span class="block py-1.5 text-slate-400 hover:text-white transition cursor-pointer">User Roles (Verify)</span>
                        </div>
                    </nav>
                </div>

                <!-- Bottom Logout -->
                <form method="POST" action="{{ route('logout') }}" class="pt-4 border-t border-slate-800">
                    @csrf
                    <button type="submit" class="w-full text-left pl-4 py-2.5 rounded-xl hover:bg-red-950/40 hover:text-red-400 transition text-xs flex items-center gap-3 font-semibold text-red-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Logout Panel</span>
                    </button>
                </form>
            </aside>

            <!-- Right Workspace Pane -->
            <main class="flex-grow p-6 md:p-8 bg-slate-50 min-h-screen">
                <!-- Flash Alerts inside child container -->
                @if(session('success'))
                    <div class="bg-teal-50 border border-teal-200 text-teal-800 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm text-xs font-semibold mb-6">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm text-xs font-semibold mb-6">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                {{ $slot }}
            </main>

        </div>

        <!-- Footer -->
        <footer class="bg-slate-900 text-slate-500 py-6 text-center text-xs border-t border-slate-800 z-30 relative">
            <p>&copy; {{ date('Y') }} MaterialDeck Admin Dashboard. Confidential.</p>
        </footer>
    </body>
</html>
