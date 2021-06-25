<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilType;
use App\Form\UserKnownSkillType;
use App\Form\UserNewSkillType;
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
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function index(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {

        $user = $this->getUser();
        $userKnownSkillForm = $this->createForm(UserKnownSkillType::class, $user);
        $userKnownSkillForm->handleRequest($request);

        if ($userKnownSkillForm->isSubmitted()
            && $userKnownSkillForm->isValid()
            ) {
            $entityManager->flush();
            $this->addFlash('success', 'Your skills have well been updated.');
            return $this->redirectToRoute('dashboard_index', ['_fragment' => 'skills']);
        }

        return $this->render('dashboard/index.html.twig', [
            'user_known_skill_form' => $userKnownSkillForm->createView(),
        ]);
    }


    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param SkillSetRepository $skillSetRepository
     * @return Response
     * @Route ("/newskills", name="new_skills", methods={"GET", "POST"})
     */
    public function newSkills(Request $request,
                              EntityManagerInterface $entityManager,
                              SkillSetRepository $skillSetRepository): Response
    {
        $user = $this->getUser();
        $userNewSkillForm = $this->createForm(UserNewSkillType::class, $user);
        $userNewSkillForm->handleRequest($request);

        if ($userNewSkillForm->isSubmitted() && $userNewSkillForm->isValid()) {
            $picked = $skillSetRepository->find(6);
            foreach ($user->getSkills() as $skill) {
                $skill->setSkillSet($picked);
            }

            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('dashboard/new_skills.html.twig', [
            'user_new_skill_form' => $userNewSkillForm->createView(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="edit")
     * @param Request $request
     * @param User $user
     * @return Response
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
     * @param Request $request
     * @param User $user
     * @return Response
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        $user->setIsActive(false);
        $projectManager = $this->getDoctrine()->getManager();
        $projectManager->flush();
        return $this->redirectToRoute('app_logout');
    }
}
