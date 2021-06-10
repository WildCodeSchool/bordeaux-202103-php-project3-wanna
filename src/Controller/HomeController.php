<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\OrganizationRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use App\Service\homeStatsProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(UserRepository $userRepository,
                          OrganizationRepository $organizationRepository,
                          ProjectRepository $projectRepository
    ): Response
    {
       $homeStatProvider =  new homeStatsProvider($userRepository, $organizationRepository, $projectRepository);
       $stats = $homeStatProvider->StatProvider();

        return $this->render('home/index.html.twig',[
            'stats' => $stats,
        ] );
    }
}
