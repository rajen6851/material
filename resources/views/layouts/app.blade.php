<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'PRISTO | SPACES INSPIRED - Luxury Sanitaryware, Tiles & Kitchen' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Tailwind CSS & JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '4540657416195331');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=4540657416195331&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->

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


        /* =========================================
           PRISTO FLOWER LOADER
           ========================================= */

        #pristo-loader {
            position: fixed;
            inset: 0;
            z-index: 999999;
            background-color: #171615;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.8s ease, visibility 0.8s ease;
        }

        .flower-loader {
            position: relative;
            width: 60px;
            height: 60px;
            animation: spin-flower 6s linear infinite;
        }

        .petal {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 18px;
            height: 18px;
            border: 2px solid #c09b5a;
            border-radius: 0 18px 18px 0;
            transform-origin: 0% 0%;
            background-color: rgba(192, 155, 90, 0.1);
        }

        .petal:nth-child(1) {
            animation: bloom1 1.5s cubic-bezier(0.4, 0, 0.2, 1) infinite alternate;
        }

        .petal:nth-child(2) {
            animation: bloom2 1.5s cubic-bezier(0.4, 0, 0.2, 1) infinite alternate;
            animation-delay: 0.1s;
        }

        .petal:nth-child(3) {
            animation: bloom3 1.5s cubic-bezier(0.4, 0, 0.2, 1) infinite alternate;
            animation-delay: 0.2s;
        }

        .petal:nth-child(4) {
            animation: bloom4 1.5s cubic-bezier(0.4, 0, 0.2, 1) infinite alternate;
            animation-delay: 0.3s;
        }

        .petal:nth-child(5) {
            animation: bloom5 1.5s cubic-bezier(0.4, 0, 0.2, 1) infinite alternate;
            animation-delay: 0.4s;
        }

        .petal:nth-child(6) {
            animation: bloom6 1.5s cubic-bezier(0.4, 0, 0.2, 1) infinite alternate;
            animation-delay: 0.5s;
        }

        @keyframes bloom1 {
            0% {
                transform: rotate(0deg) translate(3px, -9px) scale(0.5);
                opacity: 0.4;
            }

            100% {
                transform: rotate(0deg) translate(14px, -9px) scale(1.2);
                opacity: 1;
            }
        }

        @keyframes bloom2 {
            0% {
                transform: rotate(60deg) translate(3px, -9px) scale(0.5);
                opacity: 0.4;
            }

            100% {
                transform: rotate(60deg) translate(14px, -9px) scale(1.2);
                opacity: 1;
            }
        }

        @keyframes bloom3 {
            0% {
                transform: rotate(120deg) translate(3px, -9px) scale(0.5);
                opacity: 0.4;
            }

            100% {
                transform: rotate(120deg) translate(14px, -9px) scale(1.2);
                opacity: 1;
            }
        }

        @keyframes bloom4 {
            0% {
                transform: rotate(180deg) translate(3px, -9px) scale(0.5);
                opacity: 0.4;
            }

            100% {
                transform: rotate(180deg) translate(14px, -9px) scale(1.2);
                opacity: 1;
            }
        }

        @keyframes bloom5 {
            0% {
                transform: rotate(240deg) translate(3px, -9px) scale(0.5);
                opacity: 0.4;
            }

            100% {
                transform: rotate(240deg) translate(14px, -9px) scale(1.2);
                opacity: 1;
            }
        }

        @keyframes bloom6 {
            0% {
                transform: rotate(300deg) translate(3px, -9px) scale(0.5);
                opacity: 0.4;
            }

            100% {
                transform: rotate(300deg) translate(14px, -9px) scale(1.2);
                opacity: 1;
            }
        }

        @keyframes spin-flower {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .hide-loader {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }


        /* =========================================
           PRISTO MOUSE CIRCLE ANIMATION
           ========================================= */

        #pristoMouseCircle {
            position: fixed;
            width: 34px;
            height: 34px;

            border: 1.5px solid rgba(192, 155, 90, 0.8);
            border-radius: 50%;

            pointer-events: none;

            z-index: 999998;

            transform: translate(-50%, -50%);

            opacity: 0;

            transition:
                width 0.25s ease,
                height 0.25s ease,
                border-color 0.25s ease,
                background-color 0.25s ease,
                opacity 0.25s ease;
        }


        /* Inner Gold Dot */

        #pristoMouseCircle::after {
            content: "";

            position: absolute;

            width: 5px;
            height: 5px;

            background: #c09b5a;

            border-radius: 50%;

            top: 50%;
            left: 50%;

            transform: translate(-50%, -50%);

            transition:
                transform 0.25s ease,
                width 0.25s ease,
                height 0.25s ease;
        }


        /* Hover on links/buttons */

        #pristoMouseCircle.pristo-hover {
            width: 52px;
            height: 52px;

            border-color: #c09b5a;

            background-color: rgba(192, 155, 90, 0.08);
        }

        #pristoMouseCircle.pristo-hover::after {
            width: 7px;
            height: 7px;

            transform: translate(-50%, -50%);
        }


        /* Click Ripple */

        #pristoMouseCircle.pristo-click {
            animation: pristoMouseClick 0.55s ease-out;
        }

        @keyframes pristoMouseClick {

            0% {
                width: 34px;
                height: 34px;

                opacity: 1;

                border-color: #c09b5a;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                width: 80px;
                height: 80px;

                opacity: 0;

                border-color: rgba(192, 155, 90, 0);
            }
        }


        /* =========================================
           WHATSAPP + BACK TOP
           ========================================= */

        @keyframes wa-ripple {

            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.55);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(37, 211, 102, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        @keyframes slideUpFade {

            from {
                opacity: 0;
                transform: translateY(16px) scale(.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .wa-fab {
            animation: wa-ripple 2.2s ease-out infinite;
        }

        .wa-card-open {
            animation: slideUpFade .28s cubic-bezier(.25, .8, .25, 1) forwards;
        }

        #pristoBackTop {
            opacity: 0;
            pointer-events: none;

            transition:
                opacity .3s ease,
                transform .3s ease;

            transform: translateY(8px);
        }

        #pristoBackTop.btt-show {
            opacity: 1;
            pointer-events: auto;

            transform: translateY(0);
        }


        /* =========================================
           MOBILE / TOUCH DEVICES
           ========================================= */

        @media (hover: none), (pointer: coarse) {

            #pristoMouseCircle {
                display: none !important;
            }

        }

    </style>

</head>


<body class="antialiased bg-[#faf8f5] text-[#242220] flex flex-col min-h-screen overflow-x-hidden">


    <!-- =========================================
         FLOWER LOADER
         ========================================= -->

    <div id="pristo-loader">

        <div class="flower-loader">

            <div class="petal"></div>
            <div class="petal"></div>
            <div class="petal"></div>
            <div class="petal"></div>
            <div class="petal"></div>
            <div class="petal"></div>

        </div>

    </div>


    <script>

        window.addEventListener('load', function () {

            const loader = document.getElementById('pristo-loader');

            if (loader) {

                setTimeout(() => {

                    loader.classList.add('hide-loader');

                }, 500);

            }

        });

    </script>


    <!-- =========================================
         PRISTO MOUSE CIRCLE
         ========================================= -->

    <div id="pristoMouseCircle"></div>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const mouseCircle =
                document.getElementById('pristoMouseCircle');

            if (!mouseCircle) return;


            let mouseX = 0;
            let mouseY = 0;

            let circleX = 0;
            let circleY = 0;

            let mouseVisible = false;


            /*
             * Mouse Position
             */

            document.addEventListener('mousemove', function (e) {

                mouseX = e.clientX;
                mouseY = e.clientY;


                if (!mouseVisible) {

                    mouseVisible = true;

                    circleX = mouseX;
                    circleY = mouseY;

                    mouseCircle.style.opacity = '1';

                }

            });


            /*
             * Smooth Mouse Following
             */

            function animateMouseCircle() {

                circleX += (mouseX - circleX) * 0.15;

                circleY += (mouseY - circleY) * 0.15;


                mouseCircle.style.left =
                    circleX + 'px';

                mouseCircle.style.top =
                    circleY + 'px';


                requestAnimationFrame(
                    animateMouseCircle
                );

            }


            animateMouseCircle();


            /*
             * Clickable Elements
             */

            const clickableElements =
                document.querySelectorAll(
                    'a, button, input, textarea, select, [role="button"]'
                );


            clickableElements.forEach(function (element) {

                element.addEventListener(
                    'mouseenter',
                    function () {

                        mouseCircle.classList.add(
                            'pristo-hover'
                        );

                    }
                );


                element.addEventListener(
                    'mouseleave',
                    function () {

                        mouseCircle.classList.remove(
                            'pristo-hover'
                        );

                    }
                );

            });


            /*
             * Mouse Click Ripple
             */

            document.addEventListener(
                'mousedown',
                function () {

                    mouseCircle.classList.remove(
                        'pristo-click'
                    );


                    /*
                     * Restart animation
                     */

                    void mouseCircle.offsetWidth;


                    mouseCircle.classList.add(
                        'pristo-click'
                    );

                }
            );


            /*
             * Animation Complete
             */

            mouseCircle.addEventListener(
                'animationend',
                function () {

                    mouseCircle.classList.remove(
                        'pristo-click'
                    );

                }
            );


            /*
             * Mouse leaves browser
             */

            document.addEventListener(
                'mouseleave',
                function () {

                    mouseCircle.style.opacity = '0';

                }
            );


            /*
             * Mouse enters browser
             */

            document.addEventListener(
                'mouseenter',
                function () {

                    mouseCircle.style.opacity = '1';

                }
            );

        });

    </script>


    @php

        $globalCategories =
            \App\Models\Category::all();

        $globalRooms =
            \App\Models\Room::all();


        /*
         * Calculate Cart Item Count
         */

        $cartCount = 0;

        if (auth()->check()) {

            $cartCount =
                \App\Models\CartItem::where(
                    'user_id',
                    auth()->id()
                )->sum('quantity');

        } else {

            $cart =
                session()->get('cart', []);

            foreach ($cart as $item) {

                $cartCount +=
                    $item['quantity'] ?? 0;

            }

        }

    @endphp


    <!-- =========================================
         HEADER
         ========================================= -->

    <header
        class="bg-[#f7f4ef] border-b border-[#e8e4dc] sticky top-0 z-50 shadow-sm"
        x-data="{
            open: false,
            categoryDropdown: false,
            roomDropdown: false,
            brandDropdown: false,
            userDropdown: false
        }"
    >


        <!-- Announcement -->

        <div class="bg-[#171615] text-[#d6d0c7] py-2 px-4 text-xs font-medium border-b border-[#2b2825]">

            <div class="max-w-[1500px] mx-auto flex flex-col sm:flex-row justify-center sm:justify-between items-center gap-2">

                <div class="flex items-center gap-2">

                    <span class="text-xs font-medium tracking-wide text-[#e5dfd5]">

                        Premium Building &amp; Home Solutions | Bangalore

                    </span>

                </div>


                <div class="flex flex-wrap justify-center items-center gap-2 sm:gap-6 text-[10px] sm:text-xs text-[#a8a29e]">

                    <a
                        href="/showroom-visit/book"
                        class="hover:text-white transition flex items-center gap-1.5 text-[#e5dfd5] font-semibold"
                    >
                        <span>
                            Book Showroom Visit (User & B2B)
                        </span>
                    </a>


                    <span class="text-[#44403c] hidden sm:inline">
                        |
                    </span>


                    <a
                        href="mailto:{{ $siteSettings?->email ?? 'pristoenterprises@gmail.com' }}"
                        class="hover:text-[#c09b5a] transition hidden sm:flex items-center gap-1.5 text-[#d6d0c7]"
                    >

                        <svg
                            class="w-3.5 h-3.5 text-[#c09b5a]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                            />
                        </svg>

                        <span>
                            {{ $siteSettings?->email ?? 'pristoenterprises@gmail.com' }}
                        </span>

                    </a>


                    <span class="text-[#44403c] hidden sm:inline">
                        |
                    </span>


                    <a
                        href="tel:{{ $siteSettings?->phone ?? '+916362346660' }}"
                        class="flex items-center gap-1.5 font-semibold text-white hover:text-[#c09b5a] transition"
                    >

                        <svg
                            class="w-3.5 h-3.5 text-[#c09b5a]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                            />
                        </svg>

                        <span>
                            {{ $siteSettings?->phone ?? '+91 63623 46660' }}
                        </span>

                    </a>

                </div>

            </div>

        </div>


        <!-- Main Navigation -->

        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 py-3.5">

            <div class="flex justify-between items-center gap-3 lg:gap-4 xl:gap-6">


                <!-- Logo -->

                <a
                    href="/"
                    class="flex items-center gap-3 group flex-shrink-0 py-1"
                >

                    <img
                        src="{{ asset('images/logo.jpeg') }}"
                        alt="PRISTO ENTERPRISES Logo"
                        class="h-11 w-auto object-contain rounded-md shadow-sm border border-[#e8e4dc]/80 group-hover:scale-105 transition duration-300"
                    >

                    <div class="flex flex-col">

                        <span
                            class="font-serif-pristo font-bold text-xl lg:text-2xl tracking-[0.15em] text-[#171615] leading-none group-hover:text-[#c09b5a] transition"
                        >
                            PRISTO
                        </span>

                        <span
                            class="text-[8px] uppercase tracking-[0.3em] font-bold text-[#78716c] mt-1"
                        >
                            ENTERPRISES
                        </span>

                    </div>

                </a>


                <!-- Desktop Navigation -->

                <nav class="hidden lg:flex items-center gap-3 xl:gap-7 text-xs font-bold uppercase tracking-wider text-[#171615] relative z-50">


                    <a
                        href="/"
                        class="hover:text-[#c09b5a] transition py-1 text-[#171615]"
                    >
                        Home
                    </a>


                    <!-- Shop by Space -->

                    <div class="relative">

                        <button
                            @click="roomDropdown = !roomDropdown"
                            @click.away="roomDropdown = false"
                            class="hover:text-[#c09b5a] transition flex items-center gap-1 py-1 uppercase focus:outline-none"
                        >

                            Shop by Space

                            <svg
                                class="w-3 h-3 text-[#78716c]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>

                        </button>


                        <div
                            x-show="roomDropdown"
                            class="absolute left-0 mt-2 w-52 bg-white border border-[#e8e4dc] rounded-xl shadow-xl py-2 z-50 text-xs tracking-normal font-medium capitalize"
                            x-cloak
                        >

                            @foreach($globalRooms as $room)

                                <a
                                    href="{{ route('rooms.show', $room->slug) }}"
                                    class="block px-4 py-2 hover:bg-[#f5f0ea] hover:text-[#c09b5a] transition"
                                >
                                    {{ $room->name }}
                                </a>

                            @endforeach

                        </div>

                    </div>


                    <!-- Brands -->

                    <div class="relative">

                        <button
                            @click="brandDropdown = !brandDropdown"
                            @click.away="brandDropdown = false"
                            class="hover:text-[#c09b5a] transition flex items-center gap-1 py-1 uppercase focus:outline-none"
                        >

                            Brands

                            <svg
                                class="w-3 h-3 text-[#78716c]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>

                        </button>


                        <div
                            x-show="brandDropdown"
                            class="absolute left-0 mt-2 w-52 bg-white border border-[#e8e4dc] rounded-xl shadow-xl py-2 z-50 text-xs tracking-normal font-medium capitalize"
                            x-cloak
                        >

                            @foreach(\App\Models\Brand::all() as $br)

                                <a
                                    href="/products?brand={{ $br->slug }}"
                                    class="block px-4 py-2 hover:bg-[#f5f0ea] hover:text-[#c09b5a] transition"
                                >
                                    {{ $br->name }}
                                </a>

                            @endforeach

                        </div>

                    </div>


                                        <a
                        href="/packages"
                        class="hover:text-[#c09b5a] transition py-1 flex items-center gap-1.5 text-[#171615]"
                    >
                        <span>Packages</span>
                        <span class="text-[9px] bg-[#c09b5a] text-white px-1.5 py-0.5 rounded-full font-bold uppercase tracking-wider">Combos</span>
                    </a>


