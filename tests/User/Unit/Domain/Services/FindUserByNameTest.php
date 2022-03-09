<?php
declare(strict_types=1);

namespace Tests\User\Unit\Domain\Services;

use PHPUnit\Framework\TestCase;
use User\Domain\Exceptions\UserNotFound;
use User\Domain\Services\FindUserByName;
use User\Domain\User;
use User\Domain\ValueObjects\UserId;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;
use User\Domain\ValueObjects\UserPrivateKey;
use User\Infrastructure\Persistence\Fake\FakeUserRepository;

final class FindUserByNameTest extends TestCase
{
    /** @test */
    public function user_should_be_finded(): void
    {
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
        $this->assertNotNull(
            $userService->__invoke(new UserName("esther"))
        );
    }

    /** @test */
    public function user_should_not_be_finded(): void
    {
        $userRepository = new FakeUserRepository();
        $userService = new FindUserByName($userRepository);

        $this->expectException(UserNotFound::class);
        $userService->__invoke(new UserName("esther"));
    }
}

