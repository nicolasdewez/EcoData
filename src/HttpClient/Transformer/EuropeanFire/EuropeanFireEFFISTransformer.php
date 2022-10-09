<?php

declare(strict_types=1);

namespace App\HttpClient\Transformer\EuropeanFire;

use App\HttpClient\Model\EuropeanFire\Statistic;

final class EuropeanFireEFFISTransformer
{
    /**
     * @param array<string, mixed> $data
     */
    public function transform(int $year, array $data): Statistic
    {
        $statistic = new Statistic();
        $statistic->country = $data['iso3'];
        $statistic->year = $year;
        $statistic->nb = $data['nf'] ?? 0;
        $statistic->burntArea = $data['ba'] ?? 0;
        $statistic->area = round($data['area_ha'], 2);
        $statistic->data = $data;

        return $statistic;
    }
}
