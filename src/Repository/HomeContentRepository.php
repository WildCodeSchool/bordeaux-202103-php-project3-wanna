<?php

namespace App\Repository;

use App\Entity\HomeContent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HomeContent|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomeContent|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomeContent[]    findAll()
 * @method HomeContent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomeContentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomeContent::class);
    }

    // /**
    //  * @return HomeContent[] Returns an array of HomeContent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HomeContent
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
