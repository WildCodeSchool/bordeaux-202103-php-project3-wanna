<?php

namespace App\Controller;

use App\Service\HomeStatsProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     * @param HomeStatsProvider $homeStatsProvider
     * @return Response
     */
    public function index(HomeStatsProvider $homeStatsProvider): Response
    {
        $stats = $homeStatsProvider->statCompilator();

        return $this->render('home/index.html.twig', [
            'stats' => $stats,
        ]);
    }
}
