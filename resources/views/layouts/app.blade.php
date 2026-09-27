<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', ''){{ View::hasSection('title') ? ' - ' : '' }}SIMPENDUK</title>
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
        }
        /* Custom scrollbar for sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background-color: #CBD5E1;
            border-radius: 20px;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-slate-50 selection:bg-blue-100 selection:text-blue-900">
    @auth
        <div class="flex h-screen overflow-hidden bg-slate-50" x-data="{ sidebarOpen: false }">
            
            <!-- Sidebar Backdrop -->
            <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-slate-900/80 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false" style="display: none;"></div>

            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-slate-200 transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-auto flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.02)]">
                <!-- Logo -->
                <div class="flex items-center justify-center h-24 border-b border-slate-100 px-4 bg-white/50 backdrop-blur-xl">
                    <img src="{{ asset('logo.png') }}" alt="SIMPENDUK Logo" class="h-20 w-auto object-contain drop-shadow-sm">
                </div>

                <!-- Navigation -->
                <div class="flex-1 overflow-y-auto sidebar-scroll py-6">
                    <nav class="px-4 space-y-1.5">
                        <div class="px-3 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Menu Utama</div>
                        
                        <a href="{{ route('dashboard') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 shadow-sm ring-1 ring-blue-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('penduduk.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('penduduk.*') ? 'bg-blue-50 text-blue-700 shadow-sm ring-1 ring-blue-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 transition-colors duration-200 {{ request()->routeIs('penduduk.*') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Data Penduduk
                        </a>

                        @if(auth()->user()->role === 'SuperAdmin' || auth()->user()->role === 'Admin')
                        <div class="px-3 mt-6 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Manajemen Wilayah</div>
                        <a href="{{ route('wilayah.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('wilayah.*') ? 'bg-emerald-50 text-emerald-700 shadow-sm ring-1 ring-emerald-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 transition-colors duration-200 {{ request()->routeIs('wilayah.*') ? 'text-emerald-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Data Wilayah
                        </a>
                        @endif

                        <div class="px-3 mt-6 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Pencatatan</div>
                        <a href="{{ route('kematian.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('kematian.*') ? 'bg-rose-50 text-rose-700 shadow-sm ring-1 ring-rose-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 transition-colors duration-200 {{ request()->routeIs('kematian.*') ? 'text-rose-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Data Kematian
                        </a>

                        @if(auth()->user()->role === 'SuperAdmin')
                        <div class="px-3 mt-6 mb-2 text-xs font-semibold text-slate-400 uppercase tracking-wider">Sistem</div>
                        <a href="{{ route('pengguna.index') }}" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('pengguna.*') ? 'bg-indigo-50 text-indigo-700 shadow-sm ring-1 ring-indigo-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="mr-3 h-5 w-5 transition-colors duration-200 {{ request()->routeIs('pengguna.*') ? 'text-indigo-600' : 'text-slate-400 group-hover:text-slate-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Data Pengguna
                        </a>
                        @endif
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-slate-50/50">
                <!-- Top Navbar -->
                <header class="bg-white/80 backdrop-blur-lg shadow-[0_1px_2px_rgba(0,0,0,0.03)] lg:static lg:overflow-y-visible z-10 border-b border-slate-200 sticky top-0">
                    <div class="px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
                        <div class="flex items-center justify-between h-20">
                            
                            <!-- Mobile Menu Button -->
                            <div class="flex items-center lg:hidden">
                                <button @click="sidebarOpen = true" class="text-slate-500 hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 rounded-lg p-2 bg-slate-50 hover:bg-slate-100 transition-colors">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="flex-1 flex justify-between items-center ml-4 lg:ml-0">
                                <div class="flex-1 flex items-center">
                                    <h1 class="text-xl font-bold text-slate-800 hidden sm:block">@yield('title')</h1>
                                </div>
                                <div class="ml-4 flex items-center md:ml-6">
                                    
                                    <!-- Profile dropdown -->
                                    <div class="relative ml-3" x-data="{ profileOpen: false }">
                                        <div>
                                            <button @click="profileOpen = !profileOpen" @click.away="profileOpen = false" class="flex items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 border border-slate-200 p-1.5 pr-4 shadow-sm hover:bg-slate-50 hover:border-slate-300 transition-all duration-200 group">
                                                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-blue-700 font-bold border border-blue-200 group-hover:border-blue-300 transition-colors">
                                                    {{ substr(auth()->user()->name, 0, 1) }}
                                                </div>
                                                <div class="ml-3 text-left hidden sm:block">
                                                    <p class="text-sm font-semibold text-slate-700 leading-none mb-1">{{ auth()->user()->name }}</p>
                                                    <p class="text-[10px] font-bold tracking-wider text-slate-400 uppercase leading-none">{{ auth()->user()->role }}</p>
                                                </div>
                                                <svg class="ml-2 h-4 w-4 text-slate-400 group-hover:text-slate-500 transition-colors hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <!-- Dropdown menu -->
                                        <div x-show="profileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95 translate-y-2" x-transition:enter-end="transform opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100 translate-y-0" x-transition:leave-end="transform opacity-0 scale-95 translate-y-2" class="absolute right-0 z-50 mt-3 w-56 origin-top-right rounded-xl bg-white shadow-xl ring-1 ring-black/5 focus:outline-none divide-y divide-slate-100" style="display: none;">
                                            <div class="px-4 py-3 sm:hidden">
                                                <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                                <p class="text-xs text-slate-500 truncate">{{ auth()->user()->role }}</p>
                                            </div>
                                            <div class="py-1">
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="group flex w-full items-center px-4 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                                                        <svg class="mr-3 h-5 w-5 text-red-400 group-hover:text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                        </svg>
                                                        Logout
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 relative z-0 overflow-y-auto focus:outline-none scroll-smooth">
                    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
                        @if (session('success'))
                            <div class="mb-6">
                                <x-alert type="success" :message="session('success')" />
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="mb-6">
                                <x-alert type="error" :message="session('error')" />
                            </div>
                        @endif

                        <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                            @yield('content')
                        </div>
                    </div>
                </main>
            </div>
        </div>
    @else
        @yield('content')
    @endauth
    @stack('scripts')
</body>
</html>
