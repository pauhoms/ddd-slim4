<?php
declare(strict_types=1);

namespace User\Infrastructure;

use Firebase\JWT\JWT;
use User\Domain\Exceptions\InvalidToken;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\ExpiredException;
use UnexpectedValueException;
use InvalidArgumentException;
use User\Domain\Repositories\TokenRepository;

final class JwtTokenRepository implements TokenRepository
{
    private static string $algorithm = 'HS256';

    public function generate(string $username, string $secretKey): string
    {
        $currentTime = time();
        $expireTime = $currentTime + (60 * 60);

        $token = [
            'currentTime'  => $currentTime,
            'expireTime'  => $expireTime,
            'data' => ['username' => $username]
        ];

        return JWT::encode($token, $secretKey, self::$algorithm);
    }

    public function decode(string $token, string $secretKey): array
    {
        try {
            return json_decode(json_encode(
                JWT::decode($token, $secretKey, self::$algorithm)
            ), true);
        } catch (
                 SignatureInvalidException|
                 InvalidArgumentException|
                 UnexpectedValueException|
                 ExpiredException $e
        ) {
            throw new InvalidToken();
        }
    }
}
