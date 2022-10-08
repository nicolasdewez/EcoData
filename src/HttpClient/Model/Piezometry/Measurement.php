<?php

declare(strict_types=1);

namespace App\HttpClient\Model\Piezometry;

final class Measurement
{
    public ?\DateTimeImmutable $date = null;
    public ?float $value = null;
    /** @var array<string, mixed> */
    public array $data = [];
}