<a
                        href="/inspiration"
                        class="hover:text-[#c09b5a] transition py-1"
                    >
                        Inspiration
                    </a>


                    <a
                        href="/showroom-visit/book"
                        class="hover:text-[#c09b5a] transition py-1 flex items-center gap-1 text-[#171615]"
                    >
                        <span>
                            Visit Showroom
                        </span>
                    </a>


                    <a
                        href="/about"
                        class="hover:text-[#c09b5a] transition py-1"
                    >
                        About Us
                    </a>


                    <a
                        href="/contact"
                        class="hover:text-[#c09b5a] transition py-1"
                    >
                        Contact
                    </a>

                </nav>


                <!-- Right Actions -->

                <div class="flex items-center gap-2 lg:gap-3 xl:gap-4 flex-1 max-w-md justify-end relative z-50">


                    <!-- Search -->

                    <form
                        action="/products"
                        method="GET"
                        class="relative w-full max-w-[200px] xl:max-w-xs hidden sm:block"
                    >

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search for products, brands, spaces..."
                            class="w-full pl-9 pr-4 py-2 bg-[#eae5dc] border border-[#dcd4c7] focus:border-[#c09b5a] focus:bg-white focus:outline-none rounded-full text-xs text-[#242220] placeholder-[#78716c] transition"
                        >

                        <button
                            type="submit"
                            class="absolute left-3 top-2.5 text-[#78716c] hover:text-[#c09b5a]"
                        >

                            <svg
                                class="w-4 h-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>

                        </button>

                    </form>


                    <!-- Action Icons -->

                    <div class="flex items-center gap-3">


                        <!-- Compare -->

                        <a
                            href="/compare"
                            class="text-[#171615] hover:text-[#c09b5a] transition p-1.5 rounded-full hover:bg-[#eae5dc] relative"
                            title="Compare"
                        >

                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                />
                            </svg>

                            @if(count(session('compare', [])) > 0)

                                <span
                                    class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full text-[9px] font-bold w-4 h-4 flex items-center justify-center"
                                >
                                    {{ count(session('compare', [])) }}
                                </span>

                            @endif

                        </a>


                        <!-- Wishlist -->

                        <a
                            href="/wishlist"
                            class="text-[#171615] hover:text-[#c09b5a] transition p-1.5 rounded-full hover:bg-[#eae5dc] relative"
                            title="Wishlist"
                        >

                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.684a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                />
                            </svg>

                            @if(count(session('wishlist', [])) > 0)

                                <span
                                    class="absolute -top-1 -right-1 bg-teal-600 text-white rounded-full text-[9px] font-bold w-4 h-4 flex items-center justify-center"
                                >
                                    {{ count(session('wishlist', [])) }}
                                </span>

                            @endif

                        </a>


                        <!-- Cart / Quotation -->

                        @unless(auth()->check() && auth()->user()->isProfessional())

                            <a
                                href="/cart"
                                class="relative text-[#171615] hover:text-[#c09b5a] transition p-1.5 rounded-full hover:bg-[#eae5dc]"
                                title="Shopping Cart"
                            >

                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                                    />
                                </svg>

                                <span
                                    class="absolute -top-1 -right-1 bg-[#171615] text-white rounded-full text-[9px] font-bold w-4 h-4 flex items-center justify-center"
                                >
                                    {{ $cartCount }}
                                </span>

                            </a>

                        @else

                            <a
                                href="/quotation-requests/create"
                                class="relative text-[#171615] hover:text-[#c09b5a] transition p-1.5 rounded-full hover:bg-[#eae5dc]"
                                title="Request Quotation"
                            >

                                <svg
                                    class="w-5 h-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                    />
                                </svg>

                            </a>

                        @endunless


                        <!-- User -->

                        <div class="relative">

                            @auth

                                <button
                                    @click="userDropdown = !userDropdown"
                                    @click.away="userDropdown = false"
                                    class="flex items-center gap-1.5 focus:outline-none p-1"
                                >

                                    <div
                                        class="w-7 h-7 bg-[#171615] text-white rounded-full flex items-center justify-center font-bold text-xs"
                                    >
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>

                                </button>


                                <div
                                    x-show="userDropdown"
                                    class="absolute right-0 mt-2 w-52 bg-white border border-[#e8e4dc] rounded-xl shadow-xl py-2 z-50 text-xs font-medium"
                                    x-cloak
                                >

                                    <div class="px-4 py-2 border-b bg-[#faf8f5]">

                                        <p class="font-semibold text-[#171615] leading-tight">
                                            {{ auth()->user()->name }}
                                        </p>

                                        <p class="text-[10px] text-[#8c857b] mt-0.5 capitalize">
                                            {{ auth()->user()->role }}
                                        </p>

                                    </div>


                                    @if(auth()->user()->isAdmin())

                                        <a
                                            href="/admin/dashboard"
                                            class="block px-4 py-2 text-[#242220] hover:bg-[#f5f0ea] hover:text-[#c09b5a] font-bold transition"
                                        >
                                            Admin Panel
                                        </a>

                                    @endif


                                    <a
                                        href="/dashboard"
                                        class="block px-4 py-2 text-[#242220] hover:bg-[#f5f0ea] hover:text-[#c09b5a] transition"
                                    >
                                        My Dashboard
                                    </a>


                                    <a
                                        href="/profile"
                                        class="block px-4 py-2 text-[#242220] hover:bg-[#f5f0ea] hover:text-[#c09b5a] transition"
                                    >
                                        My Profile
                                    </a>


                                    <hr class="my-1 border-[#e8e4dc]">


                                    <form
                                        method="POST"
                                        action="{{ route('logout') }}"
                                    >

                                        @csrf

                                        <button
                                            type="submit"
                                            class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50 transition"
                                        >
                                            Log Out
                                        </button>

                                    </form>

                                </div>

                            @else

                                <a
                                    href="{{ route('login') }}"
                                    class="text-[#171615] hover:text-[#c09b5a] transition p-1.5 rounded-full hover:bg-[#eae5dc]"
                                    title="Account Login"
                                >

                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />
                                    </svg>

                                </a>

                            @endauth

                        </div>


                        <!-- Mobile Menu -->

                        <button
                            @click="open = !open"
                            class="lg:hidden text-[#171615] focus:outline-none"
                        >

                            <svg
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                            </svg>

                        </button>

                    </div>

                </div>

            </div>

        </div>


        <!-- Mobile Menu -->

     
