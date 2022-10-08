<?php

declare(strict_types=1);

namespace App\Doctrine\Repository;

use App\Doctrine\Entity\PiezometryStation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PiezometryStation>
 *
 * @method PiezometryStation|null find($id, $lockMode = null, $lockVersion = null)
 * @method PiezometryStation|null findOneBy(array $criteria, array $orderBy = null)
 * @method PiezometryStation[]    findAll()
 * @method PiezometryStation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class PiezometryStationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PiezometryStation::class);
    }

    /**
     * @return array<int, array<string, string>>
     */
    public function getAllBasics(): array
    {
        return $this->createQueryBuilder('ps')
            ->select('ps.externalCode')
            ->getQuery()
            ->execute([], AbstractQuery::HYDRATE_SCALAR)
        ;
    }
}
