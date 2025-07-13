<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class EventRepository
{
    protected $model;

    public function __construct(Event $event)
    {
        $this->model = $event;
    }

    public function getQueryWithRelations(array $relations = []): Builder
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

    public function paginate(Builder $query, int $perPage = 15): LengthAwarePaginator
    {
        return $query->latest()->paginate($perPage);
    }

    public function create(array $data): Event
    {
        return $this->model->create($data);
    }

    public function update(Event $event, array $data): Event
    {
        $event->update($data);
        return $event;
    }

    public function delete(Event $event): bool
    {
        return $event->delete();
    }

    public function findById(int $id): ?Event
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Event
    {
        return $this->model->findOrFail($id);
    }

    public function findWithRelations(int $id, array $relations = []): Event
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
}