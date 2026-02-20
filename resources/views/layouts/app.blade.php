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

    <!-- Premium Navbar -->
    <nav id="smart-navbar" class="bg-white border-b border-gray-200 fixed top-0 w-full z-50 h-20" style="overflow: visible;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 overflow-visible">
            <div class="flex justify-between items-center h-full overflow-visible">

                <!-- Left Side: Logo + Nav Links -->
                <div class="flex items-center gap-8">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-600/20 group-hover:scale-105 transition-transform duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900 tracking-tight">Phone<span class="text-blue-600">Shop</span></span>
                    </a>

                    <!-- Main Navigation (Desktop) -->
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('home') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                            Home
                        </a>
                        <a href="{{ route('products.index') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                            Shop
                        </a>
                        <a href="{{ route('compare.index') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('compare.*') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                            Compare
                        </a>
                        <a href="{{ route('sell') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('sell') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                            Sell
                        </a>
                    </div>
                </div>

                <!-- Right Side: Search + Actions -->
                <div class="flex items-center gap-5 overflow-visible">
                    
                    <!-- Search Bar -->
                    <form action="{{ route('products.index') }}" method="GET" class="hidden lg:block">
                        <div class="relative group">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Search phones..."
                                   class="w-64 bg-gray-50 border border-gray-200 rounded-full py-2 pl-10 pr-4 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 focus:bg-white transition-all duration-300">
                            <svg class="absolute left-3.5 top-2.5 w-4 h-4 text-gray-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </form>

                    <div class="h-6 w-px bg-gray-200 hidden md:block"></div>

                    <!-- Wishlist -->
                    <a href="{{ route('wishlist.index') }}" class="relative group p-2 text-gray-500 hover:text-red-500 transition-colors">
                        <div class="absolute inset-0 bg-red-50 rounded-full scale-0 group-hover:scale-100 transition-transform duration-200"></div>
                        <svg class="relative w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        @auth
                            @if(auth()->user()->wishlists()->count() > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold min-w-[18px] h-[18px] flex items-center justify-center rounded-full shadow-sm ring-2 ring-white">
                                    {{ auth()->user()->wishlists()->count() }}
                                </span>
                            @endif
                        @endauth
                    </a>

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="relative group p-2 text-gray-500 hover:text-blue-600 transition-colors">
                        <div class="absolute inset-0 bg-blue-50 rounded-full scale-0 group-hover:scale-100 transition-transform duration-200"></div>
                        <svg class="relative w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        @if(auth()->check() && auth()->user()->cart && auth()->user()->cart->items->sum('quantity') > 0)
                            <span class="absolute -top-1 -right-1 bg-blue-600 text-white text-[10px] font-bold min-w-[18px] h-[18px] flex items-center justify-center rounded-full shadow-sm ring-2 ring-white">
                                {{ auth()->user()->cart->items->sum('quantity') }}
                            </span>
                        @endif
                    </a>

                    <!-- Mobile Profile Icon (Visible on ID/Mobile) -->
                    @auth
                        <a href="{{ route('profile.edit') }}" class="md:hidden flex items-center justify-center w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full text-white text-xs font-bold shadow-md shadow-blue-500/20">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="md:hidden p-2 text-gray-500 hover:text-blue-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" type="button" class="md:hidden p-2 text-gray-500 hover:text-gray-900 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- User Menu (Desktop) -->
                    @auth
                        <div class="relative group pl-2 hidden md:block">
                            <button class="flex items-center gap-3 py-1 rounded-full hover:bg-gray-50 transition-colors focus:outline-none">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-md shadow-blue-500/20">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="text-left hidden md:block">
                                    <p class="text-sm font-semibold text-gray-900 leading-none">{{ explode(' ', auth()->user()->name)[0] }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            <!-- Dropdown -->
                            <div class="absolute right-0 mt-2 w-60 bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50">
                                <!-- Invisible bridge -->
                                <div class="absolute -top-4 inset-x-0 h-4 bg-transparent"></div>
                                <div class="px-5 py-3 border-b border-gray-50">
                                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-0.5">Signed in as</p>
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                
                                <div class="py-1.5">
                                    <a href="{{ route('profile.edit') }}" class="group flex items-center gap-3 px-5 py-2.5 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50/50 transition-colors">
                                        <div class="w-8 h-8 rounded-lg bg-gray-50 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600 flex items-center justify-center transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </div>
                                        <div>
                                            <p class="font-medium">My Profile</p>
                                            <p class="text-xs text-gray-400">Account settings</p>
                                        </div>
                                    </a>
                                    
                                    <a href="{{ route('orders.index') }}" class="group flex items-center gap-3 px-5 py-2.5 text-sm text-gray-600 hover:text-blue-600 hover:bg-blue-50/50 transition-colors">
                                        <div class="w-8 h-8 rounded-lg bg-gray-50 text-gray-500 group-hover:bg-blue-100 group-hover:text-blue-600 flex items-center justify-center transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                        </div>
                                        <div>
                                            <p class="font-medium">My Orders</p>
                                            <p class="text-xs text-gray-400">Track purchases</p>
                                        </div>
                                    </a>
                                </div>

                                @role('admin')
                                    <div class="px-3 py-2">
                                        <a href="{{ route('admin.dashboard') }}" class="block w-full text-center bg-gray-900 hover:bg-black text-white text-sm font-medium py-2 rounded-lg transition-colors shadow-lg shadow-gray-900/20">
                                            Admin Dashboard
                                        </a>
                                    </div>
                                @endrole

                                <div class="border-t border-gray-50 mt-1 pt-1 mb-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-5 py-2.5 text-sm text-red-500 hover:bg-red-50 transition-colors flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="hidden sm:flex items-center gap-4">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Log in</a>
                            <a href="{{ route('register') }}" class="group relative px-5 py-2.5 rounded-full bg-gray-900 text-white text-sm font-medium shadow-lg shadow-gray-900/20 hover:shadow-gray-900/30 hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
                                <span class="relative z-10">Sign up</span>
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-blue-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
            
            <!-- Mobile Menu hidden by default -->
            <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
                <div class="px-4 py-3 space-y-3">
                    <form action="{{ route('products.index') }}" method="GET" class="mb-4">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Search phones..."
                                   class="w-full bg-gray-50 border border-gray-200 rounded-lg py-2 pl-10 pr-4 text-sm focus:outline-none focus:border-blue-500">
                            <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                    </form>
                    
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Home</a>
                    <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('products.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Shop</a>
                    <a href="{{ route('compare.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('compare.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Compare</a>
                    <a href="{{ route('sell') }}" class="block px-3 py-2 rounded-lg text-base font-medium {{ request()->routeIs('sell') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">Sell</a>
                    
                    <div class="border-t border-gray-100 my-2"></div>
                    
                    @auth
                        <div class="px-3 py-2">
                            <div class="font-medium text-base text-gray-800">{{ auth()->user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">My Profile</a>
                        <a href="{{ route('orders.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">My Orders</a>
                        <a href="{{ route('wishlist.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                             My Wishlist 
                             @if(auth()->user()->wishlists()->count() > 0)
                                <span class="ml-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">{{ auth()->user()->wishlists()->count() }}</span>
                             @endif
                        </a>
                        
                        @role('admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Admin Dashboard</a>
                        @endrole
                        
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 rounded-lg text-base font-medium text-red-600 hover:bg-red-50">Sign Out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Log in</a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900">Sign up</a>
                    @endauth
                </div>
            </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success') || session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-24">
            @if(session('success'))
                <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 00-1.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl px-5 py-4 text-sm font-medium shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 00-1.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        <span class="font-bold">Please correct the following errors:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-1 ml-8">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen @yield('main-classes')">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    mobileMenu.classList.toggle('hidden');
                    console.log('Mobile menu toggled'); // Debugging
                });

                // Close menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (!mobileMenu.contains(e.target) && !mobileMenuBtn.contains(e.target) && !mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            } else {
                console.error('Mobile menu elements not found');
            }
        });
    </script>
</body>
</html>