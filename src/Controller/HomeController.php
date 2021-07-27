<?php

namespace App\Controller;

use App\DataFixtures\CarouselSlideFixtures;
use App\Repository\CarouselSlideRepository;
use App\Repository\FAQRepository;
use App\Repository\HomeContentRepository;
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
    public function index(HomeStatsProvider $homeStatsProvider,
    CarouselSlideRepository $carouselSlideRepository,
    FAQRepository $FAQRepository,
    HomeContentRepository $homeContentRepository): Response
    {
        $stats = $homeStatsProvider->statCompilator();
        $faqs = $FAQRepository->findAll();
        $slides = $carouselSlideRepository->findAll();
        $homeContent = $homeContentRepository->findAll();
        $homeContent = $homeContent[0];



        return $this->render('home/index.html.twig', [
            'stats' => $stats,
            'home_content' => $homeContent,
            'slides' => $slides,
            'faqs' => $faqs
        ]);
    }
}
