<?php

namespace App\Controller;

use App\Entity\Avatar;
use App\Entity\Project;
use App\Entity\User;
use App\Form\AvatarType;
use App\Form\ProfilType;
use App\Form\UserKnownSkillType;
use App\Form\UserNewSkillType;
use App\Repository\SkillSetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AvatarDealer;

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
        Request $request): Response
    {
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
     * @Route("/editavatar/{id}", name="edit_avatar")
     * @param Request $request
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function editavatar(Request $request, User $user): Response
    {
        $form = $this->createForm(AvatarType::class, $this->getUser()->getAvatar());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('dashboard_edit_avatar', ['id' => $user->getId()]);
        }

        return $this->render('profile/edit_avatar.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/saveavatar/{id}", name="save_avatar")
     * @param Request $request
     * @param User $user
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function saveavatar(Request $request, User $user, AvatarDealer $avatarDealer): Response
    {
        $imgData = $request->get('avatar');
        $imgName = $avatarDealer->saveUserNewAvatar($this->getUser(), $imgData);
        dump('coucou');
        $user->getAvatar()->setName($imgName);
        $this->getDoctrine()->getManager()->flush();

        //return $this->redirectToRoute('dashboard_index');
        return $this->json(json_encode($user->getId()), Response::HTTP_OK);
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
