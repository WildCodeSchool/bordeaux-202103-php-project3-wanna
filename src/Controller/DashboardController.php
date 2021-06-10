<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(): Response
    {
        
        $participations = $this->getUser()->getParticipants();

        return $this->render('dashboard/index.html.twig', [
            'participations' => $participations,
        ]);
    }
}
