<?php

namespace App\Controller;

use App\Repository\NotificationRepository;
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
}
