@php
    // You can add any PHP logic needed for the layout here.
@endphp
<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel – @yield('title', 'Dashboard')</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {font-family: 'Inter', sans-serif; margin:0; background: linear-gradient(135deg, #f0f4ff, #e8eaf6);}
        .sidebar {position:fixed; top:0; left:0; height:100vh; width:260px; background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); box-shadow: 2px 0 8px rgba(0,0,0,0.1); padding:2rem 1rem; overflow-y:auto;}
        .sidebar a {display:block; padding:0.75rem 1rem; margin-bottom:0.5rem; color:#333; border-radius:6px; text-decoration:none; font-weight:500; transition:background 0.2s, color 0.2s;}
        .sidebar a:hover {background:rgba(0,0,0,0.07); color:#111;}
        .content {margin-left:280px; padding:2rem; min-height:100vh;}
        .header {display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem;}
        .header h1 {font-size:1.8rem; font-weight:600;}
        .logout {font-size:0.9rem; color:#555; cursor:pointer;}
        @media(max-width:768px){ .sidebar{width:200px;} .content{margin-left:220px;} }
    </style>
</head>
<body>
    <nav class="sidebar">
        <h2 style="font-size:1.4rem; font-weight:600; margin-bottom:1rem; text-align:center;">Admin Panel</h2>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="{{ route('admin.room-spaces') }}">Room Spaces</a>
        <a href="{{ route('admin.products') }}">Products</a>
        <a href="{{ route('admin.categories') }}">Categories</a>
        <a href="{{ route('admin.banners') }}">Banner Sliders</a>
        <a href="{{ route('admin.brands') }}">Brands</a>
        <a href="{{ route('admin.orders') }}">Order Fulfillment</a>
        <a href="{{ route('admin.quotations') }}">Quotations Desk</a>
        <a href="{{ route('admin.visits') }}">Showroom Visits</a>
        <a href="{{ route('admin.coupons') }}">Coupons &amp; Promos</a>
        <a href="#">Website Settings</a>
        <a href="#">Reports &amp; Analytics</a>
        <a href="#">SEO Tools</a>
        <a href="#">User Roles</a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:1rem;">
            @csrf
            <button type="submit" class="logout">Logout</button>
        </form>
    </nav>
    <main class="content">
        <div class="header">
            <h1>@yield('title', 'Dashboard')</h1>
        </div>
        @yield('content')
    </main>
</body>
</html>
