<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showRegisterForm() {
        return view ('auth.register');
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'account_name' => 'required|string|unique:users,account_name|max:255',
            'password' => 'required|confirmed|min:8',
            'role' => 'sometimes|in:admin,user'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'account_name' => $request->account_name,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? User::ROLE_USER,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }

    public function showLoginForm() {
        
        return view('auth.login');
    }

    public function login(Request $request) {

        $credentials = $request->validate([
            'account_name' => 'required|string',
            'password' => 'required'
        ]);

        if(Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            /** @var \App\Models\Auth $user */
            $user = Auth::user();

            if($user && $user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            if($user && $user->isUser()) {
                return redirect()->route('user.dashboard');
            }

            return redirect()->route('home');
        }

        return back()->withErrors([
            'account_name' => 'The provided credentials do not match our records',
        ])->withInput();
    }

    public function dashboard() {
         /** @var \App\Models\User $user */
        $user = Auth::user();

        return match (true) {
        $user->isAdmin() => redirect()->route('admin.dashboard'),
        $user->isUser() => redirect()->route('user.dashboard'),
        default => redirect()->route('home'),
        };
    }

     public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
