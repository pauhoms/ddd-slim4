<?php
declare(strict_types=1);

namespace Tests\User\Unit\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use User\Domain\ValueObjects\UserPrivateKey;

final class UserPrivateKeyTest extends TestCase
{
    /** @test */
    public function privateKeyShouldBeConected(): void
    {
        $key1 = UserPrivateKey::generate()->value();
        $key2 = UserPrivateKey::generate()->value();

        $this->assertNotTrue($key1 === $key2);
        $this->assertTrue(is_string($key1));
        $this->assertTrue(is_string($key2));
    }
}

