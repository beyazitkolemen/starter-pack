<?php

namespace App\Domain\Auth\Entities;

use App\Domain\Auth\ValueObjects\Name;
use App\Domain\Auth\ValueObjects\Email;
use App\Domain\Auth\ValueObjects\Password;

class User
{
    private ?int $id = null;
    private Name $name;
    private Email $email;
    private Password $password;
    private ?string $emailVerifiedAt = null;
    private ?string $rememberToken = null;

    public function __construct(array $attributes = [])
    {
        if (!isset($attributes['name'])) {
            throw new \InvalidArgumentException('Name is required');
        }
        if (!isset($attributes['email'])) {
            throw new \InvalidArgumentException('Email is required');
        }
        if (!isset($attributes['password'])) {
            throw new \InvalidArgumentException('Password is required');
        }

        $this->name = new Name($attributes['name']);
        $this->email = new Email($attributes['email']);
        $this->password = new Password($attributes['password']);

        if (isset($attributes['id'])) {
            $this->id = $attributes['id'];
        }

        if (isset($attributes['email_verified_at'])) {
            $this->emailVerifiedAt = $attributes['email_verified_at'];
        }

        if (isset($attributes['remember_token'])) {
            $this->rememberToken = $attributes['remember_token'];
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getEmailVerifiedAt(): ?string
    {
        return $this->emailVerifiedAt;
    }

    public function getRememberToken(): ?string
    {
        return $this->rememberToken;
    }

    public function setName(Name $name): void
    {
        $this->name = $name;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function setPassword(Password $password): void
    {
        $this->password = $password;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setEmailVerifiedAt(?string $emailVerifiedAt): void
    {
        $this->emailVerifiedAt = $emailVerifiedAt;
    }

    public function setRememberToken(?string $rememberToken): void
    {
        $this->rememberToken = $rememberToken;
    }

    public function verifyPassword(Password $password): bool
    {
        return $password->verify($this->password->getValue());
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name->getValue(),
            'email' => $this->email->getValue(),
            'password' => $this->password->getValue(),
            'email_verified_at' => $this->emailVerifiedAt,
            'remember_token' => $this->rememberToken,
        ];
    }
}
