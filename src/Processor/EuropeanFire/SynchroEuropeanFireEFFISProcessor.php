<?php

declare(strict_types=1);

namespace App\Processor\EuropeanFire;

use App\Doctrine\Entity\Synchro;
use App\HttpClient\Client\EuropeanFire\EuropeanFireClientInterface;
use App\Manager\EuropeanFireManager;

final class SynchroEuropeanFireEFFISProcessor
{
    public function __construct(
        private readonly EuropeanFireClientInterface $client,
        private readonly EuropeanFireManager $europeanFireManager,
    ) {
    }

    public function process(Synchro $synchro): void
    {
        $lastSynchro = $synchro->getDataType()->getLastSynchroDate();

        $statistics = $this->client->getStatistics($lastSynchro);
        foreach ($statistics as $statistic) {
            $this->europeanFireManager->createOrUpdateByStatistic($statistic);
        }
    }
}
