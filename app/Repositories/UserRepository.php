<?php

namespace App\Repositories;
use App\Models\User;


class UserRepository
{

    public function __construct(
        public User $userModel
    )
    {
    }

    public function getAdmins()
    {
        return $this->userModel->isAdmins()->get();
    }

    public function getUsers()
    {
        return $this->userModel->get();
    }

    public function findById(int $id): ?User
    {
        return $this->userModel->find($id);
    }

    public function getUserByEmail(string $email): User
    {
        return $this->userModel->where('email', $email)->first();
    }

    public function createUser(array $data): User
    {
        $user = $this->userModel->create($data);
        $user->stores()->sync($data['store_ids']);
        return $user;
    }

    /**
     * update user
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateUser(User $user, array $data): array
    {
        $user->update($data);
        $user->stores()->sync($data['store_ids']);
        return $user->toArray();
    }
}
