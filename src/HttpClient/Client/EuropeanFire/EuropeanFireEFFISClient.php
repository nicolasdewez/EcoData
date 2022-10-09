<?php

declare(strict_types=1);

namespace App\HttpClient\Client\EuropeanFire;

use App\HttpClient\Model\EuropeanFire\Statistic;
use App\HttpClient\Transformer\EuropeanFire\EuropeanFireEFFISTransformer;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class EuropeanFireEFFISClient implements EuropeanFireClientInterface
{
    public function __construct(
        private readonly HttpClientInterface $europeanFireEFFIS,
        private readonly EuropeanFireEFFISTransformer $transformer
    ) {
    }

    /**
     * @return array<string, Statistic>
     */
    public function getStatistics(?\DateTimeImmutable $lastSynchro): array
    {
        $statistics = [];

        $yearLastSynchro = null !== $lastSynchro ? (int) $lastSynchro->format('Y') : 2005;
        $currentYear = (int) (new \DateTime('today'))->format('Y');

        for ($year = $yearLastSynchro; $year <= $currentYear; ++$year) {
            $response = $this->europeanFireEFFIS->request('GET', '/statistics/effis/estimatesoverview', [
                'query' => [
                    'year' => $year,
                    'firesize' => 10,
                    'countries' => 'AUT,BEL,BGR,HRV,CYP,CZE,DNK,EST,FIN,FRA,DEU,GRC,HUN,IRL,ITA,LVA,LTU,LUX,MLT,NLD,POL,PRT,ROU,SVK,SVN,ESP,SWE,ALB,BIH,GEO,MNE,MKD,NOR,SRB,CHE,TUR,UKR,GBR',
                ],
            ]);

            $json = $response->toArray();
            foreach ($json as $statistic) {
                $statistics[] = $this->transformer->transform($year, $statistic);
            }
        }

        return $statistics;
    }
}
