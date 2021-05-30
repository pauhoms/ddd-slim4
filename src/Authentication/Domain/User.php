<?php


namespace Authentication\Domain;


use Authentication\Domain\ValueObjects\UserId;
use Authentication\Domain\ValueObjects\UserName;
use Authentication\Domain\ValueObjects\UserPassword;

final class User
{
    private UserId       $id;
    private UserName     $name;
    private UserPassword $password;

    public function __construct(
        UserId $id,
        UserName $name,
        UserPassword $password
    ) {
        $this->id       = $id;
        $this->name     = $name;
        $this->password = $password;
    }

    public function name(): UserName
    {
        return $this->name;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public static function create(UserName $name, UserPassword $password): self
    {
        $password->encryptPassword();
        return new User(UserId::random(), $name, $password);
    }
}
