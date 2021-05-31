<?php

namespace App\Repository;

use App\Entity\Skillset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Skillset|null find($id, $lockMode = null, $lockVersion = null)
 * @method Skillset|null findOneBy(array $criteria, array $orderBy = null)
 * @method Skillset[]    findAll()
 * @method Skillset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillsetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Skillset::class);
    }

    // /**
    //  * @return Skillset[] Returns an array of Skillset objects
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
    public function findOneBySomeField($value): ?Skillset
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
