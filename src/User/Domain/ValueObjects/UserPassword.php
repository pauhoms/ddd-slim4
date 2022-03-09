<?php
declare(strict_types=1);

namespace User\Domain\ValueObjects;


use User\Domain\Exceptions\InvalidPasswordEncryptation;
use Shared\Domain\ValueObjects\StringValueObject;
use User\Domain\Exceptions\PasswordDoesNotMatch;

final class UserPassword extends StringValueObject
{
    private array $encryptOptions = [
        'cost' => 12,
    ];

    public static function create(string $password): self
    {
        $passwordObject = new self($password);
        $passwordObject->encryptPassword();

        return $passwordObject;
    }

    public function encryptPassword(): void
    {
        if ($this->isEmpty())
            throw new InvalidPasswordEncryptation();

        $this->value = password_hash($this->value(), PASSWORD_BCRYPT, $this->encryptOptions);
    }

    public function comparePassword(UserPassword $password): void
    {
        if (!password_verify($password->value(), $this->value()))
            throw new PasswordDoesNotMatch();
    }
}
