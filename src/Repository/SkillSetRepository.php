<?php

namespace App\Repository;

use App\Entity\SkillSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SkillSet|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillSet|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillSet[]    findAll()
 * @method SkillSet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillSetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillSet::class);
    }

    // /**
    //  * @return SkillSet[] Returns an array of SkillSet objects
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
    public function findOneBySomeField($value): ?SkillSet
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
