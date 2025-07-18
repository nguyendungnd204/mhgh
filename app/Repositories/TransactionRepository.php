<?php
namespace App\Repositories;

use App\Models\TopupTransaction;
use Illuminate\Database\Eloquent\Builder;

class TransactionRepository
{
    protected $model;
    public function __construct(TopupTransaction $topupTransaction)
    {
        $this->model = $topupTransaction;
    }

    public function getAllTransactions()
    {
        return $this->model->all();
    }

    public function getAllWithRelations(array $relations = [])
    {
        return $this->model->with($relations);
    }

    public function search(Builder $query, string $searchTerm): Builder
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('transaction_code', 'like', '%' . $searchTerm . '%')
              ->orWhere('serial', 'like', '%' . $searchTerm . '%')
              ->orWhere('card_code', 'like', '%' . $searchTerm . '%');
        });
    }

    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function updateStatus(TopupTransaction $transaction, string $status)
    {
        $transaction->status = $status;
        return $transaction->save();
    }

    public function getAllById(int $id, array $relations = [])
    {
        return $this->model->with($relations)->where('id', $id)->get();
    }
}