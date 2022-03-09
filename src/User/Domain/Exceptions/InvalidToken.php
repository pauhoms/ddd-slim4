<?php
declare(strict_types=1);

namespace User\Domain\Exceptions;


use RuntimeException;

final class InvalidToken extends RuntimeException
{
    public function __construct()
    {
        parent::__construct(sprintf("InvalidToken"));
    }
}
