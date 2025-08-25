<?php

namespace App\Domain\Auth\Services;

use App\Domain\Auth\Repositories\UserRepositoryInterface;
use App\Domain\Auth\Entities\User;
use App\Domain\Auth\ValueObjects\Email;
use App\Domain\Auth\ValueObjects\Password;
use App\Domain\Auth\ValueObjects\Name;
use App\Domain\Auth\Exceptions\InvalidCredentialsException;
use App\Domain\Auth\Exceptions\UserNotFoundException;

class AuthService
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function register(string $name, string $email, string $password): array
    {
        $nameValueObject = new Name($name);
        $emailValueObject = new Email($email);
        $passwordValueObject = new Password($password);

        // Email benzersizlik kontrolü
        if ($this->userRepository->findByEmail($emailValueObject)) {
            throw new \InvalidArgumentException('Bu email adresi zaten kullanılıyor');
        }

        // User entity oluştur
        $user = new User(
            $nameValueObject,
            $emailValueObject,
            $passwordValueObject
        );

        // User'ı kaydet
        $savedUser = $this->userRepository->save($user);

        // Token oluştur
        $token = $savedUser->createToken('auth_token');

        return [
            'user' => $savedUser,
            'token' => $token
        ];
    }

    public function login(string $email, string $password): array
    {
        $emailValueObject = new Email($email);
        $passwordValueObject = new Password($password);

        $user = $this->userRepository->findByEmail($emailValueObject);

        if (!$user) {
            throw new UserNotFoundException('Kullanıcı bulunamadı');
        }

        if (!$user->verifyPassword($passwordValueObject)) {
            throw new InvalidCredentialsException('Geçersiz kimlik bilgileri');
        }

        $token = $user->createToken('auth_token');

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout(int $userId): void
    {
        $user = $this->userRepository->findById($userId);

        if (!$user) {
            throw new UserNotFoundException('Kullanıcı bulunamadı');
        }

        $user->revokeCurrentToken();
    }

    public function getCurrentUser(int $userId): User
    {
        $user = $this->userRepository->findById($userId);

        if (!$user) {
            throw new UserNotFoundException('Kullanıcı bulunamadı');
        }

        return $user;
    }
}
