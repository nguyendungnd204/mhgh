@extends('layouts.guest')

@section('title', 'Trang chủ')

@push('styles')
<style>
    .hero-bg {
        background-image: url('/bg3.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        position: relative;
        height: 70vh; /* Adjusted height as per provided file */
        width: 100vw; /* Full width */
    }
    
    .hero-overlay {
        background: linear-gradient(45deg, rgba(0,0,0,0.7), rgba(102,51,153,0.3));
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: flex-end; /* Align content to the bottom */
        justify-content: center;
        padding-bottom: 20px; /* Add some padding at the bottom */
    }

    .floating-content {
        margin-top: 40px; /* Move the news section down as per provided file */
        z-index: 10;
    }

    .content-container {
        display: flex;
        flex-direction: row;
        gap: 20px;
        align-items: stretch; /* Ensure equal height for children */
    }

    .sidebar, .main-content {
        flex: 1; /* Each takes 50% of the container width */
        min-width: 0; /* Prevent overflow */
    }

    .hot-event-image {
        width: 100%;
        height: 100%; /* Fill the container height */
        object-fit: cover; /* Ensure image covers the area without distortion */
        border-radius: 12px; /* Match glass-effect rounded corners */
        border: 1px solid rgba(255, 255, 255, 0.2); /* Match glass-effect border */
    }

    .sidebar .glass-effect, .main-content .glass-effect {
        height: 100%; /* Ensure both sections are the same height */
        display: flex;
        flex-direction: column;
    }

    @media (max-width: 768px) {
        .content-container {
            flex-direction: column;
        }
        .sidebar {
            margin-bottom: 20px;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section với Background Image -->
    <div class="hero-bg relative overflow-hidden">
        <div class="hero-overlay">
            <!-- Game Logo và Thông tin -->
            <div class="text-center z-10 p-4 w-full">
                <div class="flex flex-col md:flex-row items-center justify-center mb-6">
                    <div class="w-20 h-20 mb-4 md:mb-0 md:mr-6 flex items-center justify-center glow-effect ">
                        <img src="/ava.jpg" alt="Logo" class="w-full h-full object-cover rounded-xl" />
                    </div>
                    <div>
                        <h1 class="text-2xl md:text-4xl font-bold text-yellow-400 drop-shadow-lg">Mộng Huyền Giang Hồ</h1>
                        <h2 class="text-xl md:text-2xl text-yellow-300 mt-2">Thiên Hạ Đệ Nhất Bang</h2>
                    </div>
                </div>
                
                <!-- Download Buttons -->
                <div class="flex flex-wrap justify-center gap-2 md:gap-4 mt-6">
                    <button class="btn-gradient text-white px-3 py-2 md:px-6 md:py-3 rounded-lg font-semibold text-sm md:text-base">
                        <i class="fab fa-android mr-1 md:mr-2"></i> Tải Android
                    </button>
                    <button class="btn-gradient text-white px-3 py-2 md:px-6 md:py-3 rounded-lg font-semibold text-sm md:text-base">
                        <i class="fab fa-apple mr-1 md:mr-2"></i> Tải iOS
                    </button>
                    <button class="btn-gradient text-white px-3 py-2 md:px-6 md:py-3 rounded-lg font-semibold text-sm md:text-base">
                        <i class="fas fa-download mr-1 md:mr-2"></i> APK
                    </button>
                    <button class="btn-gradient text-white px-3 py-2 md:px-6 md:py-3 rounded-lg font-semibold text-sm md:text-base">
                        <i class="fas fa-desktop mr-1 md:mr-2"></i> NOX
                    </button>
                    <a href="{{route('user.transaction')}}" class="btn-gradient text-white px-3 py-2 md:px-6 md:py-3 rounded-lg font-semibold text-sm md:text-base">
                        <i class="fas fa-credit-card mr-1 md:mr-2"></i> Nạp Thẻ
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Section nổi lên -->
    <div class="floating-content relative">
        <div class="max-w-7xl mx-auto px-6">
            <div class="content-container">
                <!-- Hot Events Sidebar -->
                <div class="sidebar">
                    <div class="glass-effect rounded-2xl p-6 md:p-8 shadow-2xl">
                        <h2 class="text-2xl md:text-3xl font-bold text-yellow-400 mb-6 text-center">
                            <i class="fas fa-fire mr-3"></i>
                            SỰ KIỆN HOT
                        </h2>
                        <img src="/bg.png" alt="Hot Event" class="hot-event-image" />
                    </div>
                </div>

                <!-- Main News Section -->
                <div class="main-content">
                    @include('home.news')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Smooth scrolling effect for floating content
    document.addEventListener('DOMContentLoaded', function() {
        const floatingContent = document.querySelector('.floating-content');
        
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.2;
            if (floatingContent) {
                floatingContent.style.transform = `translateY(${40 + rate}px)`; /* Adjusted to account for new margin */
            }
        });
    });
</script>
@endpush