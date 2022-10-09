<?php

declare(strict_types=1);

namespace App\Messenger\Dispatcher;

use ApiPlatform\Api\IriConverterInterface;
use App\Doctrine\Entity\Synchro;
use App\Messenger\Message\SynchroEuropeanFire;
use Symfony\Component\Messenger\MessageBusInterface;

final class SynchroEuropeanFireDispatcher implements SynchroDispatcherInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly IriConverterInterface $iriConverter,
    ) {
    }

    public function supports(Synchro $synchro): bool
    {
        return $synchro->isEuropeanFire();
    }

    public function execute(Synchro $synchro): void
    {
        $this->messageBus->dispatch(new SynchroEuropeanFire($this->iriConverter->getIriFromResource($synchro)));
    }
}
