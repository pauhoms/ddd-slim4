<?php
declare(strict_types=1);

namespace Tests\Authentication\User\Unit\Infrastructure;


use Authentication\Domain\User;
use Authentication\Domain\ValueObjects\UserName;
use Authentication\Domain\ValueObjects\UserPassword;
use Authentication\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use Tests\Authentication\Shared\DoctrineTestCase;


final class DoctrineUserRepositoryTest extends DoctrineTestCase
{
    private DoctrineUserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new DoctrineUserRepository($this->getEntityManager());
    }

    /** @test */
    public function userShouldBeSaved(): void
    {
        $user = User::create(new UserName("pau"), new UserPassword("root"));
        $this->userRepository->save($user);

        $this->assertNotNull($this->userRepository->findById($user->id()));
    }
}