<?php

declare(strict_types=1);

namespace App\Doctrine\Entity;

use App\Doctrine\Repository\PiezometryMeasurementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PiezometryMeasurementRepository::class)]
#[ORM\Table(name: 'piezometry_measurements')]
#[ORM\Index(fields: ['date'], name: 'piezometry_measurements_idx_date')]
class PiezometryMeasurement
{
    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: PiezometryStation::class, inversedBy: 'measurements')]
    private ?PiezometryStation $station = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?float $value = null;

    #[ORM\Column(type: Types::JSON, nullable: false)]
    private array $data = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStation(): ?PiezometryStation
    {
        return $this->station;
    }

    public function setStation(?PiezometryStation $station): void
    {
        $this->station = $station;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(?\DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(?float $value): void
    {
        $this->value = $value;
    }

    /**
     * @return array<string,mixed>
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array<string,mixed> $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }
}
