<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(private UserService $userService){}

    public function index(Request $request): View 
    {
        $users = $this->userService->getAllUsers($request);
        return view('admin.users.index', compact('users'));
    }

    public function show(int $id): View
    {
        $user = $this->userService->getUserById($id);

        return view('admin.users.show', compact('user'));
    }

    public function transaction(): View
    {
        return view('user.transaction');
    }
}
