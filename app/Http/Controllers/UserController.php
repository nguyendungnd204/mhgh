<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private UserService $userService)
    {
        /** @var \Illuminate\Routing\Controller $this */
        $this->middleware('can:view users')->only('index', 'show');
        $this->middleware('can:edit users')->only('edit', 'update');
        $this->middleware('can:delete users')->only('destroy');
    }

    public function index(Request $request): View 
    {
       if(!Auth::user()->can('view users'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $users = $this->userService->getAllUsers($request);

        return view('admin.users.index', compact('users'));
    }

    public function show(int $id): View
    {
       if(!Auth::user()->can('view users'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }
        $user = $this->userService->getUserById($id);

        return view('admin.users.show', compact('user'));
    }


    public function updateStatus(int $id): RedirectResponse
    {
        if(!Auth::user()->can('edit users'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $user = $this->userService->getUserById($id);

        if(!Auth::user()->hasRole('admin') && $user->hasAnyRole(['manager', 'admin']))
        {
             return redirect()
                ->back()
                ->with('error', 'Bạn không có quyền thực hiện hành động này');
        }

        if(Auth::user()->hasRole('manager') && $user->hasAnyRole(['manager', 'admin']))
        {
            return redirect()
                ->back()
                ->with('error', 'Bạn không có quyền thực hiện hành động này');
        }
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
}