<!-- =========================================
     COMPLETE MOBILE NAVIGATION
     ========================================= -->

{{-- =========================================
     COMPLETE MOBILE NAVIGATION
     ========================================= --}}

<div
    x-show="open"
    x-transition
    x-cloak
    class="lg:hidden bg-white border-t border-[#e8e4dc] shadow-lg"
>
    {{-- Scrollable Mobile Menu --}}
    <div class="max-h-[calc(100dvh-80px)] overflow-y-auto overscroll-contain px-6 py-4">

        {{-- SEARCH --}}
        <form action="/products" method="GET" class="relative mb-4">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search products..."
                class="w-full rounded-full border border-[#e8e4dc] py-3 pl-4 pr-11 text-sm focus:outline-none focus:ring-2 focus:ring-[#c09b5a]"
            >

            <button
                type="submit"
                aria-label="Search products"
                class="absolute right-3 top-3 text-[#78716c]"
            >
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                    />
                </svg>
            </button>
        </form>


        {{-- MAIN NAVIGATION --}}
        <nav class="space-y-0">

            <a
                href="/"
                @click="open = false"
                class="block border-b border-[#e8e4dc] py-3 font-semibold text-[#242220]"
            >
                Home
            </a>

            <a
                href="/products"
                @click="open = false"
                class="block border-b border-[#e8e4dc] py-3 font-semibold text-[#242220]"
            >
                All Products
            </a>

                        <a
                href="/packages"
                @click="open = false"
                class="block border-b border-[#e8e4dc] py-3 font-semibold text-[#242220] flex items-center justify-between"
            >
                <span>Bathroom Packages</span>
                <span class="text-[10px] bg-[#c09b5a] text-white px-2 py-0.5 rounded-full font-bold">Combos</span>
            </a>

