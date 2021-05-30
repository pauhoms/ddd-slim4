<?php
declare(strict_types=1);

namespace Authentication\Infrastructure\Persistence\Doctrine;


use Authentication\Domain\User;
use Authentication\Domain\ValueObjects\UserId;
use Shared\Infrastructure\Persistance\Doctrine\DoctrineRepository;

final class DoctrineUserRepository extends DoctrineRepository
{
    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function all(): array
    {
        return $this->repository(User::class)->findAll();
    }

    public function findById(UserId $userId)
    {
        return $this->repository(User::class)->find($userId);
    }
}
