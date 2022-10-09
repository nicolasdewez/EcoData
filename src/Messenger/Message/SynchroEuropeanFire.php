<?php

declare(strict_types=1);

namespace App\Messenger\Message;

final class SynchroEuropeanFire
{
    public function __construct(protected readonly string $synchroId)
    {
    }

    public function getSynchroId(): string
    {
        return $this->synchroId;
    }
}
