<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Refurbished Phones Shop')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-900 font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">
                        📱 PhoneShop
                    </a>
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('products.index') ? 'border-indigo-500 text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }} text-sm font-medium">
                            Shop Phones
                        </a>
                        <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                            Brands
                        </a>
                        <a href="#" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                            Sell Your Phone
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <div class="hidden sm:flex sm:items-center">
                         <form action="{{ route('products.index') }}" method="GET" class="relative group">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search models..." class="w-48 lg:w-64 bg-gray-50 border-gray-200 focus:bg-white focus:ring-indigo-500 focus:border-indigo-500 text-sm rounded-full py-2 px-4 transition-all">
                            <button type="submit" class="absolute right-3 top-2.5 text-gray-400 group-hover:text-indigo-500">
                                🔍
                            </button>
                        </form>
                    </div>

                    <a href="{{ route('cart.index') }}" class="text-gray-500 hover:text-indigo-600 relative p-1 group">
                        <span class="text-xl">🛒</span>
                        <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full group-hover:animate-bounce">
                            {{ auth()->check() && auth()->user()->cart ? auth()->user()->cart->items->sum('quantity') : 0 }}
                        </span>
                    </a>

                    @auth
                        <div class="hidden sm:flex sm:items-center ml-2 border-l pl-6 space-x-4">
                            <div class="relative group">
                                <button class="flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 focus:outline-none transition">
                                    <span>{{ auth()->user()->name }}</span>
                                    <svg class="ml-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                        <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                    </svg>
                                </button>
                                <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-lg shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">Your Profile</a>
                                    <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">Order History</a>
                                    @role('admin')
                                        <hr class="my-1 border-gray-100">
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm font-bold text-indigo-600 hover:bg-indigo-50">Admin Panel</a>
                                    @endrole
                                    <hr class="my-1 border-gray-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Log Out</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="hidden sm:flex sm:items-center space-x-4">
                            <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">Log in</a>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition">Sign up</a>
                        </div>
                    @endauth

                    <!-- Mobile menu button -->
                    <div class="flex items-center sm:hidden">
                        <button type="button" class="text-gray-400 hover:text-gray-500 hover:bg-gray-100 p-2 rounded-md">
                            ☰
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0 text-green-400">✅</div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0 text-red-400">❌</div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Shop</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="{{ route('products.index') }}" class="text-base text-gray-500 hover:text-indigo-600">All Phones</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Certified Refurbished</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Support</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Warranty Policy</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Shipping Info</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Returns</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Company</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">About Us</a></li>
                        <li><a href="#" class="text-base text-gray-500 hover:text-indigo-600">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Account</h3>
                    <ul class="mt-4 space-y-4">
                        <li><a href="{{ route('profile.edit') }}" class="text-base text-gray-500 hover:text-indigo-600">Your Profile</a></li>
                        <li><a href="{{ route('orders.index') }}" class="text-base text-gray-500 hover:text-indigo-600">Order History</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-200 pt-8 flex items-center justify-between">
                <p class="text-base text-gray-400">&copy; {{ date('Y') }} PhoneShop Refurbished. All rights reserved.</p>
                <div class="flex space-x-6 text-2xl grayscale opacity-50">
                    💳 🏦 📦
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
