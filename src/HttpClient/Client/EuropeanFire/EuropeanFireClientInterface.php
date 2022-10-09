<?php

declare(strict_types=1);

namespace App\HttpClient\Client\EuropeanFire;

use App\HttpClient\Model\EuropeanFire\Statistic;

interface EuropeanFireClientInterface
{
    /**
     * @return array<string, Statistic>
     */
    public function getStatistics(?\DateTimeImmutable $lastSynchro): array;
}
