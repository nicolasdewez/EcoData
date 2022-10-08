<?php

declare(strict_types=1);

namespace App\Messenger\Handler;

use ApiPlatform\Api\IriConverterInterface;
use App\Doctrine\Entity\PiezometryStation;
use App\Doctrine\Entity\Synchro;
use App\Doctrine\Repository\PiezometryStationRepository;
use App\Doctrine\Repository\SynchroRepository;
use App\Exception\InvalidArgumentException;
use App\Manager\SynchroManager;
use App\Messenger\Dispatcher\SynchroPiezometryStationDispatcher;
use App\Messenger\Message\SynchroPiezometry;
use App\Processor\Synchro\SynchroPiezometryFrProcessor;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SynchroPiezometryHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly IriConverterInterface $iriConverter,
        private readonly SynchroPiezometryFrProcessor $processor,
        private readonly SynchroManager $synchroManager,
        private readonly SynchroRepository $synchroRepository,
        private readonly PiezometryStationRepository $stationRepository,
        private readonly SynchroPiezometryStationDispatcher $dispatcher,
    ) {
    }

    public function __invoke(SynchroPiezometry $synchroPiezometry): void
    {
        $synchro = $this->iriConverter->getResourceFromIri($synchroPiezometry->getSynchroId());
        if (!$synchro instanceof Synchro) {
            throw new InvalidArgumentException();
        }

        if (null === $synchroPiezometry->getIdStation()) {
            $this->synchroStations($synchro);

            return;
        }

        $station = $this->stationRepository->find($synchroPiezometry->getIdStation());
        if (!$station instanceof PiezometryStation) {
            throw new InvalidArgumentException();
        }

        $this->synchroStation($station, $synchro);
    }

    private function synchroStations(Synchro $synchro): void
    {
        // nbSteps = 2 ==> list stations + at least one station
        $this->synchroManager->updateNbSteps($synchro, 2);

        // Process
        $this->processor->processStations($synchro);
        $this->synchroRepository->incrementNbStepsProcessed($synchro);

        // Prepare next steps
        // TODO: Delete the limit
        $stations = $this->stationRepository->findBy(['enabled' => true], [], 5);

        $this->synchroManager->updateNbSteps($synchro, 1 + \count($stations));
        foreach ($stations as $station) {
            $this->dispatcher->execute($synchro, $station);
        }
    }

    private function synchroStation(PiezometryStation $station, Synchro $synchro): void
    {
        $this->processor->processStation($station, $synchro);
        $this->synchroRepository->incrementNbStepsProcessed($synchro);
        $this->synchroManager->tryComplete($synchro);
    }
}
