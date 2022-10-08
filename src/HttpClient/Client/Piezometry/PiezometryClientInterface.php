<?php

declare(strict_types=1);

namespace App\HttpClient\Client\Piezometry;

use App\HttpClient\Model\Piezometry\Measurement;
use App\HttpClient\Model\Piezometry\Station;

interface PiezometryClientInterface
{
    /**
     * @param array<string, int> $stations
     *
     * @return array<string, Station>
     */
    public function getStations(array $stations, ?\DateTimeImmutable $lastSynchro): array;

    /**
     * @return array<Measurement>
     */
    public function getMeasurements(string $externalCode, ?\DateTimeImmutable $lastSynchro): array;
}
