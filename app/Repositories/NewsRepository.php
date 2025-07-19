<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsRepository 
{
    protected $model;

    public function __construct(News $news)
    {
        $this->model = $news;
    }

    public function getQuerywithRelations(array $relations = []): Builder
    {
        return $this->model->with($relations);
    }

    public function search(Builder $query, string $searchTerm): Builder
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'like', '%' . $searchTerm . '%')
            ->orWhere('description', 'like', '%' . $searchTerm . '%');
        });
    }

    public function paginate(Builder $query, int $perPage = 10): LengthAwarePaginator
    {
        return $query->latest()->paginate($perPage);
    }

    public function create(array $data): News
    {
        return $this->model->create($data);
    }

    public function update(News $event, array $data): News
    {
        $event->update($data);
        return $event->refresh();
    }

    public function delete(News $event): bool
    {
        return $event->delete();
    }

    public function findById(int $id): ?News
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): News
    {
        return $this->model->findOrFail($id);
    }

    public function findWithRelations(int $id, array $relations = []): News
    {
        return $this->model->with($relations)->findOrFail($id);
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }

    public function getAllWithRelations(array $relations = []): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with($relations)->get();
    }

    public function getActive(): Builder
    {
        return $this->model->where('is_active', true);
    }

    public function getByDateRange(string $startDate, string $endDate): Builder
    {
        return $this->model->whereBetween('start_date', [$startDate, $endDate]);
    }

    public function getByUser(int $userId): Builder
    {
        return $this->model->where('created_by', $userId);
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function getNewsActive($limit = 5): LengthAwarePaginator
    {
        return $this->model->where('is_active', true)->orderBy('created_at', 'desc')->paginate($limit);
    }
   
   
}
