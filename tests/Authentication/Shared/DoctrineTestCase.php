<?php
declare(strict_types=1);

namespace Tests\Authentication\Shared;


use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

abstract class DoctrineTestCase extends TestCase
{
    protected function getEntityManager(): EntityManager
    {
        $data = require __DIR__ . '/../../../apps/configuration/database.php';
        $entityManager = $data();
        $entityManager->getConnection()->connect();

        return $entityManager;
    }
}
