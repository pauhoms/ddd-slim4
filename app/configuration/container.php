<?php

use DI\ContainerBuilder;
use Doctrine\ORM\EntityManager;
use User\Domain\Repositories\TokenRepository;
use User\Domain\Repositories\UserRepository;
use User\Domain\Services\FindUserByName;
use User\Infrastructure\JwtTokenRepository;
use User\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;

$data = require __DIR__ . '/database.php';
$entityManager = $data();
$userRepository = new DoctrineUserRepository($entityManager);

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    EntityManager::class => fn () => $entityManager,
    TokenRepository::class => fn () => new JwtTokenRepository(),
    FindUserName::class => fn () => new FindUserByName($userRepository),
    UserRepository::class => fn () => $userRepository
]);

return $containerBuilder;
