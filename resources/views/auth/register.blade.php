@extends('layouts.guest')

@section('title', 'Đăng ký tài khoản')

@section('content')
    <div class="flex justify-center py-10">
        <div class="w-full max-w-md">
            <div class="bg-white shadow-lg rounded-lg border border-gray-200">
                <div class="bg-green-600 text-white p-4 rounded-t-lg">
                    <h4 class="text-lg font-bold mb-0 flex items-center">
                        <i class="fas fa-user-plus mr-2"></i> Đăng ký tài khoản
                    </h4>
                </div>
                <div class="p-6">
                    {{-- Hiển thị thông báo lỗi chung --}}
                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-md">
                            <div class="text-red-700 text-sm">
                                <strong>Vui lòng kiểm tra lại:</strong>
                                <ul class="mt-1 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" id="registerForm">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Họ và tên <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @enderror"
                                id="name" name="name" value="{{ old('name') }}" required maxlength="255"
                                placeholder="Nhập họ và tên đầy đủ">
                        </div>

                        <div class="mb-4">
                            <label for="account_name" class="block text-sm font-medium text-gray-700">
                                Tên tài khoản <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('account_name') border-red-500 @enderror"
                                id="account_name" name="account_name" value="{{ old('account_name') }}" required
                                maxlength="255" pattern="^[a-zA-Z0-9_]+$"
                                placeholder="Chỉ chứa chữ cái, số và dấu gạch dưới">
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700">
                                Quyền <span class="text-red-500">*</span>
                            </label>
                            <select
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('role') border-red-500 @enderror"
                                id="role" name="role">
                                <option value="user" {{ old('role', 'user') == 'user' ? 'selected' : '' }}>
                                    Người dùng
                                </option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                    Quản trị viên
                                </option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Mật khẩu <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password"
                                    class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('password') border-red-500 @enderror"
                                    id="password" name="password" required minlength="8">
                            </div>

                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                Nhập lại mật khẩu <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="password"
                                    class="mt-1 block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                    id="password_confirmation" name="password_confirmation" required
                                    placeholder="Nhập lại mật khẩu để xác nhận">
                                <button type="button" id="togglePasswordConfirm"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">

                                </button>
                            </div>

                        </div>

                        <button type="submit" id="submitBtn"
                            class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition duration-200 flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-user-plus mr-2"></i>
                            <span id="btnText">Đăng ký</span>
                           
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-600">
                            Đã có tài khoản?
                            <a href="{{ route('login') }}" class="text-green-600 hover:text-green-800 font-medium">
                                Đăng nhập ngay
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
