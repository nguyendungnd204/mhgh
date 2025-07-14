<?php

// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register($request->validated(), $request->ip(), $request->userAgent());
            
            Auth::login($user);
            
            return redirect()->route('dashboard')->with('success', 'Đăng ký tài khoản thành công');
        } catch (\Exception $e) {
            return back()->withErrors([
                'account_name' => $e->getMessage()
            ])->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authService->login(
                $request->validated(),
                $request->filled('remember'),
                $request->ip(),
                $request->userAgent()
            );

            $request->session()->regenerate();
            
            return $this->dashboard();
        } catch (\Exception $e) {
            return back()->withErrors([
                'account_name' => $e->getMessage(),
            ])->withInput($request->only('account_name'));
        }
    }

    public function dashboard()
    {
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
        $this->authService->logout($request->ip());
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }
}