<?php

declare(strict_types=1);

namespace App\Doctrine\Entity;

use ApiPlatform\Metadata as ApiPlatform;
use App\Doctrine\Repository\DataTypeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation as Serializer;

#[ORM\Entity(repositoryClass: DataTypeRepository::class)]
#[ORM\Table(name: 'data_types')]
#[ORM\Index(fields: ['code'], name: 'data_types_idx_code')]
#[ORM\Index(fields: ['title'], name: 'data_types_idx_title')]
#[ApiPlatform\ApiResource(operations: [
    new ApiPlatform\GetCollection(normalizationContext: ['groups' => ['data_type:read']]),
    new ApiPlatform\Get(normalizationContext: ['groups' => ['data_type:read']]),
])]
class DataType
{
    private const LAST_SYNCHRO_DATE = 'date';

    private const PIEZOMETRY = 'PIEZO';
    private const EUROPEAN_FIRE = 'EU-FIRE';

    #[ORM\Column(type: Types::SMALLINT, options: ['unsigned' => true])]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 30)]
    #[Serializer\Groups(['data_type:read'])]
    private ?string $code = null;

    #[ORM\Column(type: Types::STRING, length: 150)]
    #[Serializer\Groups(['data_type:read'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    #[Serializer\Groups(['data_type:read'])]
    private ?string $comment = null;

    #[ORM\Column(type: Types::JSON)]
    #[Serializer\Groups(['data_type:read'])]
    private array $lastSynchro = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    public function getLastSynchro(): array
    {
        return $this->lastSynchro;
    }

    public function setLastSynchro(array $lastSynchro): void
    {
        $this->lastSynchro = $lastSynchro;
    }

    public function getLastSynchroDate(): ?\DateTimeImmutable
    {
        return isset($this->lastSynchro[self::LAST_SYNCHRO_DATE]) ? new \DateTimeImmutable($this->lastSynchro[self::LAST_SYNCHRO_DATE]) : null;
    }

    public function isPiezometry(): bool
    {
        return self::PIEZOMETRY === $this->code;
    }

    public function isEuropeanFire(): bool
    {
        return self::EUROPEAN_FIRE === $this->code;
    }
}
