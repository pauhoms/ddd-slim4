<?php
declare(strict_types=1);

namespace User\Application\Create;

use User\Domain\Repositories\TokenRepository;
use User\Domain\Services\FindUserByName;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;

final class GenerateAuthenticationToken
{
    public function __construct(
        private TokenRepository $tokenRepository,
        private FindUserByName    $findUserByName
    )
    {}

    public function __invoke(string $username, string $password): string
    {
        $user = $this->findUserByName->__invoke(new UserName($username));
        $password = new UserPassword($password);

        $user->password()->comparePassword($password);

        return $this->tokenRepository->generate(
            $user->name()->value(),
            $user->privateKey()->value()
        );
    }
}

