<?php

namespace App\Repository;

use App\Entity\SubstanceProperties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SubstanceProperties|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubstanceProperties|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubstanceProperties[]    findAll()
 * @method SubstanceProperties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubstancePropertiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SubstanceProperties::class);
    }

    // /**
    //  * @return SubstanceProperties[] Returns an array of SubstanceProperties objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubstanceProperties
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
