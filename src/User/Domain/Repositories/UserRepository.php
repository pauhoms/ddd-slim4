<?php
declare(strict_types=1);

namespace User\Domain\Repositories;

use Shared\Domain\Criteria\Criteria;
use User\Domain\User;
use User\Domain\ValueObjects\UserId;

interface UserRepository {
    public function save(User $user): void;
    public function findById(UserId $userId): ?User;
    public function search(Criteria $criteria): array;
}
