<?php

declare(strict_types=1);

namespace App\HttpClient\Transformer\Piezometry;

use App\HttpClient\Model\Piezometry\Measurement;
use App\HttpClient\Model\Piezometry\Station;

final class PiezometryFrHubeauTransformer
{
    /**
     * @param array<string, mixed> $data
     */
    public function transformStation(array $data): Station
    {
        $station = new Station();
        $station->externalCode = $data['code_bss'];
        $station->title = $data['libelle_pe'];
        $station->city = $data['nom_commune'];
        $station->codeDepartment = $data['code_departement'];
        $station->startDate = new \DateTimeImmutable($data['date_debut_mesure']);
        $station->endDate = new \DateTimeImmutable($data['date_fin_mesure']);
        $station->data = $data;

        return $station;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function transformMeasurement(array $data): Measurement
    {
        $measurement = new Measurement();
        $measurement->date = new \DateTimeImmutable($data['date_mesure']);
        $measurement->value = $data['niveau_nappe_eau'];
        $measurement->data = $data;

        return $measurement;
    }
}
