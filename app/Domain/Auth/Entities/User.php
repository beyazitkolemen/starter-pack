<?php

namespace App\Domain\Auth\Entities;

use App\Domain\Auth\ValueObjects\Name;
use App\Domain\Auth\ValueObjects\Email;
use App\Domain\Auth\ValueObjects\Password;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    private ?Name $nameValueObject = null;
    private ?Email $emailValueObject = null;
    private ?Password $passwordValueObject = null;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (isset($attributes['name'])) {
            $this->nameValueObject = new Name($attributes['name']);
        }

        if (isset($attributes['email'])) {
            $this->emailValueObject = new Email($attributes['email']);
        }

        if (isset($attributes['password'])) {
            $this->passwordValueObject = new Password($attributes['password']);
        }
    }

    public function setName(Name $name): void
    {
        $this->nameValueObject = $name;
        $this->attributes['name'] = $name->getValue();
    }

    public function setEmail(Email $email): void
    {
        $this->emailValueObject = $email;
        $this->attributes['email'] = $email->getValue();
    }

    public function setPassword(Password $password): void
    {
        $this->passwordValueObject = $password;
        $this->attributes['password'] = $password->hash();
    }

    public function getName(): Name
    {
        if (!$this->nameValueObject) {
            $this->nameValueObject = new Name($this->attributes['name']);
        }
        return $this->nameValueObject;
    }

    public function getEmail(): Email
    {
        if (!$this->emailValueObject) {
            $this->emailValueObject = new Email($this->attributes['email']);
        }
        return $this->emailValueObject;
    }

    public function verifyPassword(Password $password): bool
    {
        return $password->verify($this->attributes['password']);
    }

    public function setId(int $id): void
    {
        $this->attributes['id'] = $id;
    }

    public function getPassword(): Password
    {
        if (!$this->passwordValueObject) {
            $this->passwordValueObject = new Password($this->attributes['password']);
        }
        return $this->passwordValueObject;
    }

    public function revokeCurrentToken(): void
    {
        if ($this->currentAccessToken()) {
            $this->currentAccessToken()->delete();
        }
    }
}
