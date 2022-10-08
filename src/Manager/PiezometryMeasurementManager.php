<?php

declare(strict_types=1);

namespace App\Manager;

use App\Doctrine\Entity\PiezometryMeasurement;
use App\Doctrine\Entity\PiezometryStation;
use App\HttpClient\Model\Piezometry\Measurement;
use Doctrine\ORM\EntityManagerInterface;

final class PiezometryMeasurementManager
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    public function createByMeasurement(Measurement $modelMeasurement, PiezometryStation $station): void
    {
        $measurement = new PiezometryMeasurement();

        $measurement->setStation($station);
        $measurement->setDate($modelMeasurement->date);
        $measurement->setValue($modelMeasurement->value);
        $measurement->setData($modelMeasurement->data);

        $this->manager->persist($measurement);
        $this->manager->flush();
    }
}
