<?php

declare(strict_types=1);

namespace App\Manager;

use App\Doctrine\Entity\EuropeanFire;
use App\Doctrine\Repository\EuropeanFireRepository;
use App\HttpClient\Model\EuropeanFire\Statistic;
use Doctrine\ORM\EntityManagerInterface;

final class EuropeanFireManager
{
    public function __construct(
        private readonly EntityManagerInterface $manager,
        private readonly EuropeanFireRepository $repository
    ) {
    }

    public function createOrUpdateByStatistic(Statistic $modelStatistic): void
    {
        if (null === $statistic = $this->repository->findOneBy(['country' => $modelStatistic->country, 'year' => $modelStatistic->year])) {
            $statistic = new EuropeanFire();
            $statistic->setCountry($modelStatistic->country);
            $statistic->setYear($modelStatistic->year);
        }

        $statistic->setArea($modelStatistic->area);
        $statistic->setNb($modelStatistic->nb);
        $statistic->setBurntArea($modelStatistic->burntArea);
        $statistic->setData($modelStatistic->data);

        $this->manager->persist($statistic);
        $this->manager->flush();
    }
}
