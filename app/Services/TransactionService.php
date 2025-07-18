<?php
namespace App\Services;

use App\Models\TopupTransaction;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;

class TransactionService
{
    public function __construct(private TransactionRepository $topupTransaction){}

    public function getAllTransactions(array $relations = [], Request $request)
    {
        $query = $this->topupTransaction->getAllWithRelations($relations);

        if($request->filled('search')) {
            $query = $this->topupTransaction->search($query, $request->search);
        }

        return $query->latest()->paginate(15);
    }

    public function getTransactionById(int $id)
    {
        return $this->topupTransaction->findById($id);
    }

    public function updateStatus(TopupTransaction $transaction, string $status)
    {
        return $this->topupTransaction->updateStatus($transaction, $status);
    }

    public function getAllById(int $id, array $relations = [])
    {
        return $this->topupTransaction->getAllById($id, $relations);
    }
}