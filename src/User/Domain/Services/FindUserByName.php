<?php
declare(strict_types=1);

namespace User\Domain\Services;

use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterField;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\Criteria\Filters;
use Shared\Domain\Criteria\FilterValue;
use Shared\Domain\Criteria\Order;
use Shared\Domain\Criteria\OrderBy;
use User\Domain\Exceptions\UserNotFound;
use User\Domain\Repositories\UserRepository;
use User\Domain\User;
use User\Domain\ValueObjects\UserName;

final class FindUserByName
{
    public function __construct(private UserRepository $userRepository)
    {}

    public function __invoke(UserName $userName): User
    {
        $users = $this->userRepository->search($this->createCriterial($userName));
        $this->guard($users);

        return $users[0];
    }

    private function guard(array $user): void
    {
        if (count($user) === 0)
            throw new UserNotFound();
    }

    private function createCriterial(UserName $userName): Criteria
    {
        $filters = new Filters([new Filter(
            new FilterField('name.value'),
            new FilterOperator('='),
            new FilterValue($userName->value())
        )]);

        return new Criteria(
            $filters,
            Order::createAsc(new OrderBy("username.value")),
            null,
            null
        );
    }
}
