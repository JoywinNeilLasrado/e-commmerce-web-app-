<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PhoneShop — Premium Refurbished Phones')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        html { scroll-behavior: smooth; }
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: #2563eb; transition: width 0.3s ease; }
        .nav-link:hover::after { width: 100%; }
        .nav-link.active::after { width: 100%; }
        .dropdown-menu { transform-origin: top right; }
        .glass { background: rgba(255,255,255,0.85); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        .product-card-img { transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .product-card:hover .product-card-img { transform: scale(1.08); }
    </style>
</head>
<body class="bg-white text-gray-900 antialiased">

    <!-- Smart Navbar -->
    <nav id="smart-navbar" class="glass border-b border-gray-100/80 sticky top-0 z-50 transition-all duration-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-18 py-4">

                <!-- Logo + Nav Links -->
                <div class="flex items-center gap-10">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-md shadow-blue-600/30 group-hover:shadow-blue-600/50 transition-shadow">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-lg font-bold text-gray-900 tracking-tight">Phone<span class="text-blue-600">Shop</span></span>
                    </a>

                    <div class="hidden md:flex items-center gap-8">
                        <a href="{{ route('home') }}" class="nav-link text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors {{ request()->routeIs('home') ? 'active text-gray-900' : '' }}">Home</a>
                        <a href="{{ route('products.index') }}" class="nav-link text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors {{ request()->routeIs('products.*') ? 'active text-gray-900' : '' }}">Shop</a>
                        <a href="{{ route('compare.index') }}" class="nav-link text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors {{ request()->routeIs('compare.*') ? 'active text-gray-900' : '' }}">Compare</a>
                        <a href="{{ route('home') }}#sell" class="nav-link text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Sell</a>
                    </div>

                </div>

                <!-- Search + Actions -->
                <div class="flex items-center gap-4">
                    <!-- Search Bar -->
                    <form action="{{ route('products.index') }}" method="GET" class="hidden md:flex items-center">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Search phones..."
                                   class="w-52 lg:w-64 bg-gray-50 border border-gray-200 rounded-xl py-2.5 pl-10 pr-4 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 focus:bg-white transition-all duration-300">
                            <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </form>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative p-2.5 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all duration-200 group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        <span class="absolute -top-0.5 -right-0.5 bg-blue-600 text-white text-[9px] font-bold min-w-[18px] h-[18px] flex items-center justify-center rounded-full shadow-sm">
                            {{ auth()->check() && auth()->user()->cart ? auth()->user()->cart->items->sum('quantity') : 0 }}
                        </span>
                    </a>

                    <!-- User Menu -->
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-2.5 pl-3 pr-4 py-2 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl transition-all duration-200">
                                <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-700 hidden md:block">{{ explode(' ', auth()->user()->name)[0] }}</span>
                                <svg class="w-3.5 h-3.5 text-gray-400 transition-transform group-hover:rotate-180 duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <!-- Dropdown -->
                            <div class="dropdown-menu absolute right-0 mt-2 w-52 bg-white border border-gray-100 rounded-2xl shadow-xl shadow-gray-200/60 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="px-4 py-3 border-b border-gray-50">
                                    <p class="text-xs text-gray-400 font-medium">Signed in as</p>
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Your Profile
                                </a>
                                <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    My Orders
                                </a>
                                @role('admin')
                                    <div class="border-t border-gray-50 mt-1 pt-1">
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-semibold text-blue-600 hover:bg-blue-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                            Admin Panel
                                        </a>
                                    </div>
                                @endrole
                                <div class="border-t border-gray-50 mt-1 pt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="hidden sm:flex items-center gap-3">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors px-3 py-2">Log in</a>
                            <a href="{{ route('register') }}" class="btn-ripple text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-5 py-2.5 rounded-xl transition-all duration-200 shadow-md shadow-blue-600/25 hover:shadow-blue-600/40 hover:scale-105 active:scale-95">
                                Sign up
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success') || session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-950 text-gray-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- Brand -->
                <div class="md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-white font-bold text-lg">Phone<span class="text-blue-400">Shop</span></span>
                    </div>
                    <p class="text-sm leading-relaxed text-gray-500">Premium refurbished smartphones. Every device tested, certified, and backed by our 12-month warranty.</p>
                </div>

                <!-- Shop -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-5">Shop</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('products.index') }}" class="text-sm hover:text-white transition-colors">All Phones</a></li>
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Apple iPhones</a></li>
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Samsung Galaxy</a></li>
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Best Deals</a></li>
                    </ul>
                </div>

                <!-- Support -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-5">Support</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Warranty Policy</a></li>
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Returns & Refunds</a></li>
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Shipping Info</a></li>
                        <li><a href="#" class="text-sm hover:text-white transition-colors">Contact Us</a></li>
                    </ul>
                </div>

                <!-- Account -->
                <div>
                    <h4 class="text-white font-semibold text-sm mb-5">Account</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('profile.edit') }}" class="text-sm hover:text-white transition-colors">Your Profile</a></li>
                        <li><a href="{{ route('orders.index') }}" class="text-sm hover:text-white transition-colors">Order History</a></li>
                        <li><a href="{{ route('login') }}" class="text-sm hover:text-white transition-colors">Sign In</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-600">&copy; {{ date('Y') }} PhoneShop. All rights reserved.</p>
                <div class="flex items-center gap-6 text-xs text-gray-600">
                    <a href="#" class="hover:text-gray-400 transition-colors">Privacy Policy</a>
                    <a href="#" class="hover:text-gray-400 transition-colors">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>