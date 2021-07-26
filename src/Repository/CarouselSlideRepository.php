<?php

namespace App\Repository;

use App\Entity\CarouselSlide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CarouselSlide|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarouselSlide|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarouselSlide[]    findAll()
 * @method CarouselSlide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarouselSlideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarouselSlide::class);
    }

    // /**
    //  * @return CarouselSlide[] Returns an array of CarouselSlide objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CarouselSlide
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
