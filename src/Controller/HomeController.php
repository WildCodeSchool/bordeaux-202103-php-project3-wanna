<?php

namespace App\Controller;

use App\Repository\FAQRepository;
use App\Repository\HomeContentRepository;
use App\Repository\CarouselSlideRepository;
use App\Service\HomeStatsProvider;
use Doctrine\Common\Collections\Criteria;
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
                          HomeContentRepository $homeContentRepository,
                          FAQRepository $FAQRepository,
                          CarouselSlideRepository $carouselSlideRepository): Response
    {
        $homeContent = $homeContentRepository->findAll();
        $homeContent = $homeContent[0];
        $faqs = $FAQRepository->findAll();
        $stats = $homeStatsProvider->statCompilator();

        $slides = $carouselSlideRepository->findAll();


        return $this->render('home/index.html.twig', [
            'home_content' => $homeContent,
            'faqs' => $faqs,
            'stats' => $stats,
            'slides' => $slides,
        ]);
    }
}
