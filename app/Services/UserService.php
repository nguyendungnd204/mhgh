<?php
namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserService 
{
    public function __construct(private UserRepository $userRepository){}

    public function getAllUsers(Request $request)
    {
        $query = $this->userRepository->getQuery();

        if($request->filled('search'))
        {
            $query = $this->userRepository->search($query, $request->search);
        }

        return $query->paginate(15);
    }

    public function getUserById(int $id): User
    {
        return $this->userRepository->findById($id);
    }

    public function updateStatus(int $id)
    {
        $user = $this->userRepository->findById($id);
        return $this->userRepository->updateStatus($user);
    }

    // public function createUser($data, Request $request): 
}