<?php

declare(strict_types=1);

namespace App\Processor\Synchro;

use App\Doctrine\Entity\PiezometryStation;
use App\Doctrine\Entity\Synchro;
use App\HttpClient\Client\Piezometry\PiezometryClientInterface;
use App\Manager\PiezometryMeasurementManager;
use App\Manager\PiezometryStationManager;

final class SynchroPiezometryFrProcessor
{
    public function __construct(
        private readonly PiezometryClientInterface $client,
        private readonly PiezometryStationManager $stationManager,
        private readonly PiezometryMeasurementManager $measurementManager
    ) {
    }

    public function processStations(Synchro $synchro): void
    {
        $lastSynchro = $synchro->getDataType()->getLastSynchroDate();

        $stations = $this->stationManager->getStationsBasic();
        $newStations = $this->client->getStations($stations, $lastSynchro);

        foreach ($newStations as $newStation) {
            $this->stationManager->createByStation($newStation);
        }
    }

    public function processStation(PiezometryStation $station, Synchro $synchro): void
    {
        $lastSynchro = $synchro->getDataType()->getLastSynchroDate();

        $newMeasurements = $this->client->getMeasurements($station->getExternalCode(), $lastSynchro);

        $maxMeasurement = null;
        foreach ($newMeasurements as $newMeasurement) {
            $this->measurementManager->createByMeasurement($newMeasurement, $station);
            $maxMeasurement = clone $newMeasurement->date;
        }

        $this->stationManager->update($station, $maxMeasurement);
    }
}
