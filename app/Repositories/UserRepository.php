<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByAccountName(string $accountName): ?User
    {
        return User::where('account_name', $accountName)->first();
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
        return User::all();
    }

    public function paginate(int $perPage = 15)
    {
        return User::paginate($perPage);
    }

    public function getByRole(string $role): Collection
    {
        return User::where('role', $role)->get();
    }
}