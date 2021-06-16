<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OrganizationRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
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
    public function index(UserRepository $userRepository, OrganizationRepository $organizationRepository, ProjectRepository $projectRepository): Response
    {
       $homeStatProvider =  new HomeStatsProvider($userRepository, $organizationRepository, $projectRepository);
       $stats = $homeStatProvider->statProvider();

        return $this->render('home/index.html.twig',[
            'stats' => $stats,
        ] );
    }
}
