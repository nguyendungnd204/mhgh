<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laravel App')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @stack('styles')
</head>
<body>
    <!-- Navigation for Authenticated Users -->
    <nav class="bg-green-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <a href="{{ route('dashboard') }}" class="flex items-center text-xl font-bold">
                        <i class="fas fa-tachometer-alt mr-2"></i> Laravel App
                    </a>
                </div>
                
                <div class="flex items-center">
                    <div class="hidden md:flex md:items-center">
                        <a href="{{ route('home') }}" class="flex items-center px-3 py-2 text-white hover:text-gray-200">
                            <i class="fas fa-home mr-1"></i> Home
                        </a>
                        <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-white hover:text-gray-200">
                            <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-white hover:text-gray-200">
                                <i class="fas fa-cog mr-1"></i> Admin Panel
                            </a>
                        @endif
                        <div class="relative">
                            <button onclick="document.getElementById('user-menu').classList.toggle('hidden')"
                                    class="flex items-center px-3 py-2 text-white hover:text-gray-200">
                                <i class="fas fa-user mr-1"></i> {{ auth()->user()->name }}
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-800 Hover:bg-gray-100">
                                        <i class="fas fa-cog mr-2"></i> Admin Panel
                                    </a>
                                @endif
                                <hr class="border-gray-200">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button" class="p-2 text-white hover:text-gray-200" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Mobile menu -->
            <div class="hidden md:hidden" id="mobile-menu">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center px-3 py-2 text-white hover:text-gray-200">
                        <i class="fas fa-home mr-1"></i> Home
                    </a>
                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-white hover:text-gray-200">
                        <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                    </a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-white hover:text-gray-200">
                            <i class="fas fa-cog mr-1"></i> Admin Panel
                        </a>
                    @endif
                    <a href="#" class="flex items-center px-3 py-2 text-white hover:text-gray-200">
                        <i class="fas fa-user mr-1"></i> {{ auth()->user()->name }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center px-3 py-2 text-white hover:text-gray-200">
                            <i class="fas fa-sign-out-alt mr-1"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 flex items-center" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="ml-auto text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 flex items-center" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                    <button type="button" class="ml-auto text-red-700 hover:text-red-900" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 py-4 mt-5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between">
                <p class="mb-0">© {{ date('Y') }} Laravel App. All rights reserved.</p>
                <p class="mb-0">Built with Laravel & Tailwind CSS</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>