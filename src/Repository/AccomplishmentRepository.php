<?php

namespace App\Repository;

use App\Entity\Accomplishment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Accomplishment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accomplishment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accomplishment[]    findAll()
 * @method Accomplishment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccomplishmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accomplishment::class);
    }

    // /**
    //  * @return Accomplishment[] Returns an array of Accomplishment objects
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
    public function findOneBySomeField($value): ?Accomplishment
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
