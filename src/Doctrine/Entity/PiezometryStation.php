<?php

declare(strict_types=1);

namespace App\Doctrine\Entity;

use App\Doctrine\Repository\PiezometryStationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PiezometryStationRepository::class)]
#[ORM\Table(name: 'piezometry_stations')]
#[ORM\Index(fields: ['externalCode'], name: 'piezometry_stations_idx_external_code')]
#[ORM\Index(fields: ['title'], name: 'piezometry_stations_idx_title')]
#[ORM\Index(fields: ['city'], name: 'piezometry_stations_idx_city')]
#[ORM\Index(fields: ['codeDepartment'], name: 'piezometry_stations_idx_code_department')]
#[ORM\Index(fields: ['startDate'], name: 'piezometry_stations_idx_start_date')]
#[ORM\Index(fields: ['endDate'], name: 'piezometry_stations_idx_end_date')]
#[ORM\Index(fields: ['enabled'], name: 'piezometry_stations_idx_enabled')]
class PiezometryStation
{
    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true])]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 50)]
    private ?string $externalCode = null;

    #[ORM\Column(type: Types::STRING, length: 250, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING, length: 250, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(type: Types::STRING, length: 10, nullable: true)]
    private ?string $codeDepartment = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column(type: Types::JSON)]
    private array $data = [];

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $enabled = true;

    #[ORM\OneToMany(mappedBy: 'station', targetEntity: PiezometryMeasurement::class)]
    private Collection $measurements;

    public function __construct()
    {
        $this->measurements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExternalCode(): ?string
    {
        return $this->externalCode;
    }

    public function setExternalCode(?string $externalCode): void
    {
        $this->externalCode = $externalCode;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getCodeDepartment(): ?string
    {
        return $this->codeDepartment;
    }

    public function setCodeDepartment(?string $codeDepartment): void
    {
        $this->codeDepartment = $codeDepartment;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeImmutable $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeImmutable $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function isRecent(): bool
    {
        $diff = (new \DateTimeImmutable('today'))->diff($this->endDate);
        $nbMonths = $diff->y * 12 + $diff->m;

        return 6 > $nbMonths;
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

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getMeasurements(): Collection
    {
        return $this->measurements;
    }

    public function setMeasurements(Collection $measurements): void
    {
        $this->measurements = $measurements;
    }
}
