<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Notification|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notification|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notification[]    findAll()
 * @method Notification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    /**
     * @return Notification[] Returns an array of Notification objects
     */
    public function findAllNotReadByUser(User $user)
    {
        $queryBuilder = $this
            ->createQueryBuilder('n')
            ->join('n.receiver', 'r')
            ->andWhere('n.isRead = FALSE')
            ->andWhere('r.id = :user')
            ->setParameter(':user', $user)
        ;
        return $queryBuilder->getQuery()->getResult();
    }
}
