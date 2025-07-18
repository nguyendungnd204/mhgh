<?php

namespace App\Repositories;

use App\Models\GiftCode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class GiftRepository
{
    protected $model;

    public function __construct(GiftCode $giftCode)
    {
        $this->model = $giftCode;
    }

    public function create(array $data): GiftCode
    {
        return $this->model->create($data);
    }

    public function getAll(): Collection
    {
        return $this->model->get();
    }

    public function search(Builder $query, string $searchTerm): Builder
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('code', 'like', '%' . $searchTerm . '%');
        });
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage);
    }

    public function getQuery(): Builder
    {
        return $this->model->newQuery();
    }

    public function getQuerywithRelations(array $relations = [])
    {
        return $this->model->with($relations);
    }

    public function findWithRelations(int $id, array $relations = [])
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function generateUniqueCode(int $length = 8): string
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        do {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }
        } while ($this->model->where('code', $code)->exists());

        return $code;
    }

    public function update(GiftCode $giftCode, array $data): GiftCode
    {
        $giftCode->update($data);
        return $giftCode->refresh();
    }
}
