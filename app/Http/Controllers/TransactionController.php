<?php

namespace App\Http\Controllers;

use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct(private TransactionService $transactionService){}

    public function index(Request $request)
    {
        $transactions = $this->transactionService->getAllTransactions(['user', 'character'], $request);

        // dd($transactions);
        return view('admin.transactions.index', compact('transactions'));
    }
}
