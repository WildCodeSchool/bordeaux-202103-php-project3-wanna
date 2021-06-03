<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Project;
use App\Entity\User;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project/new", name="project_new")
     */
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $project = new Project();
        $participant = new Participant();
        $participant->setUser($this->getUser());
        $participant->setRole(Participant::ROLE_PROJECT_OWNER);
        $entityManager->persist($participant);
        $project->addParticipant($participant);
        $project->setStatus(Project::STATUS_REQUEST);

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();
            //TODO redirect
            //TODO Test this form with user authentified

        }
        return $this->render('project/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
