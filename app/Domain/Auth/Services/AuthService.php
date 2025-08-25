<?php

namespace App\Domain\Auth\Services;

use App\Domain\Auth\Repositories\UserRepositoryInterface;
use App\Domain\Auth\Entities\User;
use App\Domain\Auth\ValueObjects\Email;
use App\Domain\Auth\ValueObjects\Password;
use App\Domain\Auth\ValueObjects\Name;
use App\Domain\Auth\Exceptions\InvalidCredentialsException;
use App\Domain\Auth\Exceptions\UserNotFoundException;
use App\Infrastructure\Models\User as UserModel;

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
        $user = new User([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        // User'ı kaydet
        $savedUser = $this->userRepository->save($user);

        // Infrastructure model üzerinden token oluştur
        $userModel = UserModel::find($savedUser->getId());
        $tokenResult = $userModel->createToken('auth_token');

        return [
            'user' => $savedUser,
            'token' => $tokenResult->plainTextToken
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

        // Infrastructure model üzerinden token oluştur
        $userModel = UserModel::find($user->getId());
        $tokenResult = $userModel->createToken('auth_token');

        return [
            'user' => $user,
            'token' => $tokenResult->plainTextToken
        ];
    }

    public function logout(int $userId): void
    {
        $user = $this->userRepository->findById($userId);

        if (!$user) {
            throw new UserNotFoundException('Kullanıcı bulunamadı');
        }

        // Infrastructure model üzerinden token iptal et
        $userModel = UserModel::find($userId);
        if ($userModel && $userModel->currentAccessToken()) {
            $userModel->currentAccessToken()->delete();
        }
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
