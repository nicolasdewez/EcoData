<?php

declare(strict_types=1);

namespace App\Manager;

use App\Doctrine\Entity\DataType;
use Doctrine\ORM\EntityManagerInterface;

final class DataTypeManager
{
    public function __construct(private readonly EntityManagerInterface $manager)
    {
    }

    public function updateAfterSynchro(DataType $dataType): void
    {
        $dataType->setLastSynchro(['date' => (new \DateTimeImmutable('today'))->format('Y-m-d')]);

        $this->manager->persist($dataType);
        $this->manager->flush();
    }
}
