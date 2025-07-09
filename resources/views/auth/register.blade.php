@extends('layouts.guest')

@section('title', 'register')

@section('content')
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white shadow rounded-lg">
                <div class="bg-green-600 text-white p-4 rounded-t-lg">
                    <h4 class="text-lg font-bold mb-0 flex items-center"><i class="fas fa-user-plus mr-2"></i> Register</h4>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Họ và tên</label>
                            <input type="text" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('name') border-red-500 @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="account_name" class="block text-sm font-medium text-gray-700">Tên tài khoản</label>
                            <input type="text" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('account_name') border-red-500 @enderror" 
                                   id="account_name" 
                                   name="account_name" 
                                   value="{{ old('account_name') }}" 
                                   required>
                            @error('account_name')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700">Quyền</label>
                            <select class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('role') border-red-500 @enderror" 
                                    id="role" 
                                    name="role">
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Mật khẩu</label>
                            <input type="password" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('password') border-red-500 @enderror" 
                                   id="password" 
                                   name="password" 
                                   required>
                            @error('password')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Nhập lại mật khẩu</label>
                            <input type="password" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required>
                        </div>

                        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-md hover:bg-green-700 flex items-center justify-center">
                            <i class="fas fa-user-plus mr-2"></i> Đăng ký
                        </button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="text-sm text-gray-600">Đã có tài khoản? <a href="{{ route('login') }}" class="text-green-600 hover:text-green-800">Đăng nhập ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection