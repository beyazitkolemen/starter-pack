<?php

namespace Tests\Domain\Auth;

use App\Domain\Auth\ValueObjects\Password;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    public function test_it_accepts_valid_password(): void
    {
        $password = new Password('secret123');
        $this->assertSame('secret123', $password->getValue());
    }

    public function test_it_rejects_empty_password(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Password('');
    }

    public function test_it_rejects_short_password(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Password('short');
    }

    public function test_hash_and_verify_password(): void
    {
        $password = new Password('secret123');
        $hash = $password->hash();
        $this->assertTrue((new Password('secret123'))->verify($hash));
        $this->assertFalse((new Password('wrongpass'))->verify($hash));
    }
}

