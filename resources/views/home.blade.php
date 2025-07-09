@extends('layouts.guest')

@section('title', 'home')

@section('content')
   <div class="min-h-screen flex flex-col">
    <!-- Header Section -->
    <div class="bg-[url(/bg.png)] opacity-85 text-white p-4 flex items-center justify-between">
        <div class="flex items-center">
            <div class="w-16 h-16 bg-yellow-400 rounded-full mr-4"></div> <!-- Placeholder for character image -->
            <div>
                <h1 class="text-2xl font-bold">Mộng Huyền Giang Hồ</h1>
                <h2 class="text-lg">Thiên Hạ Đệ Nhất Bang</h2>
            </div>
        </div>
        <div class="flex space-x-2">
            <button class="bg-yellow-400 text-white px-3 py-2 rounded hover:bg-yellow-500">Tải game Android</button>
            <button class="bg-yellow-400 text-white px-3 py-2 rounded hover:bg-yellow-500">Tải iOS</button>
            <button class="bg-yellow-400 text-white px-3 py-2 rounded hover:bg-yellow-500">APK</button>
            <button class="bg-yellow-400 text-white px-3 py-2 rounded hover:bg-yellow-500">NOX</button>
            <button class="bg-yellow-400 text-white px-3 py-2 rounded hover:bg-yellow-500">Nạp Thẻ</button>
            <button class="bg-yellow-400 text-white px-3 py-2 rounded hover:bg-yellow-500">Hướng Dẫn</button>
        </div>
    </div>

    <!-- News Section -->
    <div class="flex-1 bg-gray-100 p-6 rounded-lg shadow">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">TIN TỨC - SỰ KIỆN HƯỚNG DẪN</h2>
            <div class="flex flex-wrap gap-2 mb-6">
                <button class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">TIN TỨC</button>
                <button class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">SỰ KIỆN</button>
                <button class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500">HƯỚNG DẪN</button>
            </div>
            <ul class="space-y-4">
                <li class="border-b pb-4">
                    <span class="text-gray-500 text-sm">PROTECTED: KHÓI ĐỐNG THĐNB 2025</span>
                </li>
                <li class="border-b pb-4">
                    <span class="text-gray-500 text-sm">CHIA CỦM CTC 07/07/2025</span>
                </li>
                <li class="border-b pb-4">
                    <span class="text-gray-500 text-sm">ĐẰNG KÝ ĐỒ BẢO VẬT VIP16 | VIP17</span>
                </li>
                <li class="border-b pb-4">
                    <span class="text-gray-500 text-sm">03/07 - CẬP NHẬT MÙA HÈ</span>
                </li>
                <li class="border-b pb-4">
                    <span class="text-gray-500 text-sm">CẬN HỌA XỨ PHÁT 06.2025</span>
                </li>
                <!-- Add more items to extend the content vertically -->
                <li class="border-b pb-4">
                    <span class="text-gray-500 text-sm">TIN TỨC THÊM 1</span>
                </li>
                <li class="border-b pb-4">
                    <span class="text-gray-500 text-sm">TIN TỨC THÊM 2</span>
                </li>
                <li class="border-b pb-4">
                    <span class="text-gray-500 text-sm">TIN TỨC THÊM 3</span>
                </li>
                <li class="border-b pb-4">
                    <span class="text-gray-500 text-sm">TIN TỨC THÊM 4</span>
                </li>
                <li class="border-b pb-4">
                    <span class="text-gray-500 text-sm">TIN TỨC THÊM 5</span>
                </li>
            </ul>
            <div class="mt-6 flex justify-between items-center">
                <span class="text-gray-600 text-sm">Page 1 of 187</span>
                <div class="flex space-x-2">
                    <button class="bg-gray-300 text-gray-700 px-3 py-1 rounded hover:bg-gray-400">1</button>
                    <button class="bg-gray-300 text-gray-700 px-3 py-1 rounded hover:bg-gray-400">2</button>
                    <span class="text-gray-600">...</span>
                    <button class="bg-gray-300 text-gray-700 px-3 py-1 rounded hover:bg-gray-400">187</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
