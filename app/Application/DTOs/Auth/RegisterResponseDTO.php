<?php

namespace App\Application\DTOs\Auth;

use App\Domain\Auth\Entities\User;

class RegisterResponseDTO
{
    public function __construct(
        public readonly User $user,
        public readonly string $token
    ) {}

    public function toArray(): array
    {
        return [
            'status' => 'success',
            'message' => 'Kullanıcı başarıyla oluşturuldu',
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
