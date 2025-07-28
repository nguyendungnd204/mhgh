<?php

namespace App\Http\Controllers;

use App\Http\Requests\updateStatusTransactionRequest;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function __construct(private TransactionService $transactionService) 
    {
        /** @var \Illuminate\Routing\Controller $this */
        $this->middleware('can:view transactions')->only('index', 'show');
        $this->middleware('can:edit transactions')->only('updateStatus');
        //$this->middleware('transactions: create transactions')->only('create', 'store');
        $this->middleware('can:view transactions user')->only('history', 'transaction');
    }

    public function index(Request $request): View
    {
        if(!Auth::user()->can('view transactions'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $transactions = $this->transactionService->getAllTransactions(['user', 'character'], $request);

        // dd($transactions);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function updateStatus(updateStatusTransactionRequest $request, int $id)
    {
        if(!Auth::user()->can('edit transactions'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $transaction = $this->transactionService->getTransactionById($id);

        try {
            $this->transactionService->updateStatus($transaction, $request['status']);
            return redirect()
                ->route('admin.transactions.index')
                ->with('success', 'Trạng thái giao dịch đã được cập nhật thành công');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Có lỗi khi cập nhật trạng thái giao dịch: ' . $e->getMessage());
        }
    }

    public function show(int $id): View
    {
        if(!Auth::user()->can('view transactions'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $transaction = $this->transactionService->getTransactionById($id);

        return view('admin.transactions.show', compact('transaction'));
    }

    public function history(): View
    {
        $user = Auth::user();

        if(!$user->can('view transactions user'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        $transactions = $this->transactionService->getAllById($user->id, ['user', 'character']);
        // dd($transactions);
        return view('user.history', compact('transactions'));
    }

    public function transaction(): View
    {
        if(!Auth::user()->can('view transactions user'))
        {
            abort(403, 'Bạn không có quyền thực hiện hành động này');
        }

        return view('user.transaction');
    }
}
