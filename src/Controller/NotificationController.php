<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Repository\NotificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    public function index(NotificationRepository $notificationRepository): Response
    {
        $unreadNotificationsCount = count($notificationRepository->findAllNotReadByUser($this->getUser()));
        $notifications = $notificationRepository->findBy(['receiver' => $this->getUser()], ['id' => 'DESC']);
        return $this->render('notification/_index.html.twig', [
            'notifications'            => $notifications,
            'unreadNotificationsCount' => $unreadNotificationsCount,
        ]);
    }

    /**
     * @Route("/notification/{id}/read", name="notification_read", methods={"POST"})
     */
    public function readNotification(Notification $notification, EntityManagerInterface $entityManager): Response
    {
        $notification->setIsRead(true);
        $entityManager->flush();
        if ($notification->getProject() === null) {
            return $this->redirectToRoute(
                $notification->getTargetPath(),
                [
                    '_fragment' => $notification->getTargetPathFragment()
                ]
            );
        }

        return $this->redirectToRoute(
            $notification->getTargetPath(),
            [
                'id'        => $notification->getProject()->getId(),
                '_fragment' => $notification->getTargetPathFragment()
            ]
        );
    }
}
