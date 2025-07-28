<?php
namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdatedPasswordRequest;
use App\Services\AuthService;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct(private AuthService $authService, private RoleService $roleService)
    {
        /** @var \Illuminate\Routing\Controller $this */
        $this->middleware('can:create users')->only('showCreateUserForm', 'createUser');
    }

    public function showRegisterForm()
    {
        $roles = $this->roleService->getAllRole();
        return view('auth.register', compact('roles'));
    }

    public function showCreateUserForm()
    {
        if (!Auth::user()->can('create users')) {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }
        $roles = $this->roleService->getAllRole();

        return view('admin.users.create', compact('roles'));
    }

    public function register(RegisterRequest $request)
    {
        try {
            /** @var \Illuminate\Http\Request $request */
            $this->authService->register($request->validated(), $request->ip(), $request->userAgent(), true);
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
        if (!Auth::user()->can('create users')) {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
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
        try {
            /** @var \Illuminate\Http\Request $request */
            $this->authService->login(
                $request->validated(),
                $request->filled('remember'),
                $request->ip(),
                $request->userAgent()
            );

            $request->session()->regenerate();


            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            return back()->withErrors([
                'account_name' => $e->getMessage(),
                'password' => $e->getMessage(),
            ])->withInput();
        }
    }


    public function dashboard()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasAnyRole(['admin', 'manager'])) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('user')) {
            return redirect()->route('user.transaction');
        }

        return redirect()->route('home');
    }


    public function logout(Request $request)
    {
        /** @var \Illuminate\Http\Request $request */
        $this->authService->logout($request->ip());

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Đăng xuất thành công!');
    }

    public function changePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(UpdatedPasswordRequest $request)
    {
        try {
            $data = $request->validated();
            $this->authService->changePassword(
                Auth::user(),
                $data['current_password'],
                $data['password']
            );
            return redirect()->route('edit-password')->with('success', 'Đổi mật khẩu thành công');
        } catch (\Exception $e) {
            return back()->withErrors(['password' => $e->getMessage()])->withInput();
        }
    }
}
