<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Database\Eloquent\Builder;
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
}