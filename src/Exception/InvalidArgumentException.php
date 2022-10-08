<?php

declare(strict_types=1);

namespace App\Exception;

final class InvalidArgumentException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Invalid argument exception');
    }
}
