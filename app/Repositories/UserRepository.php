<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getQuery(): Builder
    {
        return $this->model->newQuery()->latest('created_at');
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function findById(int $id): ?User
    {
        return $this->model->with('roles')->findOrFail($id);
    }

    public function findByAccountName(string $accountName): ?User
    {
        return $this->model->where('account_name', $accountName)->first();
    }

    public function update(User $model, array $data): bool
    {
        return $model->update($data);
    }

    public function delete(User $model): bool
    {
        return $model->delete();
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage);
    }

    public function getByRole(string $role): Collection
    {
        return $this->model->where('role', $role)->get();
    }

    public function search(Builder $query, string $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', '%' . $searchTerm . '%')
              ->orWhere('account_name', 'like', '%' . $searchTerm . '%');
        });
    }

    public function updateStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        return $user->save();
    }

    public function count(): int
    {
        return $this->model->count();
    }

    public function updatePassword(User $user, string $password): bool
    {
        $user->password = bcrypt($password);
        return $user->save();
    }
}
