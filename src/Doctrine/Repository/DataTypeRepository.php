<?php

declare(strict_types=1);

namespace App\Doctrine\Repository;

use App\Doctrine\Entity\DataType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DataType>
 *
 * @method DataType|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataType|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataType[]    findAll()
 * @method DataType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class DataTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataType::class);
    }
}
