<?php
declare(strict_types=1);

namespace Tests\User\Unit\Application\Create;

use PHPUnit\Framework\TestCase;
use User\Application\Create\GenerateAuthenticationToken;
use User\Domain\Services\FindUserByName;
use User\Domain\User;
use User\Domain\ValueObjects\UserId;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;
use User\Domain\ValueObjects\UserPrivateKey;
use User\Infrastructure\Persistence\Fake\FakeTokenRepository;
use User\Infrastructure\Persistence\Fake\FakeUserRepository;

final class UserPrivateKeyTest extends TestCase
{
    /** @test */
    public function token_should_be_generated(): void
    {
        $tokenRepository = new FakeTokenRepository();
        $userRepository = new FakeUserRepository();
        $userRepository->save(
            new User(
                UserId::random(),
                new UserName("esther"),
                UserPassword::create("garcia"),
                UserPrivateKey::generate()
            )
        );

        $userService = new FindUserByName($userRepository);
        $generateToken = new GenerateAuthenticationToken(
            $tokenRepository,
            $userService
        );

        $this->assertNotNull(
            $generateToken->__invoke("esther", "garcia")
        );
    }
}

