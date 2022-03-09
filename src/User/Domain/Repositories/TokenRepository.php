<?php
declare(strict_types=1);

namespace User\Domain\Repositories;

interface TokenRepository {
    public function generate(string $username, string $secretKey): string;
    public function decode(string $token, string $secretKey): array;
}
