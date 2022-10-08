<?php

declare(strict_types=1);

namespace App\HttpClient\Client\Piezometry;

use App\HttpClient\Model\Piezometry\Measurement;
use App\HttpClient\Model\Piezometry\Station;
use App\HttpClient\Transformer\Piezometry\PiezometryFrHubeauTransformer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class PiezometryFrHubeauClient implements PiezometryClientInterface
{
    public function __construct(
        private readonly HttpClientInterface $piezometryFrHubeau,
        private readonly PiezometryFrHubeauTransformer $transformer
    ) {
    }

    /**
     * @param array<string, int> $stations
     *
     * @return array<string, Station>
     */
    public function getStations(array $stations, ?\DateTimeImmutable $lastSynchro): array
    {
        $newStations = [];

        // 1990 + 2 years
        $yearLastSynchro = null !== $lastSynchro ? (int) $lastSynchro->format('Y') + 1 : 1992;
        $currentYear = (int) (new \DateTime('today'))->format('Y');

        for ($year = $yearLastSynchro; $year <= $currentYear; ++$year) {
            $url = '/api/v1/niveaux_nappes/stations';
            $parameters = [
                'query' => [
                    'date_recherche' => "{$year}-01-01",
                    'page' => 1,
                    'size' => 5000,
                ],
            ];

            do {
                $response = $this->piezometryFrHubeau->request('GET', $url, $parameters);
                $json = $response->toArray();

                foreach ($json['data'] as $newStation) {
                    if (isset($stations[$newStation['code_bss']]) || isset($newStations[$newStation['code_bss']])) {
                        continue;
                    }

                    $newStations[$newStation['code_bss']] = $this->transformer->transformStation($newStation);
                }

                $url = $json['next'];
                $parameters = [];
            } while (null !== $url);
        }

        return $newStations;
    }

    /**
     * @return array<Measurement>
     */
    public function getMeasurements(string $externalCode, ?\DateTimeImmutable $lastSynchro): array
    {
        $newMeasurements = [];

        $startMeasurements = null !== $lastSynchro ? new \DateTime("{$lastSynchro->format('Y-m-d')} + 1day") : '1990-01-01';

        $url = '/api/v1/niveaux_nappes/chroniques';
        $parameters = [
            'query' => [
                'code_bss' => $externalCode,
                'date_debut_mesure' => $startMeasurements,
                'sort' => 'asc',
                'page' => 1,
                'size' => 150, // TODO: Change for 5000
            ],
        ];

        do {
            $response = $this->piezometryFrHubeau->request('GET', $url, $parameters);
            $json = $response->toArray();

            foreach ($json['data'] as $newMeasurement) {
                $newMeasurements[] = $this->transformer->transformMeasurement($newMeasurement);
            }

            // TODO: Change it
            $url = null; // $json['next'];
            $parameters = [];
        } while (null !== $url);

        return $newMeasurements;
    }
}
