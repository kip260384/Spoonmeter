<?php

namespace App\Repository;

use App\Entity\MeasureNature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MeasureNature|null find($id, $lockMode = null, $lockVersion = null)
 * @method MeasureNature|null findOneBy(array $criteria, array $orderBy = null)
 * @method MeasureNature[]    findAll()
 * @method MeasureNature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeasureNatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MeasureNature::class);
    }

    // /**
    //  * @return MeasureNature[] Returns an array of MeasureNature objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MeasureNature
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
