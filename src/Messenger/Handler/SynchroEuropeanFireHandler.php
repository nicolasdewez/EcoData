<?php

declare(strict_types=1);

namespace App\Messenger\Handler;

use ApiPlatform\Api\IriConverterInterface;
use App\Doctrine\Entity\Synchro;
use App\Doctrine\Repository\SynchroRepository;
use App\Exception\InvalidArgumentException;
use App\Manager\SynchroManager;
use App\Messenger\Message\SynchroEuropeanFire;
use App\Processor\EuropeanFire\SynchroEuropeanFireEFFISProcessor;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SynchroEuropeanFireHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly IriConverterInterface $iriConverter,
        private readonly SynchroManager $synchroManager,
        private readonly SynchroRepository $synchroRepository,
        private readonly SynchroEuropeanFireEFFISProcessor $processor,
    ) {
    }

    public function __invoke(SynchroEuropeanFire $synchroEuropeanFire): void
    {
        $synchro = $this->iriConverter->getResourceFromIri($synchroEuropeanFire->getSynchroId());
        if (!$synchro instanceof Synchro) {
            throw new InvalidArgumentException();
        }

        $this->synchroManager->updateNbSteps($synchro, 1);

        $this->processor->process($synchro);

        $this->synchroRepository->incrementNbStepsProcessed($synchro);
        $this->synchroManager->tryComplete($synchro);
    }
}
