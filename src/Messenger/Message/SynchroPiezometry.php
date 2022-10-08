<?php

declare(strict_types=1);

namespace App\Messenger\Message;

final class SynchroPiezometry
{
    public function __construct(
        protected readonly string $synchroId,
        private readonly ?int $idStation = null
    ) {
    }

    public function getSynchroId(): string
    {
        return $this->synchroId;
    }

    public function getIdStation(): ?int
    {
        return $this->idStation;
    }
}