<a
                href="/inspiration"
                @click="open = false"
                class="block border-b border-[#e8e4dc] py-3 font-semibold text-[#242220]"
            >
                Work Gallery &amp; Inspiration
            </a>

            <a
                href="/about"
                @click="open = false"
                class="block border-b border-[#e8e4dc] py-3 font-semibold text-[#242220]"
            >
                About Us
            </a>

            <a
                href="/contact"
                @click="open = false"
                class="block border-b border-[#e8e4dc] py-3 font-semibold text-[#242220]"
            >
                Contact &amp; Support
            </a>

            <a
                href="/showroom-visit/book"
                @click="open = false"
                class="block border-b border-[#e8e4dc] py-3 font-semibold text-[#c09b5a]"
            >
                Book Showroom Visit
            </a>

        </nav>


        {{-- SHOP BY CATEGORY --}}
        <div
            x-data="{ categoryOpen: false }"
            class="border-b border-[#e8e4dc] py-1.5"
        >
            <button
                type="button"
                @click="categoryOpen = !categoryOpen"
                :aria-expanded="categoryOpen.toString()"
                class="flex w-full items-center justify-between py-2.5 font-semibold text-[#242220]"
            >
                <span>Shop by Category</span>

                <svg
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    :class="{ 'rotate-180': categoryOpen }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>
            </button>

            <div
                x-show="categoryOpen"
                x-collapse
                class="space-y-1 pb-3 pl-3"
            >
                @forelse($globalCategories as $category)
                    <a
                        href="{{ url('/categories/' . $category->slug) }}"
                        @click="open = false"
                        class="block py-2 text-sm text-[#55504a] hover:text-[#c09b5a]"
                    >
                        {{ $category->name }}
                    </a>
                @empty
                    <p class="py-2 text-sm text-[#78716c]">
                        No categories available.
                    </p>
                @endforelse

                <a
                    href="{{ url('/products') }}"
                    @click="open = false"
                    class="block py-2 text-sm font-semibold text-[#c09b5a]"
                >
                    View All Categories →
                </a>
            </div>
        </div>


        {{-- SHOP BY SPACE --}}
        <div
            x-data="{ spaceOpen: false }"
            class="border-b border-[#e8e4dc] py-1.5"
        >
            <button
                type="button"
                @click="spaceOpen = !spaceOpen"
                :aria-expanded="spaceOpen.toString()"
                class="flex w-full items-center justify-between py-2.5 font-semibold text-[#242220]"
            >
                <span>Shop by Space</span>

                <svg
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    :class="{ 'rotate-180': spaceOpen }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>
            </button>

            <div
                x-show="spaceOpen"
                x-collapse
                class="space-y-1 pb-3 pl-3"
            >
                @forelse($globalRooms as $room)
                    <a
                        href="{{ route('rooms.show', $room->slug) }}"
                        @click="open = false"
                        class="block py-2 text-sm text-[#55504a] hover:text-[#c09b5a]"
                    >
                        {{ $room->name }}
                    </a>
                @empty
                    <p class="py-2 text-sm text-[#78716c]">
                        No spaces available.
                    </p>
                @endforelse
            </div>
        </div>


        {{-- SHOP BY BRAND --}}
        <div
            x-data="{ brandOpen: false }"
            class="border-b border-[#e8e4dc] py-1.5"
        >
            <button
                type="button"
                @click="brandOpen = !brandOpen"
                :aria-expanded="brandOpen.toString()"
                class="flex w-full items-center justify-between py-2.5 font-semibold text-[#242220]"
            >
                <span>Shop by Brand</span>

                <svg
                    class="h-4 w-4 shrink-0 transition-transform duration-200"
                    :class="{ 'rotate-180': brandOpen }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 9l-7 7-7-7"
                    />
                </svg>
            </button>

            <div
                x-show="brandOpen"
                x-collapse
                class="space-y-1 pb-3 pl-3"
            >
                @forelse(\App\Models\Brand::orderBy('name')->get() as $br)
                    <a
                        href="{{ url('/products?brand=' . $br->slug) }}"
                        @click="open = false"
                        class="block py-2 text-sm text-[#55504a] hover:text-[#c09b5a]"
                    >
                        {{ $br->name }}
                    </a>
                @empty
                    <p class="py-2 text-sm text-[#78716c]">
                        No brands available.
                    </p>
                @endforelse

                <a
                    href="{{ url('/products') }}"
                    @click="open = false"
                    class="block pt-2 text-sm font-semibold text-[#c09b5a]"
                >
                    View All Products →
                </a>
            </div>
        </div>


        {{-- MY ACCOUNT --}}
        <section class="border-b border-[#e8e4dc] py-4">
            <p class="mb-3 text-xs font-bold uppercase tracking-wider text-[#8c857b]">
                My Account
            </p>

            @auth
                <a
                    href="{{ url('/dashboard') }}"
                    @click="open = false"
                    class="block py-2 text-sm font-semibold text-[#242220] hover:text-[#c09b5a]"
                >
                    My Dashboard
                </a>

                <a
                    href="{{ url('/profile') }}"
                    @click="open = false"
                    class="block py-2 text-sm text-[#55504a] hover:text-[#c09b5a]"
                >
                    My Profile
                </a>

                <form
                    action="{{ route('logout') }}"
                    method="POST"
                    class="mt-2"
                >
                    @csrf

                    <button
                        type="submit"
                        class="w-full py-2 text-left text-sm font-semibold text-red-600"
                    >
                        Logout
                    </button>
                </form>
            @else
                <a
                    href="{{ route('login') }}"
                    @click="open = false"
                    class="block py-2 text-sm font-semibold text-[#242220] hover:text-[#c09b5a]"
                >
                    Login
                </a>

                <a
                    href="{{ route('register') }}"
                    @click="open = false"
                    class="block py-2 text-sm font-semibold text-[#242220] hover:text-[#c09b5a]"
                >
                    Create Account
                </a>
            @endauth
        </section>


        {{-- CONTACT DETAILS --}}
        <section class="space-y-4 pt-4">

            <a
                href="tel:{{ $siteSettings?->phone ?? '+916362346660' }}"
                class="flex items-center gap-3 text-sm font-semibold text-[#171615] hover:text-[#c09b5a]"
            >
                <svg
                    class="h-5 w-5 shrink-0 text-[#c09b5a]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a2 2 0 01.94.725l.548 2.2a2 2 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a2 2 0 01.988-.321l2.2.548a2 2 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                    />
                </svg>

                <span>
                    {{ $siteSettings?->phone ?? '+91 63623 46660' }}
                </span>
            </a>

            <a
                href="mailto:{{ $siteSettings?->email ?? 'pristoenterprises@gmail.com' }}"
                class="flex items-center gap-3 break-all text-sm text-[#55504a] hover:text-[#c09b5a]"
            >
                <svg
                    class="h-5 w-5 shrink-0 text-[#c09b5a]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                    />
                </svg>

                <span>
                    {{ $siteSettings?->email ?? 'pristoenterprises@gmail.com' }}
                </span>
            </a>

        </section>

    </div>
