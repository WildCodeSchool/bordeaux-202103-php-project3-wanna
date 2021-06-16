<?php

namespace App\Controller;

use App\Entity\Statistic;
use App\Service\HomeStatsProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     * @param UserRepository $userRepository
     * @param OrganizationRepository $organizationRepository
     * @param ProjectRepository $projectRepository
     * @return Response
     */

    public function index(HomeStatsProvider $homeStatsProvider): Response
    {
        $stats = $homeStatsProvider->statCompilator();

        return $this->render('home/index.html.twig',[
            'stats' => $stats,
        ] );
    }
}
