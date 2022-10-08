<?php

declare(strict_types=1);

namespace App\Manager;

use App\Doctrine\Entity\PiezometryStation;
use App\Doctrine\Repository\PiezometryStationRepository;
use App\HttpClient\Model\Piezometry\Station;
use Doctrine\ORM\EntityManagerInterface;

final class PiezometryStationManager
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly PiezometryStationRepository $repository
    ) {
    }

    /**
     * @return array<string, int>
     */
    public function getStationsBasic(): array
    {
        $elements = $this->repository->getAllBasics();

        return array_flip(array_column($elements, 'externalCode'));
    }

    public function createByStation(Station $modelStation): void
    {
        $station = new PiezometryStation();

        $station->setExternalCode($modelStation->externalCode);
        $station->setTitle($modelStation->title);
        $station->setCodeDepartment($modelStation->codeDepartment);
        $station->setCity($modelStation->city);
        $station->setStartDate($modelStation->startDate);
        $station->setEndDate($modelStation->endDate);
        $station->setData($modelStation->data);

        $this->manager->persist($station);
        $this->manager->flush();
    }

    public function update(PiezometryStation $station, ?\DateTimeImmutable $lastDateMeasurement): void
    {
        if (null !== $lastDateMeasurement) {
            $station->setEndDate($lastDateMeasurement);
            $this->manager->persist($station);
            $this->manager->flush();

            return;
        }

        $station->setEnabled($station->isRecent());
        $this->manager->persist($station);
        $this->manager->flush();
    }
}
