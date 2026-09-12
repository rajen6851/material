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
                    <div class="flex items-center gap-4 sm:gap-6 text-xs text-[#a8a29e]">
                        <a href="/showroom-visit/book" class="hover:text-white transition flex items-center gap-1.5 text-[#e5dfd5] font-semibold">
                            <span class="text-[#c09b5a]">📍</span>
                            <span>Book Showroom Visit (User & B2B)</span>
                        </a>
                        <span class="text-[#44403c] hidden sm:inline">|</span>
                        <a href="mailto:pristoenterprises@gmail.com" class="hover:text-[#c09b5a] transition flex items-center gap-1.5 text-[#d6d0c7]">
                            <svg class="w-3.5 h-3.5 text-[#c09b5a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>pristoenterprises@gmail.com</span>
                        </a>
                        <span class="text-[#44403c]">|</span>
                        <a href="tel:+916362346660" class="flex items-center gap-1.5 font-semibold text-white hover:text-[#c09b5a] transition">
                            <svg class="w-3.5 h-3.5 text-[#c09b5a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>+91 63623 46660</span>
                        </a>
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
                                    <a href="{{ route('rooms.show', $room->slug) }}" class="block px-4 py-2 hover:bg-[#f5f0ea] hover:text-[#c09b5a] transition">{{ $room->name }}</a>
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

                        <a href="/inspiration" class="hover:text-[#c09b5a] transition py-1">Inspiration</a>
                        <a href="/showroom-visit/book" class="text-[#c09b5a] hover:text-[#171615] transition py-1 flex items-center gap-1">
                            <span>Visit Showroom</span>
                        </a>
                        <a href="/about" class="hover:text-[#c09b5a] transition py-1">About Us</a>
                        <a href="/contact" class="hover:text-[#c09b5a] transition py-1">Contact</a>
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
                <a href="/inspiration" class="block font-semibold text-[#242220] py-1.5 border-b border-[#e8e4dc]">Work Gallery &amp; Inspiration</a>
                <a href="/about" class="block font-semibold text-[#242220] py-1.5 border-b border-[#e8e4dc]">About Us</a>
                <a href="/contact" class="block font-semibold text-[#242220] py-1.5 border-b border-[#e8e4dc]">Contact &amp; Support</a>
                <a href="/showroom-visit/book" class="block font-semibold text-[#c09b5a] py-1.5 border-b border-[#e8e4dc]">Book Showroom Visit</a>
                <div class="space-y-1.5 pt-2">
                    <p class="text-xs font-semibold uppercase text-[#8c857b] tracking-wider">Rooms</p>
                    @foreach($globalRooms as $room)
                        <a href="{{ route('rooms.show', $room->slug) }}" class="block text-sm text-[#55504a] hover:text-[#c09b5a] pl-2">{{ $room->name }}</a>
                    @endforeach
                </div>
                <div class="pt-3 border-t border-[#e8e4dc] space-y-2">
                    <a href="tel:+916362346660" class="flex items-center gap-2 text-sm font-semibold text-[#171615] hover:text-[#c09b5a]">
                        <svg class="w-4 h-4 text-[#c09b5a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                        <span>+91 63623 46660</span>
                    </a>
                    <a href="mailto:pristoenterprises@gmail.com" class="flex items-center gap-2 text-xs text-[#55504a] hover:text-[#c09b5a]">
                        <svg class="w-4 h-4 text-[#c09b5a]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        <span>pristoenterprises@gmail.com</span>
                    </a>
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
                    <div class="space-y-2.5 text-xs text-[#a39e97] pt-2">
                        <p class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-[#c09b5a] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <a href="tel:+916362346660" class="hover:text-white transition font-medium">+91 63623 46660</a>
                        </p>
                        <p class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-[#c09b5a] flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <a href="mailto:pristoenterprises@gmail.com" class="hover:text-white transition">pristoenterprises@gmail.com</a>
                        </p>
                        <p class="flex items-start gap-2.5 pt-1 text-[11px] text-[#78716c]">
                            <svg class="w-4 h-4 text-[#c09b5a] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Bangalore, Karnataka</span>
                        </p>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-xs text-[#a39e97]">
                        <li><a href="/" class="hover:text-white transition">Home</a></li>
                        <li><a href="/products" class="hover:text-white transition">Shop by Space</a></li>
                        <li><a href="/inspiration" class="hover:text-white transition">Work Gallery &amp; Inspiration</a></li>
                        <li><a href="/about" class="hover:text-white transition">About Pristo</a></li>
                        <li><a href="/contact" class="hover:text-white transition">Contact &amp; Support</a></li>
                        <li><a href="/showroom-visit/book" class="hover:text-white transition">Book Showroom Visit</a></li>
                        <li><a href="/quotation-requests/create" class="hover:text-white transition">Request Quotation</a></li>
                    </ul>
                </div>

                <!-- Col 3: Customer Care -->
                <div>
                    <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-4">Customer Care</h4>
                    <ul class="space-y-2 text-xs text-[#a39e97]">
                        <li><a href="/terms-conditions" class="hover:text-white transition">Terms &amp; Conditions</a></li>
                        <li><a href="/terms-conditions#shipping" class="hover:text-white transition">Shipping Policy (Charges Applicable)</a></li>
                        <li><a href="/terms-conditions#breakage" class="hover:text-white transition">Transit Damage &amp; Inspection</a></li>
                        <li><a href="/terms-conditions#returns" class="hover:text-white transition">Returns &amp; Replacements</a></li>
                        <li><a href="/contact" class="hover:text-white transition">Contact Customer Care</a></li>
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

    {{-- ============================================================
         FLOATING BOTTOM WIDGETS — inline styles, no Tailwind needed
         ============================================================ --}}
    <style>
        @keyframes wa-ripple {
            0%   { box-shadow: 0 0 0 0 rgba(37,211,102,0.55); }
            70%  { box-shadow: 0 0 0 20px rgba(37,211,102,0); }
            100% { box-shadow: 0 0 0 0 rgba(37,211,102,0); }
        }
        @keyframes slideUpFade {
            from { opacity:0; transform: translateY(16px) scale(.96); }
            to   { opacity:1; transform: translateY(0)    scale(1); }
        }
        .wa-fab { animation: wa-ripple 2.2s ease-out infinite; }
        .wa-card-open { animation: slideUpFade .28s cubic-bezier(.25,.8,.25,1) forwards; }
        #pristoBackTop {
            opacity: 0; pointer-events: none;
            transition: opacity .3s ease, transform .3s ease;
            transform: translateY(8px);
        }
        #pristoBackTop.btt-show { opacity:1; pointer-events:auto; transform:translateY(0); }
    </style>

    <!-- ── WIDGET STACK ── fixed bottom-right, pure inline styles ── -->
    <div style="position:fixed;bottom:24px;right:20px;z-index:99999;display:flex;flex-direction:column;align-items:flex-end;gap:10px;">

        <!-- Back to Top -->
        <button id="pristoBackTop"
                onclick="window.scrollTo({top:0,behavior:'smooth'})"
                title="Back to Top"
                style="width:40px;height:40px;border-radius:50%;background:#fff;border:1.5px solid #ded7cd;box-shadow:0 4px 16px rgba(0,0,0,.12);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .3s ease;">
            <svg width="16" height="16" fill="none" stroke="#555" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
            </svg>
        </button>

        <!-- Call Button -->
        <a href="tel:+916362346660"
           title="Call Us"
           style="width:40px;height:40px;border-radius:50%;background:#171615;box-shadow:0 4px 16px rgba(0,0,0,.2);display:flex;align-items:center;justify-content:center;text-decoration:none;transition:transform .2s ease;">
            <svg width="18" height="18" fill="#fff" viewBox="0 0 24 24">
                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
            </svg>
        </a>

        <!-- WhatsApp -->
        <div style="position:relative;">

            <!-- Popup Card -->
            <div id="pristoWaCard"
                 style="display:none;position:absolute;bottom:64px;right:0;width:288px;background:#fff;border-radius:16px;box-shadow:0 8px 40px rgba(0,0,0,.18);overflow:hidden;border:1px solid #e5e7eb;">
                <!-- Header -->
                <div style="background:linear-gradient(135deg,#25d366,#128C7E);padding:14px 16px;display:flex;align-items:center;gap:12px;">
                    <div style="width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <svg width="20" height="20" fill="#fff" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    <div style="flex:1;">
                        <p style="color:#fff;font-weight:700;font-size:13px;margin:0;">Pristo Enterprises</p>
                        <p style="color:rgba(255,255,255,.8);font-size:11px;margin:2px 0 0;display:flex;align-items:center;gap:5px;">
                            <span style="width:7px;height:7px;border-radius:50%;background:#a7f3d0;display:inline-block;"></span>
                            Online · Typically replies instantly
                        </p>
                    </div>
                    <button onclick="pristoWaToggle()" style="background:none;border:none;cursor:pointer;color:rgba(255,255,255,.75);font-size:20px;line-height:1;padding:0;">&times;</button>
                </div>
                <!-- Chat bubble -->
                <div style="background:#e5ddd5;padding:16px;">
                    <div style="display:flex;gap:8px;align-items:flex-start;">
                        <div style="width:28px;height:28px;border-radius:50%;background:#128C7E;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span style="color:#fff;font-size:10px;font-weight:700;">P</span>
                        </div>
                        <div style="background:#fff;border-radius:12px;border-top-left-radius:3px;padding:10px 12px;box-shadow:0 1px 4px rgba(0,0,0,.08);max-width:88%;">
                            <p style="font-size:12.5px;color:#303030;line-height:1.55;margin:0;">
                                👋 Hello! Welcome to <strong>Pristo Enterprises</strong>.<br>How can we help you today?
                            </p>
                            <p style="font-size:9px;color:#aaa;margin:5px 0 0;text-align:right;">now</p>
                        </div>
                    </div>
                </div>
                <!-- CTA -->
                <div style="padding:12px;background:#fff;border-top:1px solid #f0f0f0;">
                    <a href="https://wa.me/916362346660?text=Hello%20Pristo!%20I%20am%20interested%20in%20your%20products."
                       target="_blank" rel="noopener"
                       style="display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:11px;border-radius:10px;background:linear-gradient(135deg,#25d366,#128C7E);color:#fff;font-weight:700;font-size:13px;text-decoration:none;transition:opacity .2s;">
                        <svg width="16" height="16" fill="#fff" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Start Chat on WhatsApp
                    </a>
                </div>
            </div>

            <!-- WhatsApp FAB Button -->
            <button id="pristoWaBtn"
                    onclick="pristoWaToggle()"
                    class="wa-fab"
                    title="Chat on WhatsApp"
                    style="position:relative;width:56px;height:56px;border-radius:50%;background:linear-gradient(135deg,#25d366,#128C7E);border:none;cursor:pointer;box-shadow:0 6px 24px rgba(37,211,102,.4);display:flex;align-items:center;justify-content:center;transition:transform .2s ease;">
                <!-- Red badge -->
                <span style="position:absolute;top:-2px;right:-2px;width:18px;height:18px;border-radius:50%;background:#ef4444;border:2px solid #fff;display:flex;align-items:center;justify-content:center;">
                    <span style="color:#fff;font-size:9px;font-weight:700;">1</span>
                </span>
                <!-- WA icon -->
                <svg id="pristoWaIconWa" width="28" height="28" fill="#fff" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                <!-- Close icon -->
                <svg id="pristoWaIconX" width="22" height="22" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24" style="display:none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    <script>
    var _waOpen = false;
    function pristoWaToggle() {
        _waOpen = !_waOpen;
        var card  = document.getElementById('pristoWaCard');
        var iWa   = document.getElementById('pristoWaIconWa');
        var iX    = document.getElementById('pristoWaIconX');
        if (_waOpen) {
            card.style.display = 'block';
            card.classList.add('wa-card-open');
            iWa.style.display = 'none';
            iX.style.display  = 'block';
        } else {
            card.style.display = 'none';
            iWa.style.display = 'block';
            iX.style.display  = 'none';
        }
    }
    document.addEventListener('click', function(e) {
        var btn  = document.getElementById('pristoWaBtn');
        var card = document.getElementById('pristoWaCard');
        if (_waOpen && card && btn && !card.contains(e.target) && !btn.contains(e.target)) {
            pristoWaToggle();
        }
    });
    window.addEventListener('scroll', function() {
        var b = document.getElementById('pristoBackTop');
        if (!b) return;
        window.scrollY > 300 ? b.classList.add('btt-show') : b.classList.remove('btt-show');
    }, { passive: true });
    </script>

    </body>
</html>