</div>

    </header>


    <!-- =========================================
         MAIN CONTENT
         ========================================= -->

    <main class="flex-grow">


        <!-- Flash Alerts -->

        @if(session('success'))

            <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 mt-4">

                <div
                    class="bg-[#f5f0ea] border border-[#c09b5a] text-[#171615] px-4 py-3 rounded-xl flex items-center justify-between text-xs font-semibold"
                >

                    <span>
                        {{ session('success') }}
                    </span>

                </div>

            </div>

        @endif


        {{ $slot }}

    </main>


    <!-- =========================================
         FOOTER
         ========================================= -->

    <footer class="bg-[#171615] text-[#a39e97] pt-14 pb-8 border-t border-[#262422]">

        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-10">


            <!-- Brand -->

            <div class="space-y-4">

                <a
                    href="/"
                    class="flex items-center gap-3"
                >

                    <img
                        src="{{ asset('images/logo.jpeg') }}"
                        alt="PRISTO ENTERPRISES Logo"
                        class="h-11 w-auto object-contain rounded-md border border-[#333]"
                    >

                    <div class="flex flex-col">

                        <span
                            class="font-serif-pristo font-bold text-xl tracking-[0.18em] text-white"
                        >
                            PRISTO
                        </span>

                        <span
                            class="text-[9px] uppercase tracking-[0.3em] font-medium text-[#c09b5a]"
                        >
                            ENTERPRISES
                        </span>

                    </div>

                </a>


                <div class="space-y-2.5 text-xs text-[#a39e97] pt-2">


                    <p class="flex items-center gap-2.5">

                        <svg
                            class="w-4 h-4 text-[#c09b5a] flex-shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                            />
                        </svg>

                        <a
                            href="tel:{{ $siteSettings?->phone ?? '+916362346660' }}"
                            class="hover:text-white transition font-medium"
                        >
                            {{ $siteSettings?->phone ?? '+91 63623 46660' }}
                        </a>

                    </p>


                    <p class="flex items-center gap-2.5">

                        <svg
                            class="w-4 h-4 text-[#c09b5a] flex-shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                            />
                        </svg>

                        <a
                            href="mailto:{{ $siteSettings?->email ?? 'pristoenterprises@gmail.com' }}"
                            class="hover:text-white transition"
                        >
                            {{ $siteSettings?->email ?? 'pristoenterprises@gmail.com' }}
                        </a>

                    </p>


                    <p class="flex items-start gap-2.5 pt-1 text-[11px] text-[#78716c]">

                        <svg
                            class="w-4 h-4 text-[#c09b5a] flex-shrink-0 mt-0.5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                            />

                        </svg>

                        <span>
                            Bangalore, Karnataka
                        </span>

                    </p>

                </div>

            </div>


            <!-- Quick Links -->

            <div>

                <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-4">
                    Quick Links
                </h4>

                <ul class="space-y-2 text-xs text-[#a39e97]">

                    <li>
                        <a href="/" class="hover:text-white transition">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="/" class="hover:text-white transition">
                            Shop by Space
                        </a>
                    </li>

                    <li>
                        <a href="/inspiration" class="hover:text-white transition">
                            Work Gallery &amp; Inspiration
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('blog') }}" class="hover:text-white transition">
                            Read Our Blog
                        </a>
                    </li>

                    <li>
                        <a href="/about" class="hover:text-white transition">
                            About Pristo
                        </a>
                    </li>

                    <li>
                        <a href="/contact" class="hover:text-white transition">
                            Contact &amp; Support
                        </a>
                    </li>

                    <li>
                        <a href="/showroom-visit/book" class="hover:text-white transition">
                            Book Showroom Visit
                        </a>
                    </li>

                    <li>
                        <a href="/quotation-requests/create" class="hover:text-white transition">
                            Request Quotation
                        </a>
                    </li>

                </ul>

            </div>


            <!-- Customer Care -->

            <div>

                <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-4">
                    Customer Care
                </h4>

                <ul class="space-y-2 text-xs text-[#a39e97]">

                    <li>
                        <a href="/terms-conditions" class="hover:text-white transition">
                            Terms &amp; Conditions
                        </a>
                    </li>

                    <li>
                        <a href="/terms-conditions#shipping" class="hover:text-white transition">
                            Shipping Policy (Charges Applicable)
                        </a>
                    </li>

                    <li>
                        <a href="/terms-conditions#breakage" class="hover:text-white transition">
                            Transit Damage &amp; Inspection
                        </a>
                    </li>

                    <li>
                        <a href="/terms-conditions#returns" class="hover:text-white transition">
                            Returns &amp; Replacements
                        </a>
                    </li>

                    <li>
                        <a href="/contact" class="hover:text-white transition">
                            Contact Customer Care
                        </a>
                    </li>

                </ul>

            </div>


            <!-- Newsletter -->

            <div class="space-y-3">

                <h4 class="text-white font-semibold text-xs uppercase tracking-wider mb-2">
                    Join our newsletter
                </h4>

                <p class="text-xs text-[#8c857b]">
                    Get the latest updates, special offers and design ideas.
                </p>


                <form class="flex items-center gap-0 mt-3">

                    <input
                        type="email"
                        placeholder="Enter your email address"
                        class="bg-[#242220] border border-[#363330] focus:border-[#c09b5a] text-white text-xs rounded-l-md px-3 py-2.5 w-full placeholder-[#78716c] focus:outline-none"
                    >

                    <button
                        type="button"
                        class="bg-[#c09b5a] hover:bg-[#a48043] text-white font-bold px-4 py-2.5 rounded-r-md transition text-xs flex items-center justify-center"
                    >
                        ➔
                    </button>

                </form>


                <!-- Social -->

                <div class="flex items-center gap-3 pt-2 text-[#a39e97]">


                    <a
                        href="{{ $siteSettings?->instagram_url ?? '#' }}"
                        class="hover:text-[#c09b5a] transition"
                        target="_blank"
                    >

                        <svg
                            class="w-4 h-4"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>

                    </a>


                    <a
                        href="{{ $siteSettings?->facebook_url ?? '#' }}"
                        class="hover:text-[#c09b5a] transition"
                        target="_blank"
                    >

                        <svg
                            class="w-4 h-4"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.592 0 9 1.583 9 4.615V8z"/>
                        </svg>

                    </a>


                    <a
                        href="{{ $siteSettings?->youtube_url ?? '#' }}"
                        class="hover:text-[#c09b5a] transition"
                        target="_blank"
                    >

                        <svg
                            class="w-4 h-4"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.196-.484-8.55-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                        </svg>

                    </a>

                </div>

            </div>

        </div>


        <!-- Copyright -->

        <div class="max-w-[1550px] mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-6 border-t border-[#242220] flex flex-col md:flex-row justify-between items-center text-[11px] text-[#78716c]">

            <p>
                © 2026 Pristo. All rights reserved.
            </p>

            <p class="italic">
                Better Space. A Brighter Tomorrow.
            </p>

        </div>

    </footer>


    <!-- =========================================
         FLOATING WIDGETS
         ========================================= -->

    <div
        style="
            position:fixed;
            bottom:24px;
            right:20px;
            z-index:99999;
            display:flex;
            flex-direction:column;
            align-items:flex-end;
            gap:10px;
        "
    >


        <!-- Back To Top -->

        <button
            id="pristoBackTop"
            onclick="window.scrollTo({top:0,behavior:'smooth'})"
            title="Back to Top"
            style="
                width:40px;
                height:40px;
                border-radius:50%;
                background:#fff;
                border:1.5px solid #ded7cd;
                box-shadow:0 4px 16px rgba(0,0,0,.12);
                display:flex;
                align-items:center;
                justify-content:center;
                cursor:pointer;
                transition:all .3s ease;
            "
        >

            <svg
                width="16"
                height="16"
                fill="none"
                stroke="#555"
                stroke-width="2.5"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5 15l7-7 7 7"
                />
            </svg>

        </button>


        <!-- Call -->

        <a
            href="tel:{{ $siteSettings?->phone ?? '+916362346660' }}"
            title="Call Us"
            style="
                width:40px;
                height:40px;
                border-radius:50%;
                background:#171615;
                box-shadow:0 4px 16px rgba(0,0,0,.2);
                display:flex;
                align-items:center;
                justify-content:center;
                text-decoration:none;
                transition:transform .2s ease;
            "
        >

            <svg
                width="18"
                height="18"
                fill="#fff"
                viewBox="0 0 24 24"
            >

                <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>

            </svg>

        </a>


        <!-- WhatsApp -->

        <div style="position:relative;">


            <!-- WhatsApp Card -->

            <div
                id="pristoWaCard"
                style="
                    display:none;
                    position:absolute;
                    bottom:64px;
                    right:0;
                    width:288px;
                    background:#fff;
                    border-radius:16px;
                    box-shadow:0 8px 40px rgba(0,0,0,.18);
                    overflow:hidden;
                    border:1px solid #e5e7eb;
                "
            >


                <!-- Header -->

                <div
                    style="
                        background:linear-gradient(135deg,#25d366,#128C7E);
                        padding:14px 16px;
                        display:flex;
                        align-items:center;
                        gap:12px;
                    "
                >

                    <div
                        style="
                            width:38px;
                            height:38px;
                            border-radius:50%;
                            background:rgba(255,255,255,.2);
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            flex-shrink:0;
                        "
                    >

                        <svg
                            width="20"
                            height="20"
                            fill="#fff"
                            viewBox="0 0 24 24"
                        >
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.198.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>

                    </div>


                    <div style="flex:1;">

                        <p
                            style="
                                color:#fff;
                                font-weight:700;
                                font-size:13px;
                                margin:0;
                            "
                        >
                            Pristo Enterprises
                        </p>

                        <p
                            style="
                                color:rgba(255,255,255,.8);
                                font-size:11px;
                                margin:2px 0 0;
                                display:flex;
                                align-items:center;
                                gap:5px;
                            "
                        >

                            <span
                                style="
                                    width:7px;
                                    height:7px;
                                    border-radius:50%;
                                    background:#a7f3d0;
                                    display:inline-block;
                                "
                            ></span>

                            Online · Typically replies instantly

                        </p>

                    </div>


                    <button
                        onclick="pristoWaToggle()"
                        style="
                            background:none;
                            border:none;
                            cursor:pointer;
                            color:rgba(255,255,255,.75);
                            font-size:20px;
                            line-height:1;
                            padding:0;
                        "
                    >
                        &times;
                    </button>

                </div>


                <!-- Chat -->

                <div
                    style="
                        background:#e5ddd5;
                        padding:16px;
                    "
                >

                    <div
                        style="
                            display:flex;
                            gap:8px;
                            align-items:flex-start;
                        "
                    >

                        <div
                            style="
                                width:28px;
                                height:28px;
                                border-radius:50%;
                                background:#128C7E;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                flex-shrink:0;
                            "
                        >

                            <span
                                style="
                                    color:#fff;
                                    font-size:10px;
                                    font-weight:700;
                                "
                            >
                                P
                            </span>

                        </div>


                        <div
                            style="
                                background:#fff;
                                border-radius:12px;
                                border-top-left-radius:3px;
                                padding:10px 12px;
                                box-shadow:0 1px 4px rgba(0,0,0,.08);
                                max-width:88%;
                            "
                        >

                            <p
                                style="
                                    font-size:12.5px;
                                    color:#303030;
                                    line-height:1.55;
                                    margin:0;
                                "
                            >
                                👋 Hello! Welcome to
                                <strong>Pristo Enterprises</strong>.<br>
                                How can we help you today?
                            </p>

                            <p
                                style="
                                    font-size:9px;
                                    color:#aaa;
                                    margin:5px 0 0;
                                    text-align:right;
                                "
                            >
                                now
                            </p>

                        </div>

                    </div>

                </div>


                <!-- WhatsApp CTA -->

                <div
                    style="
                        padding:12px;
                        background:#fff;
                        border-top:1px solid #f0f0f0;
                    "
                >

                    <a
                        href="https://wa.me/916362346660?text=Hello%20Pristo!%20I%20am%20interested%20in%20your%20products."
                        target="_blank"
                        rel="noopener"
                        style="
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            gap:8px;
                            width:100%;
                            padding:11px;
                            border-radius:10px;
                            background:linear-gradient(135deg,#25d366,#128C7E);
                            color:#fff;
                            font-weight:700;
                            font-size:13px;
                            text-decoration:none;
                            transition:opacity .2s;
                        "
                    >

                        <svg
                            width="16"
                            height="16"
                            fill="#fff"
                            viewBox="0 0 24 24"
                        >
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.198.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>

                        Start Chat on WhatsApp

                    </a>

                </div>

            </div>


            <!-- WhatsApp Button -->

            <button
                id="pristoWaBtn"
                onclick="pristoWaToggle()"
                class="wa-fab"
                title="Chat on WhatsApp"
                style="
                    position:relative;
                    width:56px;
                    height:56px;
                    border-radius:50%;
                    background:linear-gradient(135deg,#25d366,#128C7E);
                    border:none;
                    cursor:pointer;
                    box-shadow:0 6px 24px rgba(37,211,102,.4);
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    transition:transform .2s ease;
                "
            >


                <!-- Badge -->

                <span
                    style="
                        position:absolute;
                        top:-2px;
                        right:-2px;
                        width:18px;
                        height:18px;
                        border-radius:50%;
                        background:#ef4444;
                        border:2px solid #fff;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                    "
                >

                    <span
                        style="
                            color:#fff;
                            font-size:9px;
                            font-weight:700;
                        "
                    >
                        1
                    </span>

                </span>


                <!-- WA Icon -->

                <svg
                    id="pristoWaIconWa"
                    width="28"
                    height="28"
                    fill="#fff"
                    viewBox="0 0 24 24"
                >

                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.198.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>

                </svg>


                <!-- X Icon -->

                <svg
                    id="pristoWaIconX"
                    width="22"
                    height="22"
                    fill="none"
                    stroke="#fff"
                    stroke-width="2.5"
                    viewBox="0 0 24 24"
                    style="display:none;"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"
                    />

                </svg>

            </button>

        </div>

    </div>


    <!-- =========================================
         WHATSAPP JS + BACK TOP
         ========================================= -->

    <script>

        var _waOpen = false;


        function pristoWaToggle() {

            _waOpen = !_waOpen;


            var card =
                document.getElementById('pristoWaCard');

            var iWa =
                document.getElementById('pristoWaIconWa');

            var iX =
                document.getElementById('pristoWaIconX');


            if (_waOpen) {

                card.style.display = 'block';

                card.classList.add('wa-card-open');

                iWa.style.display = 'none';

                iX.style.display = 'block';

            } else {

                card.style.display = 'none';

                iWa.style.display = 'block';

                iX.style.display = 'none';

            }

        }


        /*
         * Close WhatsApp when clicking outside
         */

        document.addEventListener(
            'click',
            function (e) {

                var btn =
                    document.getElementById('pristoWaBtn');

                var card =
                    document.getElementById('pristoWaCard');


                if (
                    _waOpen &&
                    card &&
                    btn &&
                    !card.contains(e.target) &&
                    !btn.contains(e.target)
                ) {

                    pristoWaToggle();

                }

            }
        );


        /*
         * Back To Top
         */

        window.addEventListener(
            'scroll',
            function () {

                var b =
                    document.getElementById('pristoBackTop');


                if (!b) return;


                if (window.scrollY > 300) {

                    b.classList.add('btt-show');

                } else {

                    b.classList.remove('btt-show');

                }

            },
            {
                passive: true
            }
        );

    </script>

    {{-- Pristo AI Sales Agent Widget --}}
    <x-ai-chat-widget />

</body>

</html>