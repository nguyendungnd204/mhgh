<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getQuery(): Builder
    {
        return $this->user->newQuery();
    }

    public function create(array $data): User
    {
        return $this->user->create($data);
    }

    public function findById(int $id): ?User
    {
        return $this->user->find($id);
    }

    public function findByAccountName(string $accountName): ?User
    {
        return $this->user->where('account_name', $accountName)->first();
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function all(): Collection
    {
        return $this->user->all();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->user->paginate($perPage);
    }

    public function getByRole(string $role): Collection
    {
        return $this->user->where('role', $role)->get();
    }

    public function search(Builder $query, string $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('name', 'like', '%' . $searchTerm . '%')
              ->orWhere('account_name', 'like', '%' . $searchTerm . '%');
        });
    }
}
