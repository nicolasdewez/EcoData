<?php

declare(strict_types=1);

namespace App\EventDispatcher\Event;

use App\Doctrine\Entity\Synchro;
use Symfony\Contracts\EventDispatcher\Event;

final class SynchroCreatedEvent extends Event
{
    public function __construct(private readonly Synchro $synchro)
    {
    }

    public function getSynchro(): Synchro
    {
        return $this->synchro;
    }
}
