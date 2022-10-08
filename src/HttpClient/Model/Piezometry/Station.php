<?php

declare(strict_types=1);

namespace App\HttpClient\Model\Piezometry;

final class Station
{
    public ?string $externalCode = null;
    public ?string $title = null;
    public ?string $city = null;
    public ?string $codeDepartment = null;
    public ?\DateTimeImmutable $startDate = null;
    public ?\DateTimeImmutable $endDate = null;
    /** @var array<string, mixed> */
    public array $data = [];
}
