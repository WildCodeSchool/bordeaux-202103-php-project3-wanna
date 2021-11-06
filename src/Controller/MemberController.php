<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * @Route("/member", name="member_show")
     */
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->AllUsersWithDetails();
        return $this->render('member/volunteers.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/organization", name="organization_show")
     */
    public function organizations(UserRepository $userRepository): Response
    {
        $organizations = $userRepository->AllOrganizationsWithDetails();
        return $this->render('member/organizations.html.twig', [
            'users' => $organizations,
        ]);
    }

    /**
     * @Route("/profile/{profile}", name="profile_show")
     */
    public function showProfile(User $profile)
    {
        return $this->render('member/profile.html.twig', [
            'user' => $profile,
        ]);
    }
}
