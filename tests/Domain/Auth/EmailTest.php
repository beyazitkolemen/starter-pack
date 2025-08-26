<?php

namespace Tests\Domain\Auth;

use App\Domain\Auth\ValueObjects\Email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function test_it_accepts_valid_email(): void
    {
        $email = new Email('test@example.com');
        $this->assertSame('test@example.com', $email->getValue());
    }

    public function test_it_rejects_empty_email(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('');
    }

    public function test_it_rejects_invalid_format(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email('invalid');
    }

    public function test_it_rejects_too_long_email(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Email(str_repeat('a', 256).'@example.com');
    }
}

