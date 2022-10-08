<?php

declare(strict_types=1);

namespace App\Doctrine\Entity;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata as ApiPlatform;
use App\Doctrine\Listener\SynchroListener;
use App\Doctrine\Repository\SynchroRepository;
use App\Workflow\Definition\SynchroDefinition;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation as Serializer;

#[ORM\Entity(repositoryClass: SynchroRepository::class)]
#[ORM\EntityListeners([SynchroListener::class])]
#[ORM\Table(name: 'synchros')]
#[ORM\Index(fields: ['state'], name: 'synchros_idx_state')]
#[ApiPlatform\ApiResource(operations: [
    new ApiPlatform\Post(normalizationContext: ['groups' => ['synchro:read']], denormalizationContext: ['groups' => ['synchro:write']], processor: PersistProcessor::class),
    new ApiPlatform\Get(normalizationContext: ['groups' => ['synchro:read']]),
])]
class Synchro
{
    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    #[ORM\Id, ORM\GeneratedValue(strategy: 'AUTO')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: DataType::class)]
    #[Serializer\Groups(['synchro:read', 'synchro:write'])]
    private ?DataType $dataType = null;

    #[ORM\Column(type: Types::STRING)]
    #[Serializer\Groups(['synchro:read'])]
    private string $state = SynchroDefinition::DRAFT;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Serializer\Groups(['synchro:read'])]
    private int $nbSteps = 0;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Serializer\Groups(['synchro:read'])]
    private int $nbStepsProcessed = 0;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Gedmo\Timestampable(on: 'create')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    #[Gedmo\Blameable(on: 'create')]
    private ?User $createdBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataType(): ?DataType
    {
        return $this->dataType;
    }

    public function setDataType(?DataType $dataType): void
    {
        $this->dataType = $dataType;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): void
    {
        $this->state = $state;
    }

    public function getNbSteps(): int
    {
        return $this->nbSteps;
    }

    public function setNbSteps(int $nbSteps): void
    {
        $this->nbSteps = $nbSteps;
    }

    public function getNbStepsProcessed(): int
    {
        return $this->nbStepsProcessed;
    }

    public function setNbStepsProcessed(int $nbStepsProcessed): void
    {
        $this->nbStepsProcessed = $nbStepsProcessed;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function isStarted(): bool
    {
        return SynchroDefinition::DRAFT !== $this->state;
    }

    public function isProcessed(): bool
    {
        return $this->isStarted() && $this->nbSteps === $this->nbStepsProcessed;
    }

    public function isPiezometry(): bool
    {
        if (null === $this->dataType) {
            return false;
        }

        return $this->dataType->isPiezometry();
    }
}
