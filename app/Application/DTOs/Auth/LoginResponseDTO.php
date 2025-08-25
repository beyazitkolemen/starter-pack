<?php

namespace App\Application\DTOs\Auth;

use App\Domain\Auth\Entities\User;

class LoginResponseDTO
{
    public function __construct(
        public readonly User $user,
        public readonly string $token
    ) {}

    public function toArray(): array
    {
        return [
            'status' => 'success',
            'message' => 'Başarılı giriş',
            'data' => [
                'user' => [
                    'id' => $this->user->getId(),
                    'name' => $this->user->getName()->getValue(),
                    'email' => $this->user->getEmail()->getValue(),
                ],
                'token' => $this->token,
            ]
        ];
    }
}
