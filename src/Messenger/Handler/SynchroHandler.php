<?php

declare(strict_types=1);

namespace App\Messenger\Handler;

use ApiPlatform\Api\IriConverterInterface;
use App\Doctrine\Entity\Synchro;
use App\Exception\InvalidArgumentException;
use App\Messenger\Dispatcher\SynchroDispatcher;
use App\Messenger\Message\StartSynchro;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SynchroHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly IriConverterInterface $iriConverter,
        private readonly SynchroDispatcher $dispatcher,
    ) {
    }

    public function __invoke(StartSynchro $startSynchro): void
    {
        $synchro = $this->iriConverter->getResourceFromIri($startSynchro->getSynchroId());
        if (!$synchro instanceof Synchro) {
            throw new InvalidArgumentException();
        }

        $this->dispatcher->execute($synchro);
    }
}
