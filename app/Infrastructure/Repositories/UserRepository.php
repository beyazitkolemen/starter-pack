<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Auth\Repositories\UserRepositoryInterface;
use App\Domain\Auth\Entities\User;
use App\Domain\Auth\ValueObjects\Email;
use App\Infrastructure\Models\User as UserModel;

class UserRepository implements UserRepositoryInterface
{
    public function save(User $user): User
    {
        $userModel = new UserModel();
        $userModel->name = $user->getName()->getValue();
        $userModel->email = $user->getEmail()->getValue();
        $userModel->password = $user->getPassword()->hash();
        $userModel->save();

        // Domain entity'yi güncelle
        $user->setId($userModel->id);

        return $user;
    }

    public function findById(int $id): ?User
    {
        $userModel = UserModel::find($id);

        if (!$userModel) {
            return null;
        }

        return $userModel->toDomainEntity();
    }

    public function findByEmail(Email $email): ?User
    {
        $userModel = UserModel::where('email', $email->getValue())->first();

        if (!$userModel) {
            return null;
        }

        return $userModel->toDomainEntity();
    }

    public function delete(int $id): bool
    {
        $userModel = UserModel::find($id);

        if (!$userModel) {
            return false;
        }

        return $userModel->delete();
    }
}
