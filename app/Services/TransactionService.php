<?php
namespace App\Services;

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
}