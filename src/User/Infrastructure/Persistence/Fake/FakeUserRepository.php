<?php
declare(strict_types=1);

namespace User\Infrastructure\Persistence\Fake;


use User\Domain\User;
use User\Domain\ValueObjects\UserId;
use Shared\Domain\Criteria\Criteria;
use User\Domain\Repositories\UserRepository;

final class FakeUserRepository implements UserRepository 
{
    public function __construct(private array $value = [])
    {
    }

    public function save(User $user): void
    {
        array_push($this->value, $user);  
    }

    public function all(): array
    {
        return $this->value;
    }

    public function findById(UserId $userId): ?User
    {
        return count($this->value) === 0 ? null : $this->value[0];
    }

    public function search(Criteria $criteria): array
    {
        return $this->value;
    }
}
