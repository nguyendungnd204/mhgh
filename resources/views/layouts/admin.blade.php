<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Laravel App')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 min-h-screen flex flex-col">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">
                    <i class="fas fa-shield-alt mr-2"></i> Admin Panel
                </a>
            </div>
            
            <!-- Navigation Menu -->
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                </a>
                
                <a href="{{ route('admin.dashboard') ?? '#' }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors {{ request()->routeIs('admin.users*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-users mr-3"></i> Users Management
                </a>
                
                <a href="{{ route('admin.dashboard') ?? '#' }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors {{ request()->routeIs('admin.posts*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-newspaper mr-3"></i> Posts Management
                </a>
                
                <a href="{{ route('admin.dashboard') ?? '#' }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors {{ request()->routeIs('admin.categories*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-tags mr-3"></i> Categories
                </a>
                
                <a href="{{ route('admin.dashboard') ?? '#' }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors {{ request()->routeIs('admin.settings*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-cog mr-3"></i> Settings
                </a>
                
                <a href="{{ route('admin.dashboard') ?? '#' }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors {{ request()->routeIs('admin.reports*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-chart-bar mr-3"></i> Reports
                </a>
                
                <div class="border-t border-gray-700 pt-4 mt-4">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                        <i class="fas fa-home mr-3"></i> Back to Website
                    </a>
                </div>
            </nav>
            
            <!-- User Info & Logout -->
            <div class="border-t border-gray-700 p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-gray-300"></i>
                        </div>
                    </div>
                    <div class="ml-3">
                        <div class="text-sm font-medium text-white">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-gray-400">Administrator</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                        <i class="fas fa-sign-out-alt mr-3"></i> Logout
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Mobile Sidebar Overlay -->
        <div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>
        
        <!-- Mobile Sidebar -->
        <div id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800 transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden">
            <!-- Mobile sidebar content (same as desktop) -->
            <div class="flex items-center justify-between h-16 bg-gray-900 px-4">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-white">
                    <i class="fas fa-shield-alt mr-2"></i> Admin Panel
                </a>
                <button id="close-mobile-sidebar" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                </a>
                <a href="{{ route('admin.dashboard') ?? '#' }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-users mr-3"></i> Users Management
                </a>
                <a href="{{ route('admin.dashboard') ?? '#' }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-newspaper mr-3"></i> Posts Management
                </a>
                <a href="{{ route('admin.dashboard') ?? '#' }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-tags mr-3"></i> Categories
                </a>
                <a href="{{ route('admin.dashboard') ?? '#' }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-cog mr-3"></i> Settings
                </a>
                <a href="{{ route('admin.dashboard') ?? '#' }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                    <i class="fas fa-chart-bar mr-3"></i> Reports
                </a>
                <div class="border-t border-gray-700 pt-4 mt-4">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md transition-colors">
                        <i class="fas fa-home mr-3"></i> Back to Website
                    </a>
                </div>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <!-- Mobile menu button -->
                            <button id="mobile-menu-button" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                                <i class="fas fa-bars"></i>
                            </button>
                            <h1 class="text-2xl font-semibold text-gray-900 ml-2 lg:ml-0">@yield('page-title', 'Admin Dashboard')</h1>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative">
                                <button class="p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 rounded-full">
                                    <i class="fas fa-bell"></i>
                                    <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                                </button>
                            </div>
                            
                            <!-- Quick actions -->
                            <div class="text-sm text-gray-500">
                                Welcome back, <span class="font-medium text-gray-900">{{ auth()->user()->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 flex items-center rounded-md" role="alert">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="ml-auto text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 flex items-center rounded-md" role="alert">
                            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                            <button type="button" class="ml-auto text-red-700 hover:text-red-900" onclick="this.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    @stack('scripts')
    
    <!-- Mobile Sidebar Toggle Script -->
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileSidebar = document.getElementById('mobile-sidebar');
        const mobileSidebarOverlay = document.getElementById('mobile-sidebar-overlay');
        const closeMobileSidebar = document.getElementById('close-mobile-sidebar');
        
        function openMobileSidebar() {
            mobileSidebar.classList.remove('-translate-x-full');
            mobileSidebarOverlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeMobileSidebarFunc() {
            mobileSidebar.classList.add('-translate-x-full');
            mobileSidebarOverlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        mobileMenuButton.addEventListener('click', openMobileSidebar);
        closeMobileSidebar.addEventListener('click', closeMobileSidebarFunc);
        mobileSidebarOverlay.addEventListener('click', closeMobileSidebarFunc);
    </script>
</body>
</html>