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

    public function showCreateUserForm()
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403, 'Không có quyền thực hiện chức năng này');
        }

        return view('admin.users.create');
    }

    public function register(RegisterRequest $request)
    {
        try {
            /** @var \Illuminate\Http\Request $request */
            $user = $this->authService->register($request->validated(), $request->ip(), $request->userAgent(), true);
            $request->session()->regenerate();
                        
            return redirect()->route('dashboard')->with('success', 'Đăng ký tài khoản thành công');
        } catch (\Exception $e) {
            return back()->withErrors([
                'account_name' => $e->getMessage()
            ])->withInput();
        }
    }

    public function createUser(RegisterRequest $request)
    {
        if (!Auth::user()?->isAdmin()) {
            abort(403, 'Không có quyền thực hiện chức năng này');
        }

        try {
            /** @var \Illuminate\Http\Request $request */
            $user = $this->authService->register($request->validated(), $request->ip(), $request->userAgent(), false);
            
            return redirect()->route('admin.users.index')->with('success', 'Tạo tài khoản thành công cho: ' . $user->account_name);
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
        /** @var \Illuminate\Http\Request $request */
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
            $user->isUser() => redirect()->route('user.transaction'),
            default => redirect()->route('home'),
        };
    }

    public function logout(Request $request)
    {
        /** @var \Illuminate\Http\Request $request */
        $this->authService->logout($request->ip());
                 
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }
}