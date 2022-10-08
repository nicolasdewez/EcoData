<?php

declare(strict_types=1);

namespace App\Messenger\Message;

final class StartSynchro
{
    public function __construct(private readonly string $synchroId)
    {
    }

    public function getSynchroId(): string
    {
        return $this->synchroId;
    }
}
