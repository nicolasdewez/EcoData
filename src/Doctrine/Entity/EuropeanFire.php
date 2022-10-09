<?php

declare(strict_types=1);

namespace App\Doctrine\Entity;

use App\Doctrine\Repository\EuropeanFireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EuropeanFireRepository::class)]
#[ORM\Table(name: 'european_fires')]
#[ORM\Index(fields: ['country'], name: 'european_fires_idx_country')]
#[ORM\Index(fields: ['year'], name: 'european_fires_idx_year')]
class EuropeanFire
{
    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true])]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 3)]
    private ?string $country = null;

    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true])]
    private ?int $year = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 15, scale: 2, options: ['unsigned' => true])]
    private ?float $area = null;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    private ?int $burntArea = null;

    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true])]
    private ?int $nb = null;

    #[ORM\Column(type: Types::JSON)]
    private array $data = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): void
    {
        $this->year = $year;
    }

    public function getArea(): ?float
    {
        return $this->area;
    }

    public function setArea(?float $area): void
    {
        $this->area = $area;
    }

    public function getBurntArea(): ?int
    {
        return $this->burntArea;
    }

    public function setBurntArea(?int $burntArea): void
    {
        $this->burntArea = $burntArea;
    }

    public function getNb(): ?int
    {
        return $this->nb;
    }

    public function setNb(?int $nb): void
    {
        $this->nb = $nb;
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
