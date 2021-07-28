<?php

namespace App\Controller;

use App\Repository\CarouselSlideRepository;
use App\Repository\FAQRepository;
use App\Repository\HomeContentRepository;
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
    public function index(
        HomeStatsProvider $homeStatsProvider,
        CarouselSlideRepository $carouselSlideRepository,
        FAQRepository $FAQRepository,
        HomeContentRepository $homeContentRepository
    ): Response {

        $homeContent = $homeContentRepository->findAll();
        $homeContent = $homeContent[0];
        $faqs = $FAQRepository->findAll();
        $stats = $homeStatsProvider->statCompilator();
        $faqs = $FAQRepository->findAll();
        $slides = $carouselSlideRepository->findAll();
        $homeContent = $homeContentRepository->findAll();
        $homeContent = $homeContent[0];



        $slides = $carouselSlideRepository->findAll();


        return $this->render('home/index.html.twig', [
            'home_content' => $homeContent,
            'faqs' => $faqs,
            'stats' => $stats,
            'home_content' => $homeContent,
            'slides' => $slides,
            'faqs' => $faqs
        ]);
    }
}
