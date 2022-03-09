<?php
declare(strict_types=1);

namespace User\Domain\Exceptions;


use RuntimeException;

class PasswordDoesNotMatch extends RuntimeException
{
    public function __construct()
    {
        parent::__construct(sprintf("Password doesn't match"));
    }
}
