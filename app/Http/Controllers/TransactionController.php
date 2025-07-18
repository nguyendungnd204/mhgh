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
    public function __construct(private TransactionService $transactionService) {}

    public function index(Request $request): View
    {
        $transactions = $this->transactionService->getAllTransactions(['user', 'character'], $request);

        // dd($transactions);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function updateStatus(updateStatusTransactionRequest $request, int $id)
    {
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
        $transaction = $this->transactionService->getTransactionById($id);

        return view('admin.transactions.show', compact('transaction'));
    }

    public function history(): View
    {
        $user = Auth::user();
        $transactions = $this->transactionService->getAllById($user->id, ['user', 'character']);
        // dd($transactions);
        return view('user.history', compact('transactions'));
    }

    public function transaction(): View
    {
        return view('user.transaction');
    }
}
