<?php

declare(strict_types=1);

namespace App\Doctrine\Listener;

use App\Doctrine\Entity\Synchro;
use App\EventDispatcher\Event\SynchroCreatedEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class SynchroListener implements EntityListenerInterface
{
    public function __construct(private readonly EventDispatcherInterface $dispatcher)
    {
    }

    public function postPersist(Synchro $synchro): void
    {
        $this->dispatcher->dispatch(new SynchroCreatedEvent($synchro));
    }
}
