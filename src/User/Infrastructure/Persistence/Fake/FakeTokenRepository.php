<?php
declare(strict_types=1);

namespace User\Infrastructure\Persistence\Fake;

use User\Domain\Repositories\TokenRepository;

final class FakeTokenRepository implements TokenRepository
{
    public function generate(string $username, string $secretKey): string
    {
        return "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0N9l";
    }

    public function decode(string $token, string $secretKey): array
    {
        return [
            'currentTime'  => 00000,
            'expireTime'  => 999999,
            'data' => ['username' => 'esther']
        ];
    }
}
