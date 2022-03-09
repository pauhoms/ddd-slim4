<?php
declare(strict_types=1);

namespace Tests\User\Unit\Application\Create;

use PHPUnit\Framework\TestCase;
use User\Application\Create\GenerateAuthenticationToken;
use User\Domain\Exceptions\PasswordDoesNotMatch;
use User\Domain\Exceptions\UserNotFound;
use User\Domain\Repositories\TokenRepository;
use User\Domain\Repositories\UserRepository;
use User\Domain\Services\FindUserByName;
use User\Domain\User;
use User\Domain\ValueObjects\UserId;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;
use User\Domain\ValueObjects\UserPrivateKey;
use User\Infrastructure\Persistence\Fake\FakeTokenRepository;
use User\Infrastructure\Persistence\Fake\FakeUserRepository;

final class GenerateAuthenticationTokenTest extends TestCase
{
    private TokenRepository $tokenRepository;
    private UserRepository  $userRepository;

    protected function setUp(): void
    {
        $this->tokenRepository = new FakeTokenRepository();
        $this->userRepository  = new FakeUserRepository();
    }

    /** @test */
    public function token_should_be_generated(): void
    {
        $this->userRepository->save(
            new User(
                UserId::random(),
                new UserName("esther"),
                UserPassword::create("garcia"),
                UserPrivateKey::generate()
            )
        );

        $userService = new FindUserByName($this->userRepository);
        $service = new GenerateAuthenticationToken(
            $this->tokenRepository,
            $userService
        );

        $this->assertNotNull(
            $service->__invoke("esther", "garcia")
        );
    }

    /** @test */
    public function user_should_not_exist(): void
    {
        $userService = new FindUserByName($this->userRepository);
        $service = new GenerateAuthenticationToken(
            $this->tokenRepository,
            $userService
        );

        $this->expectException(UserNotFound::class);
        $service->__invoke("test", "garcia");
    }

    /** @test */
    public function password_should_not_be_match(): void
    {
        $userService = new FindUserByName($this->userRepository);
        $this->userRepository->save(
            new User(
                UserId::random(),
                new UserName("esther"),
                UserPassword::create("garcia"),
                UserPrivateKey::generate()
            )
        );
        $service = new GenerateAuthenticationToken(
            $this->tokenRepository,
            $userService
        );

        $this->expectException(PasswordDoesNotMatch::class);
        $service->__invoke("esther", "homs");
    }
}

