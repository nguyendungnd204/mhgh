@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard Admin</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Tổng người dùng</h3>
                    <p class="text-2xl font-bold text-gray-800">12,458</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Transactions -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Tổng giao dịch</h3>
                    <p class="text-2xl font-bold text-gray-800">8,329</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Events -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Sự kiện đang diễn ra</h3>
                    <p class="text-2xl font-bold text-gray-800">23</p>
                    <p class="text-sm text-blue-600">5 sự kiện mới tuần này</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Gift Codes -->
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Mã quà tặng còn lại</h3>
                    <p class="text-2xl font-bold text-gray-800">1,247</p>
                    <p class="text-sm text-orange-600">89 mã đã sử dụng hôm nay</p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables Row -->
 

    <!-- Recent Activity and News -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Transactions -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Giao dịch gần đây</h3>
                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Xem tất cả</a>
            </div>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">TXN-789123</p>
                            <p class="text-xs text-gray-500">Viettel 100,000 VND</p>
                        </div>
                    </div>
                    <span class="text-xs text-green-600 font-medium">Thành công</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-yellow-500 rounded-full mr-3"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">TXN-789124</p>
                            <p class="text-xs text-gray-500">Mobifone 50,000 VND</p>
                        </div>
                    </div>
                    <span class="text-xs text-yellow-600 font-medium">Đang xử lý</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="w-2 h-2 bg-red-500 rounded-full mr-3"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">TXN-789125</p>
                            <p class="text-xs text-gray-500">Vinaphone 200,000 VND</p>
                        </div>
                    </div>
                    <span class="text-xs text-red-600 font-medium">Thất bại</span>
                </div>
            </div>
        </div>

        <!-- Recent News -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Tin tức mới nhất</h3>
                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Xem tất cả</a>
            </div>
            <div class="space-y-3">
                <div class="border-l-4 border-blue-500 pl-4">
                    <h4 class="text-sm font-medium text-gray-800">Cập nhật hệ thống thanh toán</h4>
                    <p class="text-xs text-gray-500 mt-1">Hệ thống thanh toán đã được nâng cấp với nhiều tính năng mới...</p>
                    <span class="text-xs text-gray-400">2 giờ trước</span>
                </div>
                <div class="border-l-4 border-green-500 pl-4">
                    <h4 class="text-sm font-medium text-gray-800">Sự kiện mùa hè 2024</h4>
                    <p class="text-xs text-gray-500 mt-1">Sự kiện đặc biệt với nhiều phần quà hấp dẫn...</p>
                    <span class="text-xs text-gray-400">5 giờ trước</span>
                </div>
                <div class="border-l-4 border-purple-500 pl-4">
                    <h4 class="text-sm font-medium text-gray-800">Bảo trì hệ thống</h4>
                    <p class="text-xs text-gray-500 mt-1">Hệ thống sẽ được bảo trì vào 2:00 AM ngày mai...</p>
                    <span class="text-xs text-gray-400">1 ngày trước</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection