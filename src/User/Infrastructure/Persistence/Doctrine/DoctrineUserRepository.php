<?php
declare(strict_types=1);

namespace User\Infrastructure\Persistence\Doctrine;


use User\Domain\User;
use User\Domain\ValueObjects\UserId;
use User\Domain\ValueObjects\UserName;
use User\Domain\ValueObjects\UserPassword;
use Doctrine\Common\Collections\Criteria as DoctrineCriteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Doctrine\DBAL\Schema\Comparator;
use Shared\Domain\Criteria\Criteria;
use Shared\Infrastructure\Persistance\Doctrine\DoctrineCriteriaConverter;
use Shared\Infrastructure\Persistance\Doctrine\DoctrineRepository;

final class DoctrineUserRepository extends DoctrineRepository
{
    public function save(User $user): void
    {
        $this->persist($user);
    }

    public function all(): array
    {
        return $this->repository()->findAll();
    }

    public function findById(UserId $userId): ?object
    {
        return $this->repository()->find($userId);
    }

    public function search(Criteria $criteria)
    {
        return $this->searchByCriteria($criteria);
    }

    protected function getClass(): string
    {
        return User::class;
    }
}
