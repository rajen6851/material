<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'PRISTO | SPACES INSPIRED - Luxury Sanitaryware, Tiles & Kitchen' }}</title>

        <!-- Fonts: Playfair Display for luxury serif titles & Plus Jakarta Sans for body -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS & JS via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            :root {
                --color-tan: #c09b5a;
                --color-tan-dark: #a48043;
                --color-tan-light: #f5f0ea;
                --color-charcoal: #171615;
            }
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #faf8f5;
                color: #242220;
            }
            .font-serif-pristo {
                font-family: 'Playfair Display', Georgia, serif;
            }
            .bg-tan {
                background-color: #c09b5a;
            }
            .bg-tan:hover {
                background-color: #a48043;
            }
            .text-tan {
                color: #c09b5a;
            }
            .border-tan {
                border-color: #c09b5a;
            }
            .bg-warm-beige {
                background-color: #f4eeea;
            }
            .bg-dark-charcoal {
                background-color: #171615;
            }
        </style>
    </head>
    <body class="antialiased bg-[#faf8f5] text-[#242220] flex flex-col min-h-screen">
        @php
            $globalCategories = \App\Models\Category::all();
            $globalRooms = \App\Models\Room::all();
            
            // Calculate cart item count
            $cartCount = 0;
            if (auth()->check()) {
                $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
            } else {
                $cart = session()->get('cart', []);
                foreach ($cart as $item) {
                    $cartCount += $item['quantity'] ?? 0;
                }
            }
        @endphp

        <!-- Top Header & Announcement Wrapper -->
        <header class="bg-[#f7f4ef] border-b border-[#e8e4dc] sticky top-0 z-50 shadow-sm" x-data="{ open: false, categoryDropdown: false, roomDropdown: false, brandDropdown: false, userDropdown: false }">
            
            <!-- Top Announcement Bar -->
            <div class="bg-[#171615] text-[#d6d0c7] py-2 px-4 text-xs font-medium border-b border-[#2b2825]">
                <div class="max-w-[1500px] mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium tracking-wide text-[#e5dfd5]">📍 Premium Building &amp; Home Solutions | Bangalore</span>
                    </div>
                    <div class="flex items-center gap-6 text-xs text-[#a8a29e]">
                        <span>Expert Guidance</span>
                        <span class="text-[#44403c]">|</span>
                        <span>Free Design Consultation</span>
                        <span class="text-[#44403c]">|</span>
                        <span class="flex items-center gap-1.5 font-semibold text-white">
                            <svg class="w-3.5 h-3.5 text-[#c09b5a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +91 98765 43210
                        </span>
                    </div>
                </div>
            </div>

            <!-- Main Header Navigation Bar -->
            <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 py-3.5">
                <div class="flex justify-between items-center gap-6">
                    
                    <!-- Left: Pristo Logo -->
                    <a href="/" class="flex items-center gap-3 group flex-shrink-0 py-1">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="PRISTO ENTERPRISES Logo" class="h-11 w-auto object-contain rounded-md shadow-sm border border-[#e8e4dc]/80 group-hover:scale-105 transition duration-300">
                        <div class="flex flex-col">
                            <span class="font-serif-pristo font-bold text-xl lg:text-2xl tracking-[0.15em] text-[#171615] leading-none group-hover:text-[#c09b5a] transition">PRISTO</span>
                            <span class="text-[8px] uppercase tracking-[0.3em] font-bold text-[#78716c] mt-1">ENTERPRISES</span>
                        </div>
                    </a>
                    
                    <!-- Center: Navigation Links -->
                    <nav class="hidden lg:flex items-center gap-7 text-xs font-bold uppercase tracking-wider text-[#2b2825]">
                        <a href="/" class="hover:text-[#c09b5a] transition py-1 text-[#171615]">Home</a>
                        
                        <!-- Shop by Space Dropdown -->
                        <div class="relative">
                            <button @click="roomDropdown = !roomDropdown" @click.away="roomDropdown = false" class="hover:text-[#c09b5a] transition flex items-center gap-1 py-1">
                                Shop by Space
                                <svg class="w-3 h-3 text-[#78716c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="roomDropdown" class="absolute left-0 mt-2 w-52 bg-white border border-[#e8e4dc] rounded-xl shadow-xl py-2 z-50 text-xs tracking-normal font-medium capitalize" x-cloak>
                                @foreach($globalRooms as $room)
                                    <a href="/products?room={{ $room->slug }}" class="block px-4 py-2 hover:bg-[#f5f0ea] hover:text-[#c09b5a] transition">{{ $room->name }}</a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Brands Dropdown -->
                        <div class="relative">
                            <button @click="brandDropdown = !brandDropdown" @click.away="brandDropdown = false" class="hover:text-[#c09b5a] transition flex items-center gap-1 py-1">
                                Brands
                                <svg class="w-3 h-3 text-[#78716c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            <div x-show="brandDropdown" class="absolute left-0 mt-2 w-52 bg-white border border-[#e8e4dc] rounded-xl shadow-xl py-2 z-50 text-xs tracking-normal font-medium capitalize" x-cloak>
                                @foreach(\App\Models\Brand::all() as $br)
                                    <a href="/products?brand={{ $br->slug }}" class="block px-4 py-2 hover:bg-[#f5f0ea] hover:text-[#c09b5a] transition">{{ $br->name }}</a>
                                @endforeach
                            </div>
                        </div>

                        <a href="/products" class="hover:text-[#c09b5a] transition py-1">Inspiration</a>
                        <a href="/quotation-requests/create" class="hover:text-[#c09b5a] transition py-1">About Us</a>
                        <a href="/showroom-visit/book" class="hover:text-[#c09b5a] transition py-1">Contact</a>
                    </nav>

                    <!-- Right: Search bar & User/Cart Actions -->
                    <div class="flex items-center gap-4 flex-1 max-w-md justify-end">
                        
                        <!-- Search Bar -->
                        <form action="/products" method="GET" class="relative w-full max-w-xs hidden sm:block">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search for products, brands, spaces..." class="w-full pl-9 pr-4 py-2 bg-[#eae5dc] border border-[#dcd4c7] focus:border-[#c09b5a] focus:bg-white focus:outline-none rounded-full text-xs text-[#242220] placeholder-[#78716c] transition">
                            <button type="submit" class="absolute left-3 top-2.5 text-[#78716c] hover:text-[#c09b5a]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </form>

                        <!-- Action Icons -->
                        <div class="flex items-center gap-3">
                            <!-- Wishlist Icon -->
                            <a href="/products" class="text-[#171615] hover:text-[#c09b5a] transition p-1.5 rounded-full hover:bg-[#eae5dc]" title="Wishlist">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            </a>

                            @unless(auth()->check() && auth()->user()->isProfessional())
                                <!-- Cart Icon (Homeowners & Guests) -->
                                <a href="/cart" class="relative text-[#171615] hover:text-[#c09b5a] transition p-1.5 rounded-full hover:bg-[#eae5dc]" title="Shopping Cart">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                    <span class="absolute -top-1 -right-1 bg-[#171615] text-white rounded-full text-[9px] font-bold w-4 h-4 flex items-center justify-center">{{ $cartCount }}</span>
                                </a>
                            @else
                                <!-- Quotation Requests Icon (Professionals) -->
                                <a href="/quotation-requests/create" class="relative text-[#171615] hover:text-[#c09b5a] transition p-1.5 rounded-full hover:bg-[#eae5dc]" title="Request Quotation">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </a>
                            @endunless

                            <!-- User Profile -->
                            <div class="relative">
                                @auth
                                    <button @click="userDropdown = !userDropdown" @click.away="userDropdown = false" class="flex items-center gap-1.5 focus:outline-none p-1">
                                        <div class="w-7 h-7 bg-[#171615] text-white rounded-full flex items-center justify-center font-bold text-xs">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                    </button>
                                    <div x-show="userDropdown" class="absolute right-0 mt-2 w-52 bg-white border border-[#e8e4dc] rounded-xl shadow-xl py-2 z-50 text-xs font-medium" x-cloak>
                                        <div class="px-4 py-2 border-b bg-[#faf8f5]">
                                            <p class="font-semibold text-[#171615] leading-tight">{{ auth()->user()->name }}</p>
                                            <p class="text-[10px] text-[#8c857b] mt-0.5 capitalize">{{ auth()->user()->role }}</p>
                                        </div>
                                        @if(auth()->user()->isAdmin())
                                            <a href="/admin/dashboard" class="block px-4 py-2 text-[#242220] hover:bg-[#f5f0ea] hover:text-[#c09b5a] font-bold transition">Admin Panel</a>
                                        @endif
                                        <a href="/dashboard" class="block px-4 py-2 text-[#242220] hover:bg-[#f5f0ea] hover:text-[#c09b5a] transition">My Dashboard</a>
                                        <a href="/profile" class="block px-4 py-2 text-[#242220] hover:bg-[#f5f0ea] hover:text-[#c09b5a] transition">My Profile</a>
                                        <hr class="my-1 border-[#e8e4dc]">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition">Log Out</button>
                                        </form>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}" class="text-[#171615] hover:text-[#c09b5a] transition p-1.5 rounded-full hover:bg-[#eae5dc]" title="Account Login">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </a>
                                @endauth
                            </div>

                            <!-- Mobile Menu Button -->
                            <button @click="open = !open" class="lg:hidden text-[#171615] focus:outline-none">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="open" class="lg:hidden bg-white border-t border-[#e8e4dc] py-4 px-6 space-y-3 shadow-lg" x-cloak>
                <form action="/products" method="GET" class="relative mb-4">
                    <input type="text" name="search" placeholder="Search products..." class="w-full pl-4 pr-10 py-2 border rounded-full text-sm">
                    <button type="submit" class="absolute right-3 top-2.5 text-[#78716c]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
                <a href="/products" class="block font-semibold text-[#242220] py-1.5 border-b border-[#e8e4dc]">All Products</a>
                <div class="space-y-1.5 pt-2">
                    <p class="text-xs font-semibold uppercase text-[#8c857b] tracking-wider">Rooms</p>
                    @foreach($globalRooms as $room)
                        <a href="/products?room={{ $room->slug }}" class="block text-sm text-[#55504a] hover:text-[#c09b5a] pl-2">{{ $room->name }}</a>
                    @endforeach
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow">
            <!-- Flash Alerts -->
            @if(session('success'))
                <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-[#f5f0ea] border border-[#c09b5a] text-[#171615] px-4 py-3 rounded-xl flex items-center justify-between text-xs font-semibold">
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{ $slot }}
        </main>

        <!-- Pristo Footer -->
        <footer class="bg-[#171615] text-[#a39e97] pt-14 pb-8 border-t border-[#262422]">
            <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-10">
                
                <!-- Col 1: Brand Info -->
                <div class="space-y-4">
                    <a href="/" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.jpeg') }}" alt="PRISTO ENTERPRISES Logo" class="h-11 w-auto object-contain rounded-md border border-[#333]">
                        <div class="flex flex-col">
                            <span class="font-serif-pristo font-bold text-xl tracking-[0.18em] text-white">PRISTO</span>
                            <span class="text-[9px] uppercase tracking-[0.3em] font-medium text-[#c09b5a]">ENTERPRISES</span>
                        </div>
                    </a>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-xs text-[#a39e97]">
                        <li><a href="/" class="hover:text-white transition">Home</a></li>
                        <li><a href="/products" class="hover:text-white transition">Shop by Space</a></li>
                        <li><a href="/products" class="hover:text-white transition">Brands</a></li>
                        <li><a href="/products" class="hover:text-white transition">Inspiration</a></li>
                        <li><a href="/quotation-requests/create" class="hover:text-white transition">About Us</a></li>
                        <li><a href="/showroom-visit/book" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>

                <!-- Col 3: Customer Care -->
                <div>
                    <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-4">Customer Care</h4>
                    <ul class="space-y-2 text-xs text-[#a39e97]">
                        <li><a href="#" class="hover:text-white transition">FAQs</a></li>
                        <li><a href="#" class="hover:text-white transition">Shipping &amp; Delivery</a></li>
                        <li><a href="#" class="hover:text-white transition">Returns &amp; Replacements</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms &amp; Conditions</a></li>
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                    </ul>
                </div>

                <!-- Col 4: Newsletter -->
                <div class="space-y-3">
                    <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-2">Join our newsletter</h4>
                    <p class="text-xs text-[#8c857b]">Get the latest updates, special offers and design ideas.</p>
                    <form class="flex items-center gap-0 mt-3">
                        <input type="email" placeholder="Enter your email address" class="bg-[#242220] border border-[#363330] focus:border-[#c09b5a] text-white text-xs rounded-l-md px-3 py-2.5 w-full placeholder-[#78716c] focus:outline-none">
                        <button type="button" class="bg-[#c09b5a] hover:bg-[#a48043] text-white font-bold px-4 py-2.5 rounded-r-md transition text-xs flex items-center justify-center">
                            ➔
                        </button>
                    </form>
                    <div class="flex items-center gap-3 pt-2 text-[#a39e97]">
                        <a href="#" class="hover:text-[#c09b5a] transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>
                        <a href="#" class="hover:text-[#c09b5a] transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.592 0 9 1.583 9 4.615V8z"/></svg>
                        </a>
                        <a href="#" class="hover:text-[#c09b5a] transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        </a>
                    </div>
                </div>
            </div>

            <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-6 border-t border-[#242220] flex flex-col md:flex-row justify-between items-center text-[11px] text-[#78716c]">
                <p>© 2026 Pristo. All rights reserved.</p>
                <p class="italic">Better Space. A Brighter Tomorrow.</p>
            </div>
        </footer>
    </body>
</html>

