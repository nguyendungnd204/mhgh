<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\TransactionRequest;
use App\Http\Requests\UpdateUserStatusRequest;
use Illuminate\Http\RedirectResponse;

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




    // public function storeTransaction(TransactionRequest $request): RedirectResponse
    // {
    //     try {
    //         $this->userService->createTransaction($request->validated(), $request);

    //         return redirect()
    //             ->route('user.history')
    //             ->with('success', 'Giao dịch đã được tạo');
    //     } catch (\Exception $e) {
    //         return redirect()
    //             ->back()
    //             ->withInput()
    //             ->with('error', 'Có lỗi khi tạo giao dịch'. $e->getMessage());
    //     }
    // }

    public function updateStatus(int $id): RedirectResponse
    {
        $user = $this->userService->getUserById($id);
        try {
            $this->userService->updateStatus($user);
            return redirect()->route('admin.users.index')
                ->with('success', 'Thay đổi trạng thái thành công');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi khi thay đổi trạng thái: ' . $e->getMessage());
        }
    }
}
