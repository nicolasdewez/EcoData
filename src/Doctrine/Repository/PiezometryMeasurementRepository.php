<?php

declare(strict_types=1);

namespace App\Doctrine\Repository;

use App\Doctrine\Entity\PiezometryMeasurement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PiezometryMeasurement>
 *
 * @method PiezometryMeasurement|null find($id, $lockMode = null, $lockVersion = null)
 * @method PiezometryMeasurement|null findOneBy(array $criteria, array $orderBy = null)
 * @method PiezometryMeasurement[]    findAll()
 * @method PiezometryMeasurement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class PiezometryMeasurementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PiezometryMeasurement::class);
    }
}
