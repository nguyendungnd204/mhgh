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
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-900 border border-red-500 rounded-md">
                        <div class="text-red-300 text-sm">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <div class="mb-4">
                        <label for="account_name" class="block text-sm font-semibold text-yellow-400">
                            Tên tài khoản <span class="text-red-400">*</span>
                        </label>
                        <input type="text" 
                               id="account_name" 
                               name="account_name"
                               value="{{ old('account_name') }}"
                               class="mt-1 block w-full px-3 py-2 bg-gray-900 text-white border  rounded-md shadow-sm focus:outline-none focus:border-yellow-400 @error('account_name') border-red-500 @enderror"
                               
                               autocomplete="username"
                               maxlength="255">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-semibold text-yellow-400">
                            Mật khẩu <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="password" 
                                   name="password"
                                   class="mt-1 block w-full px-3 py-2 bg-gray-900 text-white border rounded-md shadow-sm focus:outline-none focus:border-yellow-400 @error('password') border-red-500 @enderror"
                                   
                                   autocomplete="current-password"
                                   >
                            <button type="button" 
                                    id="togglePassword"
                                    class="absolute inset-y-0 right-0 px-3 py-2 text-gray-400 hover:text-yellow-400">
                                <i class="fas fa-eye" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4 flex items-center">
                        <input type="checkbox" 
                               id="remember" 
                               name="remember"
                               class="h-4 w-4 text-yellow-400 bg-gray-800 border-gray-600 rounded focus:ring-yellow-400">
                        <label for="remember" class="ml-2 text-sm text-gray-300">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>

                    <button type="submit"
                            id="submitBtn"
                            class="w-full bg-yellow-400 text-black font-bold py-2 rounded-md hover:bg-yellow-300 transition flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-sign-in-alt mr-2"></i> 
                        <span id="btnText">Đăng nhập</span>
                    </button>
                </form>

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

        document.getElementById('loginForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            
            submitBtn.disabled = true;
            btnText.textContent = 'Đang đăng nhập...';
            
            setTimeout(() => {
                submitBtn.disabled = false;
                btnText.textContent = 'Đăng nhập';
            }, 5000);
        });
    </script>
    @endpush
@endsection