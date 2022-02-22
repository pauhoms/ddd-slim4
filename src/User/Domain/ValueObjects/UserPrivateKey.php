<?php
declare(strict_types=1);

namespace User\Domain\ValueObjects;


use Shared\Domain\ValueObjects\StringValueObject;

final class UserPrivateKey extends StringValueObject
{
    private static string $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ./=[],';

    public static function generate(): UserPrivateKey
    {
        $newKey = array_reduce(
            str_split(self::$characters),
            fn (string $carry) => $carry .= self::$characters[
                rand(0, sizeof(str_split(self::$characters)) - 1)
            ],
            '' 
        );

        return new UserPrivateKey($newKey);
    }
}
