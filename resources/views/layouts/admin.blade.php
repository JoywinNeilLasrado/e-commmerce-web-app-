<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 antialiased">
    <!-- Admin Navbar -->
    <nav class="bg-white/90 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-18">
                <!-- Logo -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
                        <div class="w-9 h-9 bg-gray-900 rounded-xl flex items-center justify-center shadow-lg shadow-gray-900/20 group-hover:scale-105 transition-transform duration-200">
                            <span class="text-white font-bold text-lg">A</span>
                        </div>
                        <span class="text-xl font-bold text-gray-900 tracking-tight">PhoneShop <span class="text-gray-400 font-medium">Admin</span></span>
                    </a>
                    
                    <!-- Main Navigation -->
                    <div class="hidden md:flex items-center gap-0.5">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900 text-white shadow-md shadow-gray-900/10' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.products.index') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-gray-900 text-white shadow-md shadow-gray-900/10' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Products
                        </a>
                        <a href="{{ route('admin.brands.index') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.brands.*') ? 'bg-gray-900 text-white shadow-md shadow-gray-900/10' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Brands
                        </a>
                        <a href="{{ route('admin.orders.index') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-900 text-white shadow-md shadow-gray-900/10' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Orders
                        </a>
                         <a href="{{ route('admin.users.index') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gray-900 text-white shadow-md shadow-gray-900/10' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Users
                        </a>
                        <a href="{{ route('admin.reports.index') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.reports.*') ? 'bg-gray-900 text-white shadow-md shadow-gray-900/10' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Reports
                        </a>
                        <a href="{{ route('admin.reviews.index') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.reviews.*') ? 'bg-gray-900 text-white shadow-md shadow-gray-900/10' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Reviews
                        </a>
                        <a href="{{ route('admin.activity-logs.index') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.activity-logs.*') ? 'bg-gray-900 text-white shadow-md shadow-gray-900/10' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Logs
                        </a>
                        <a href="{{ route('admin.support.index') }}" 
                           class="px-3 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200 {{ request()->routeIs('admin.support.*') ? 'bg-gray-900 text-white shadow-md shadow-gray-900/10' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                            Support Pages
                        </a>
                    </div>
                </div>
                
                <!-- Right Side Actions -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" target="_blank" class="group flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors bg-gray-50 hover:bg-blue-50 px-3 py-1.5 rounded-full border border-gray-200 hover:border-blue-200">
                        <span>View Store</span>
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    
                    <div class="h-6 w-px bg-gray-200"></div>

                    <div class="relative group">
                        <button class="flex items-center gap-3 pl-2 pr-1 py-1 rounded-full hover:bg-gray-50 transition-colors focus:outline-none">
                            <div class="w-8 h-8 bg-gradient-to-br from-gray-700 to-gray-900 rounded-full flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                            </div>
                            <div class="text-left hidden sm:block">
                                <p class="text-sm font-semibold text-gray-900 leading-none">{{ auth()->user()->name ?? 'Admin' }}</p>
                                <p class="text-[10px] text-gray-500 font-medium leading-none mt-0.5">Administrator</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <!-- Dropdown -->
                        <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50">
                            <div class="px-4 py-3 border-b border-gray-50">
                                <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Signed in as</p>
                                <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->email ?? '' }}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Edit Profile
                                </a>
                            </div>
                            <div class="border-t border-gray-50 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <main>
        <!-- Flash Messages (Animated Toast UI) -->
        <div id="toast-container" class="fixed top-5 left-1/2 flex flex-col gap-3 w-full max-w-md px-4 pointer-events-none" style="z-index: 9999; transform: translateX(-50%);">
            @if(session('success'))
                <div class="toast-message flex items-center gap-3 bg-white/95 backdrop-blur-md border border-green-200 text-green-800 rounded-2xl px-5 py-4 text-sm font-medium shadow-2xl pointer-events-auto" style="opacity: 0; transform: translateY(-20px); transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);">
                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="flex-1">{{ session('success') }}</div>
                    <button onclick="this.parentElement.style.opacity='0'; this.parentElement.style.transform='translateY(-20px)'; setTimeout(() => this.parentElement.remove(), 500);" class="text-green-500 hover:text-green-700 transition-colors p-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif
            @if(session('error'))
                <div class="toast-message flex items-center gap-3 bg-white/95 backdrop-blur-md border border-red-200 text-red-800 rounded-2xl px-5 py-4 text-sm font-medium shadow-2xl pointer-events-auto" style="opacity: 0; transform: translateY(-20px); transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);">
                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 00-1.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="flex-1">{{ session('error') }}</div>
                     <button onclick="this.parentElement.style.opacity='0'; this.parentElement.style.transform='translateY(-20px)'; setTimeout(() => this.parentElement.remove(), 500);" class="text-red-500 hover:text-red-700 transition-colors p-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif
            @if($errors->any())
                <div class="toast-message flex items-start gap-3 bg-white/95 backdrop-blur-md border border-red-200 text-red-800 rounded-2xl px-5 py-4 text-sm font-medium shadow-2xl pointer-events-auto" style="opacity: 0; transform: translateY(-20px); transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);">
                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 00-1.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    </div>
                    <div class="flex-1">
                        <span class="font-bold block mb-1">Please correct the following errors:</span>
                        <ul class="list-disc list-inside space-y-1 ml-1 text-gray-600">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                     <button onclick="this.parentElement.style.opacity='0'; this.parentElement.style.transform='translateY(-20px)'; setTimeout(() => this.parentElement.remove(), 500);" class="text-red-500 hover:text-red-700 transition-colors p-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif
        </div>

        @yield('content')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toast Notifications Animation
            const toasts = document.querySelectorAll('.toast-message');
            toasts.forEach((toast, index) => {
                // Animate in
                setTimeout(() => {
                    toast.style.opacity = '1';
                    toast.style.transform = 'translateY(0)';
                }, 100 + (index * 150));

                // Setup auto-hide after 5 seconds
                setTimeout(() => {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(-20px)';
                    setTimeout(() => toast.remove(), 500);
                }, 5000 + (index * 150));
            });
        });
    </script>
</body>
</html>
