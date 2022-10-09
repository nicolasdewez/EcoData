<?php

declare(strict_types=1);

namespace App\HttpClient\Model\EuropeanFire;

final class Statistic
{
    public ?string $country = null;
    public ?int $year = null;
    public ?float $area = null;
    public ?int $burntArea = null;
    public ?int $nb = null;
    /** @var array<string, mixed> */
    public array $data = [];
}
