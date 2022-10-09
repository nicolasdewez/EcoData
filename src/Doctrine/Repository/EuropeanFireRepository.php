<?php

declare(strict_types=1);

namespace App\Doctrine\Repository;

use App\Doctrine\Entity\EuropeanFire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EuropeanFire>
 *
 * @method EuropeanFire|null find($id, $lockMode = null, $lockVersion = null)
 * @method EuropeanFire|null findOneBy(array $criteria, array $orderBy = null)
 * @method EuropeanFire[]    findAll()
 * @method EuropeanFire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class EuropeanFireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EuropeanFire::class);
    }
}
