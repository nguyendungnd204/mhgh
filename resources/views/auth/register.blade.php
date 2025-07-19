@extends('layouts.guest')

@section('title', 'Đăng ký tài khoản')

@section('content')
    <div class="flex justify-center py-10">
        <div class="w-full max-w-md bg-black border border-yellow-400 rounded-lg shadow-lg">
            <div class="bg-yellow-400 text-black p-4 rounded-t-lg">
                <h4 class="text-lg font-bold mb-0 flex items-center">
                    <i class="fas fa-user-plus mr-2"></i> Đăng ký tài khoản
                </h4>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-semibold text-yellow-400">
                            Họ và tên <span class="text-red-400">*</span>
                        </label>
                        <input type="text"
                            class="mt-1 block w-full px-3 py-2 bg-gray-900 text-white border rounded-md shadow-sm focus:outline-none focus:border-yellow-400 @error('name') border-red-500 @enderror"
                            id="name" name="name" value="{{ old('name') }}"  maxlength="255"
                            placeholder="Nhập họ và tên đầy đủ">
                        @error('name')
                            <div class="text-red-300 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="account_name" class="block text-sm font-semibold text-yellow-400">
                            Tên tài khoản <span class="text-red-400">*</span>
                        </label>
                        <input type="text"
                            class="mt-1 block w-full px-3 py-2 bg-gray-900 text-white border rounded-md shadow-sm focus:outline-none focus:border-yellow-400 @error('account_name') border-red-500 @enderror"
                            id="account_name" name="account_name" value="{{ old('account_name') }}" 
                            maxlength="255" pattern="^[a-zA-Z0-9_]+$"
                            placeholder="Chỉ chứa chữ cái, số và dấu gạch dưới">
                        @error('account_name')
                            <div class="text-red-300 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="role" class="block text-sm font-semibold text-yellow-400">
                            Quyền <span class="text-red-400">*</span>
                        </label>
                        <select
                            class="mt-1 block w-full px-3 py-2 bg-gray-900 text-white border rounded-md shadow-sm focus:outline-none focus:border-yellow-400 @error('role') border-red-500 @enderror"
                            id="role" name="role">
                            <option value="user" {{ old('role', 'user') == 'user' ? 'selected' : '' }}>
                                Người dùng
                            </option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                Quản trị viên
                            </option>
                        </select>
                        @error('role')
                            <div class="text-red-300 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-semibold text-yellow-400">
                            Mật khẩu <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                class="mt-1 block w-full px-3 py-2 bg-gray-900 text-white border rounded-md shadow-sm focus:outline-none focus:border-yellow-400 @error('password') border-red-500 @enderror"
                                id="password" name="password"  minlength="8">
                            <button type="button" id="togglePassword"
                                class="absolute inset-y-0 right-0 px-3 py-2 text-gray-400 hover:text-yellow-400">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-red-300 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-semibold text-yellow-400">
                            Nhập lại mật khẩu <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input type="password"
                                class="mt-1 block w-full px-3 py-2 bg-gray-900 text-white border rounded-md shadow-sm focus:outline-none focus:border-yellow-400"
                                id="password_confirmation" name="password_confirmation" 
                                placeholder="Nhập lại mật khẩu để xác nhận">
                            <button type="button" id="togglePasswordConfirm"
                                class="absolute inset-y-0 right-0 px-3 py-2 text-gray-400 hover:text-yellow-400">
                                <i class="fas fa-eye" id="eyeIconConfirm"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" id="submitBtn"
                        class="w-full bg-yellow-400 text-black font-bold py-2 rounded-md hover:bg-yellow-300 transition flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-user-plus mr-2"></i>
                        <span id="btnText">Đăng ký</span>
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-sm text-gray-300">
                        Đã có tài khoản?
                        <a href="{{ route('login') }}" class="text-yellow-400 hover:text-yellow-300 font-medium">
                            Đăng nhập ngay
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });

        document.getElementById('togglePasswordConfirm').addEventListener('click', function() {
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const eyeIconConfirm = document.getElementById('eyeIconConfirm');
            
            if (passwordConfirmInput.type === 'password') {
                passwordConfirmInput.type = 'text';
                eyeIconConfirm.classList.remove('fa-eye');
                eyeIconConfirm.classList.add('fa-eye-slash');
            } else {
                passwordConfirmInput.type = 'password';
                eyeIconConfirm.classList.remove('fa-eye-slash');
                eyeIconConfirm.classList.add('fa-eye');
            }
        });

        // Handle form submission
        document.getElementById('registerForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            
            submitBtn.disabled = true;
            btnText.textContent = 'Đang đăng ký...';
            
            setTimeout(() => {
                submitBtn.disabled = false;
                btnText.textContent = 'Đăng ký';
            }, 5000);
        });
    </script>
    @endpush
@endsection