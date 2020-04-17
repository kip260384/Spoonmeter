<?php

namespace App\Repository;

use App\Entity\AggregationState;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AggregationState|null find($id, $lockMode = null, $lockVersion = null)
 * @method AggregationState|null findOneBy(array $criteria, array $orderBy = null)
 * @method AggregationState[]    findAll()
 * @method AggregationState[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AggregationStateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AggregationState::class);
    }

    // /**
    //  * @return AggregationState[] Returns an array of AggregationState objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AggregationState
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
