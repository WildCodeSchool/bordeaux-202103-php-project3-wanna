<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use App\Form\UserSkillType;
use App\Repository\ProjectRepository;
use App\Repository\SkillSetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Controller
 * @Route("/dashboard", name="dashboard_")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(
        EntityManagerInterface $entityManager,
        SkillSetRepository $skillSetRepository,
        Request $request
    ): Response {

        $user = $this->getUser();

        $userSkillForm = $this->createForm(UserSkillType::class, $user);
        $userSkillForm->handleRequest($request);

        if ($userSkillForm->isSubmitted() && $userSkillForm->isValid()) {
            $picked = $skillSetRepository->find(6);
            foreach ($user->getSkills() as $skill) {
                $skill->setSkillSet($picked);
            }

            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('dashboard/index.html.twig', [
            'userskillform' => $userSkillForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(ProfilType::class, $user, ['is_organization' => $user->getOrganization()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('dashboard_index', ['_fragment' => 'profile']);
        }

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param User $user
     * @return Response
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(User $user): Response
    {
        $user->setIsActive(false);
        $projectManager = $this->getDoctrine()->getManager();
        $projectManager->flush();
        return $this->redirectToRoute('app_logout');
    }
}
