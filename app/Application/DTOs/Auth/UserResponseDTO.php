<?php

namespace App\Application\DTOs\Auth;

use App\Domain\Auth\Entities\User;

class UserResponseDTO
{
    public function __construct(
        public readonly User $user
    ) {}

    public function toArray(): array
    {
        return [
            'status' => 'success',
            'data' => [
                'user' => [
                    'id' => $this->user->getId(),
                    'name' => $this->user->getName()->getValue(),
                    'email' => $this->user->getEmail()->getValue(),
                ]
            ]
        ];
    }
}
