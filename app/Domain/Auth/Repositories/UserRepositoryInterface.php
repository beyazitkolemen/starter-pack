<?php

namespace App\Domain\Auth\Repositories;

use App\Domain\Auth\Entities\User;
use App\Domain\Auth\ValueObjects\Email;

interface UserRepositoryInterface
{
    public function save(User $user): User;
    public function findById(int $id): ?User;
    public function findByEmail(Email $email): ?User;
    public function delete(int $id): bool;
}
