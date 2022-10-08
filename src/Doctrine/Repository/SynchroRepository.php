<?php

declare(strict_types=1);

namespace App\Doctrine\Repository;

use App\Doctrine\Entity\Synchro;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Synchro>
 *
 * @method Synchro|null find($id, $lockMode = null, $lockVersion = null)
 * @method Synchro|null findOneBy(array $criteria, array $orderBy = null)
 * @method Synchro[]    findAll()
 * @method Synchro[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
final class SynchroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Synchro::class);
    }

    public function incrementNbStepsProcessed(Synchro $synchro): void
    {
        $this->_em->getConnection()->executeStatement('UPDATE synchros SET nb_steps_processed = nb_steps_processed + 1 WHERE id = :id ', ['id' => $synchro->getId()]);
    }
}
