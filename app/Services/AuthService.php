<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function register(array $data, string $ip, string $userAgent, bool $autoLogin): User
    {
        $throttleKey = 'register.' . $ip;

        try {
            $userData = [
                'name' => $data['name'],
                'account_name' => $data['account_name'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'] ?? User::ROLE_USER,
            ];

            $user = $this->userRepository->create($userData);

            RateLimiter::clear($throttleKey);

            if ($autoLogin) {
                Auth::login($user);
            }

            return $user;
        } catch (\Exception $e) {
            Log::error('User registration failed', [
                'error' => $e->getMessage(),
                'account_name' => $data['account_name'],
                'ip' => $ip
            ]);

            throw new \Exception('Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại.');
        }
    }

    public function login(array $credentials, bool $remember, string $ip, string $userAgent): User
    {
        $throttleKey = 'login.' . $ip;
        $credentials['is_active'] = 1;

        if (Auth::attempt($credentials, $remember)) {
            RateLimiter::clear($throttleKey);

            $user = Auth::user();

            Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'account_name' => $user->account_name,
                'ip' => $ip,
                'user_agent' => $userAgent
            ]);

            return $user;
        }

        RateLimiter::hit($throttleKey, 60);

        $user = User::where('account_name', $credentials['account_name'])->first();

        if ($user && !$user->is_active) {
            throw new \Exception('Tài khoản của bạn đã bị khóa. Vui lòng liên hệ quản trị viên.');
        }

        throw new \Exception('Thông tin đăng nhập không chính xác.');
    }

    public function logout(string $ip): void
    {
        $user = Auth::user();

        if ($user) {
            Log::info('User logged out', [
                'user_id' => $user->id,
                'account_name' => $user->account_name,
                'ip' => $ip,
            ]);
        }

        Auth::logout();
    }
}
