<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mộng Huyền Giang Hồ')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .glow-effect {
            box-shadow: 0 0 20px rgba(255, 193, 7, 0.3);
        }
        
        .btn-gradient {
            background: linear-gradient(45deg, #fbbf24, #f59e0b);
            transition: all 0.3s ease;
        }
        
        .btn-gradient:hover {
            background: linear-gradient(45deg, #f59e0b, #d97706);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(251, 191, 36, 0.4);
        }
        
        .floating-content {
            transform: translateY(-50px);
            z-index: 10;
        }
    </style>

    @stack('styles')
</head>

<body class="min-h-screen flex flex-col bg-gray-900 text-white">
    <!-- Navigation for Guest -->
    <nav class="bg-black opacity-85 text-yellow-400 relative z-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 md:justify-center">
                <div class="flex items-center justify-center">
                    <div class="hidden md:flex md:items-center">
                        <a href="{{ route('home') }}" class="flex items-center text-xl font-bold">
                            <i class="fas fa-home mr-2 hover:text-yellow-300"></i>
                        </a>
                        <a href="{{ route('news') }}" class="flex items-center px-3 py-2 text-yellow-400 font-bold hover:text-yellow-300">
                            Tin tức
                        </a>
                        <a href="{{ route('events') }}" class="flex items-center px-3 py-2 text-yellow-400 font-bold hover:text-yellow-300">
                            Sự kiện
                        </a>
                        <a href="{{ route('home') }}" class="flex items-center px-3 py-2 text-yellow-400 font-bold hover:text-yellow-300">
                            Hướng dẫn
                        </a>
                        <a href="{{ route('home') }}" class="flex items-center px-3 py-2 text-yellow-400 font-bold hover:text-yellow-300">
                            Fanpage
                        </a>
                        <a href="{{ route('home') }}" class="flex items-center px-3 py-2 text-yellow-400 font-bold hover:text-yellow-300">
                            Group
                        </a>

                         <a href="{{ route('register') }}" class="flex items-center px-3 py-2 text-yellow-400 font-bold hover:text-yellow-300">
                            Đăng ký
                        </a>
                        <a href="{{ route('login') }}" class="flex items-center px-3 py-2 text-yellow-400 font-bold hover:text-yellow-300">
                            Đăng nhập
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button type="button" class="p-2 text-yellow-400 hover:text-yellow-300"
                            onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="hidden md:hidden" id="mobile-menu">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center px-3 py-2 text-yellow-400 hover:text-yellow-300">
                        <i class="fas fa-home mr-1"></i> Home
                    </a>
                    <a href="{{ route('login') }}" class="flex items-center px-3 py-2 text-yellow-400 hover:text-yellow-300">
                        <i class="fas fa-sign-in-alt mr-1"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center px-3 py-2 text-yellow-400 hover:text-yellow-300">
                        <i class="fas fa-user-plus mr-1"></i> Register
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        <div class="w-full mx-auto">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 flex items-center" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="ml-auto text-green-700 hover:text-green-900"
                        onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 flex items-center" role="alert">
                    <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                    <button type="button" class="ml-auto text-red-700 hover:text-red-900"
                        onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-amber-900 text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center text-center gap-4">
                <div class="flex items-center">
                    <i class="fas fa-dragon text-yellow-400 mr-2"></i>
                    <span class="text-sm">© {{ date('Y') }} Mộng Huyền Giang Hồ. Tất cả quyền được bảo lưu.</span>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-yellow-400 hover:text-yellow-300 transition-colors">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-yellow-400 hover:text-yellow-300 transition-colors">
                        <i class="fab fa-youtube text-xl"></i>
                    </a>
                    <a href="#" class="text-yellow-400 hover:text-yellow-300 transition-colors">
                        <i class="fab fa-discord text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>