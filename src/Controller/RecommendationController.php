<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\Project;
use App\Entity\Recommendation;
use App\Entity\User;
use App\Form\RecommendationType;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/recommandation", name="recommendation_")
 */

class RecommendationController extends AbstractController
{
    /**
     * @Route("/new/{project}/volunteer/{volunteer}", name="new_to_volunteer")
     * @ParamConverter("user", options={"mapping": {"volunteer": "id"}})
     */
    public function newToVolunteer(
        Project $project,
        User $volunteer,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {
        $recommendation = new Recommendation();
        $form = $this->createForm(RecommendationType::class, $recommendation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recommendation->setSender($this->getUser());
            $recommendation->setReceiver($volunteer);
            $recommendation->setCreatedAt(new \DateTime('now'));
            $recommendation->setUpdatedAt($recommendation->getCreatedAt());
            $recommendation->setProject($project);
            $entityManager->persist($recommendation);

            $notificationContent =
                $this->getUser()->getFullNameIfMemberOrONG() .
                ' recommended you, following your participation on the project \'' .
                $project->getTitle() .
                '\''
            ;
            $notification = new Notification(
                $notificationContent,
                $recommendation->getReceiver(),
                'dashboard_index',
                'recommendations'
            );
            $entityManager->persist($notification);

            $entityManager->flush();

            $this->addFlash(
                'success',
                'You have wrote a recommendation for ' . $volunteer->getFirstname() . ' ' . $volunteer->getLastname()
            );

            return $this->redirectToRoute('project_close', [
                'id' => $project->getId(),
            ]);
        }

        return $this->render('recommendation/new_to_volunteer.html.twig', [
            'volunteer' => $volunteer,
            'project'   => $project,
            'form'      => $form->createView(),
        ]);
    }

    /**
     * @Route("/new/{project}/project-owner/{projectOwner}", name="new_to_PO")
     * @ParamConverter("user", options={"mapping": {"projectOwner": "id"}})
     */
    public function newToProjectOwner (
        Project $project,
        User $projectOwner,
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $recommendation = new Recommendation();
        $form = $this->createForm(RecommendationType::class, $recommendation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $recommendation->setSender($this->getUser());
            $recommendation->setReceiver($projectOwner);
            $recommendation->setCreatedAt(new \DateTime('now'));
            $recommendation->setUpdatedAt($recommendation->getCreatedAt());
            $recommendation->setProject($project);
            $entityManager->persist($recommendation);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'You have wrote a recommendation for ' . $projectOwner->getFirstname() . ' ' . $projectOwner->getLastname()
            );
            return $this->redirectToRoute('dashboard_index');
        }

        return $this->render('recommendation/new_to_PO.html.twig', [
            'projectOwner' => $projectOwner,
            'project' => $project,
            'form' => $form->createView(),
        ]);
    }
}
