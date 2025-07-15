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

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'gold': '#FFA500',
                        'gold-light': '#FFD700',
                        'gold-dark': '#FF8C00',
                    }
                }
            }
        }
    </script>

    @stack('styles')
</head>

<body class="bg-black text-yellow-500 min-h-screen">

    <div class="fixed inset-0 z-0">
        <div class="absolute inset-0 bg-gradient-to-br from-purple-900/30 via-blue-900/30 to-black/90"></div>
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80')] bg-cover bg-center opacity-20"></div>
    </div>

    <nav class="relative z-50 bg-black/80 backdrop-blur-sm border-b border-gold/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <div class="w-12 h-12 md:w-14 md:h-14 rounded-xl shadow-lg glow-effect bg-black flex items-center justify-center overflow-hidden border border-gold/20">
                            <img src="/ava.jpg" alt="Logo" class="w-full h-full object-cover rounded-xl" />
                        </div>
                        <span class="text-lg md:text-xl font-bold text-yellow-500">Mộng Huyền Giang Hồ</span>
                    </a>
                </div>

                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gold hover:text-gold-light transition-colors duration-200 font-medium">
                        <i class="fas fa-home mr-1"></i>
                        Trang Chủ
                    </a>
                    <a href="{{ route('user.transaction') }}" class="text-gold hover:text-gold-light transition-colors duration-200 font-medium">
                        Nạp thẻ
                    </a>
                    <a href="{{route('user.history')}}" class="text-gold hover:text-gold-light transition-colors duration-200 font-medium">
                        <i class="fas fa-sword mr-1"></i>
                        Lịch sử
                    </a>
                </div>

                <div class="flex items-center">
                    <div class="relative">
                        <button onclick="toggleUserMenu()" class="flex items-center text-gold hover:text-gold-light transition-colors duration-200">
                            <div class="w-8 h-8 bg-gradient-to-br from-gold to-gold-dark rounded-full flex items-center justify-center mr-2">
                                <i class="fas fa-user text-black text-sm"></i>
                            </div>
                            <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down ml-2"></i>
                        </button>

                        <div id="user-menu" class="hidden absolute right-0 mt-2 w-56 bg-black/90 border border-gold/20 rounded-lg shadow-xl z-20">
                            <div class="py-2">
                                <a href="#" class="block px-4 py-2 text-white hover:bg-gold/20 transition-colors">
                                    <i class="fas fa-user mr-2 text-gold"></i>
                                    Cập nhật tài khoản 
                                </a>
                                <a href="#" class="block px-4 py-2 text-white hover:bg-gold/20 transition-colors">
                                    <i class="fas fa-gem mr-2 text-gold"></i>
                                    Thay đổi mật khẩu
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="cursor-pointer">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-white hover:bg-gold/20 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-2 text-red-400"></i>
                                        Đăng Xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="md:hidden ml-2">
                        <button type="button" class="text-gold hover:text-gold-light" onclick="toggleMobileMenu()">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="hidden md:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1 border-t border-gold/20">
                    <a href="{{ route('home') }}" class="block px-3 py-2 text-gold hover:text-gold-light">
                        <i class="fas fa-home mr-1"></i> Trang Chủ
                    </a>
                    <a href="{{ route('user.transaction') }}" class="block px-3 py-2 text-gold hover:text-gold-light">
                        Nạp thẻ
                    </a>
                    <a href="#" class="block px-3 py-2 text-gold hover:text-gold-light">
                        Lịch sử
                    </a>
                    <div class="border-t border-gold/20 pt-2">
                        <div class="px-3 py-2 text-gold">
                            <i class="fas fa-user mr-1"></i> {{ auth()->user()->name }}
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 text-gold hover:text-gold-light">
                                <i class="fas fa-sign-out-alt mr-1"></i> Đăng Xuất
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="relative z-5 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="bg-green-900/50 border border-green-500 text-green-300 p-4 mb-6 rounded-lg flex items-center" role="alert">
                <i class="fas fa-check-circle mr-3"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="ml-auto text-green-300 hover:text-green-100" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-900/50 border border-red-500 text-red-300 p-4 mb-6 rounded-lg flex items-center" role="alert">
                <i class="fas fa-exclamation-circle mr-3"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="ml-auto text-red-300 hover:text-red-100" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <!-- <footer class="relative z-10 bg-black/80 border-t border-gold/20 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-gold font-bold text-lg mb-4">Mộng Huyền Giang Hồ</h3>
                    <p class="text-gray-400 text-sm">Thiên hạ đệ nhất bang - Khám phá thế giới võ lâm huyền bí</p>
                </div>
                <div>
                    <h4 class="text-gold font-semibold mb-4">Liên Kết</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-gold transition-colors">Trang Chủ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-gold transition-colors">Tin Tức</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-gold transition-colors">Hướng Dẫn</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-gold transition-colors">Hỗ Trợ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-gold font-semibold mb-4">Cộng Đồng</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="text-gray-400 hover:text-gold transition-colors">Facebook</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-gold transition-colors">Discord</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-gold transition-colors">YouTube</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-gold transition-colors">Forum</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-gold font-semibold mb-4">Tải Game</h4>
                    <div class="space-y-2">
                        <a href="#" class="block bg-gold/20 hover:bg-gold/30 text-gold px-4 py-2 rounded text-sm transition-colors">
                            <i class="fab fa-android mr-2"></i>Android
                        </a>
                        <a href="#" class="block bg-gold/20 hover:bg-gold/30 text-gold px-4 py-2 rounded text-sm transition-colors">
                            <i class="fab fa-apple mr-2"></i>iOS
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gold/20 mt-8 pt-8 text-center text-gray-400 text-sm">
                <p>© 2024 Mộng Huyền Giang Hồ. Tất cả quyền được bảo lưu.</p>
            </div>
        </div>
    </footer> -->

    @stack('scripts')

    <script>
        function toggleUserMenu() {
            const userMenu = document.getElementById('user-menu');
            userMenu.classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('user-menu');
            const mobileMenu = document.getElementById('mobile-menu');

            if (!event.target.closest('#user-menu') && !event.target.closest('button[onclick*="toggleUserMenu"]')) {
                userMenu.classList.add('hidden');
            }

            if (!event.target.closest('#mobile-menu') && !event.target.closest('button[onclick*="toggleMobileMenu"]')) {
                mobileMenu.classList.add('hidden');
            }
        });

        // Auto-hide flash messages after 5 seconds
        setTimeout(() => {
            document.querySelectorAll('[role="alert"]').forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>

</html>