@extends('layouts.guest')

@section('title', 'Đăng nhập')

@section('content')
    <div class="flex justify-center py-10">
        <div class="w-full max-w-md bg-black border border-yellow-400 rounded-lg shadow-lg">
            <div class="bg-yellow-400 text-black p-4 rounded-t-lg">
                <h4 class="text-lg font-bold mb-0 flex items-center">
                    <i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập tài khoản
                </h4>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="account_name" class="block text-sm font-semibold text-yellow-400">Tên tài khoản</label>
                        <input type="text" id="account_name" name="account_name"
                            value="{{ old('account_name') }}"
                            class="mt-1 block w-full px-3 py-2 bg-gray-900 text-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-yellow-400 @error('account_name') border-red-500 @enderror"
                            required>
                        @error('account_name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-semibold text-yellow-400">Mật khẩu</label>
                        <input type="password" id="password" name="password"
                            class="mt-1 block w-full px-3 py-2 bg-gray-900 text-white border border-gray-600 rounded-md shadow-sm focus:outline-none focus:border-yellow-400 @error('password') border-red-500 @enderror"
                            required>
                        @error('password')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 flex items-center">
                        <input type="checkbox" id="remember" name="remember"
                            class="h-4 w-4 text-yellow-400 bg-gray-800 border-gray-600 rounded">
                        <label for="remember" class="ml-2 text-sm text-gray-300">Ghi nhớ đăng nhập</label>
                    </div>

                    <button type="submit"
                        class="w-full bg-yellow-400 text-black font-bold py-2 rounded-md hover:bg-yellow-300 transition flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập
                    </button>
                </form>

                {{-- <div class="text-center mt-4">
                    <p class="text-sm text-gray-400">
                        Chưa có tài khoản?
                        <a href="{{ route('register') }}" class="text-yellow-400 hover:text-yellow-300 font-semibold">Đăng ký</a>
                    </p>
                </div> --}}
            </div>
        </div>
    </div>
@endsection
