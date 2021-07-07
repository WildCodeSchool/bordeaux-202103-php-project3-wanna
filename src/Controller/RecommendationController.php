<?php

namespace App\Controller;

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

class RecommendationController extends AbstractController
{
    /**
     * @Route("/recommendation", name="recommendation")
     */
    public function index(): Response
    {
        return $this->render('recommendation/index.html.twig', [
            'controller_name' => 'RecommendationController',
        ]);
    }

    public function new(Request $request,
                        int $volunteerId,
                        int $projectId,
                        UserRepository $userRepository,
                        ProjectRepository $projectRepository,
                        EntityManagerInterface $entityManager): Response
    {
        $volunteer = $userRepository->findOneBy(['id' => $volunteerId]);
        $recommendation = new Recommendation();
        $form = $this->createForm(RecommendationType::class, $recommendation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $recommendation->setSender($this->getUser());
            $recommendation->setReceiver($volunteer);
            $recommendation->setCreatedAt(new \DateTime('now'));
            $recommendation->setUpdatedAt($recommendation->getCreatedAt());
            $entityManager->persist($recommendation);
            $entityManager->flush();
            return $this->redirectToRoute('project_close', [
                'id' => $projectId,
            ]);
        }
        return $this->render('component/recommendation/_new_form.html.twig', [
            'volunteer' => $volunteer,
            'form'      => $form->createView(),
        ]);
    }
}
