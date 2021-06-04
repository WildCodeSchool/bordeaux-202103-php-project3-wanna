<?php

namespace App\Repository;

use App\Entity\Sdg;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sdg|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sdg|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sdg[]    findAll()
 * @method Sdg[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SdgRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sdg::class);
    }

    // /**
    //  * @return Sdg[] Returns an array of Sdg objects
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
    public function findOneBySomeField($value): ?Sdg
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
