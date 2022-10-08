<?php

declare(strict_types=1);

namespace App\Messenger\Dispatcher;

use ApiPlatform\Api\IriConverterInterface;
use App\Doctrine\Entity\Synchro;
use App\Messenger\Message\SynchroPiezometry;
use Symfony\Component\Messenger\MessageBusInterface;

final class SynchroPiezometryDispatcher implements SynchroDispatcherInterface
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly IriConverterInterface $iriConverter,
    ) {
    }

    public function supports(Synchro $synchro): bool
    {
        return $synchro->isPiezometry();
    }

    public function execute(Synchro $synchro): void
    {
        $this->messageBus->dispatch(new SynchroPiezometry($this->iriConverter->getIriFromResource($synchro)));
    }
}
