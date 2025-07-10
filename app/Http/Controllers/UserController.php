<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $throttleKey = 'register.' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'account_name' => "Quá nhiều lần đăng ký. Vui lòng thử lại sau {$seconds} giây.",
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'account_name' => 'required|string|unique:users,account_name|max:255|regex:/^[a-zA-Z0-9_]+$/',
            'password' => 'required|confirmed|min:6',
            'role' => 'sometimes|in:admin,user'
        ]);

        if ($validator->fails()) {
            RateLimiter::hit($throttleKey, 300);
            return back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::create([
                'name' => trim($request->name),
                'account_name' => trim($request->account_name),
                'password' => Hash::make($request->password),
                'role' => $request->role ?? User::ROLE_USER,
            ]);

            RateLimiter::clear($throttleKey);

            Log::info('User registered successfully', [
                'user_id' => $user->id,
                'account_name' => $user->account_name,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Đăng ký tài khoản thành công');
        } catch (\Exception $e) {
            Log::error('User registration failed', [
                'error' => $e->getMessage(),
                'account_name' => $request->account_name,
                'ip' => $request->ip()
            ]);

            return back()->withErrors([
                'account_name' => 'Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại.'
            ])->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'account_name' => "Quá nhiều lần đăng nhập thất bại. Vui lòng thử lại sau {$seconds} giây.",
            ]);
        }

        $credentials = $request->validate([
            'account_name' => 'required|string|max:255',
            'password' => 'required|string|min:6'
        ], [
            'account_name.required' => 'Tên tài khoản là bắt buộc.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.'
        ]);

        $credentials['account_name'] = trim($credentials['account_name']);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            RateLimiter::clear($throttleKey);

            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();

            Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'account_name' => $user->account_name,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return $this->dashboard();
        }

        RateLimiter::hit($throttleKey, 60);

        Log::warning('Failed login attempt', [
            'account_name' => $credentials['account_name'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return back()->withErrors([
            'account_name' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput($request->only('account_name'));
    }

    /**
     * Get throttle key for rate limiting
     */
    protected function throttleKey(Request $request): string
    {
        return 'login.' . $request->ip();
    }

    public function dashboard()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        return match (true) {
            $user->isAdmin() => redirect()->route('admin.dashboard'),
            $user->isUser() => redirect()->route('user.dashboard'),
            default => redirect()->route('home'),
        };
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user) {
            Log::info('User logged out', [
                'user_id' => $user->id,
                'account_name' => $user->account_name,
                'ip' => $request->ip(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }
}