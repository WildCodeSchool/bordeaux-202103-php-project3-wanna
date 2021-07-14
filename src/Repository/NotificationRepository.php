<?php

namespace App\Repository;

use App\Entity\Notification;
use App\Entity\Project;
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
    const MAX_DISPLAYED_NOTIFICATIONS = 15;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notification::class);
    }

    /**
     * @return Notification[] Returns an array of Notification objects
     */
    public function findLastNotificationsByUser(User $user)
    {
        $lastNotifications = $this->findBy(
          ['receiver' => $user],
          ['id' => 'DESC'],
          self::MAX_DISPLAYED_NOTIFICATIONS
        );
        return $lastNotifications;
    }

    /**
     * @return int
     */
    public function findCountNotReadDisplayedByUser(User $user)
    {
        $countNotReadDisplayedNotifications = 0;
        $lastNotifications = $this->findLastNotificationsByUser($user);
        if ($lastNotifications !== null) {
            foreach ($lastNotifications as $notification) {
                if (!$notification->getIsRead()) {
                    $countNotReadDisplayedNotifications++;
                }
            }
        }
        return $countNotReadDisplayedNotifications;
    }

    /**
     * @return Notification|null
     */
    public function findLastTchatNotificationByUserAndProject(User $user, Project $project)
    {
        $lastTchatNotification = $this->findOneBy(
            ['receiver' => $user, 'targetPathFragment' => 'tchat', 'project' => $project],
            ['id' => 'DESC']
        );
        return $lastTchatNotification;
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
