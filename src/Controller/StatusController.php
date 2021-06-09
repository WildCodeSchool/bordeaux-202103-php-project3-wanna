<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

    /**
     * @Route("/status", name="status_")
     */
class StatusController extends AbstractController
{
    /**
     * @param Project $project
     * @param EntityManager $entityManager
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @Route("/closed/{id}", name="closed", methods={"POST"})
     */
    public function closed(Project $project, EntityManagerInterface $entityManager): Response
    {
        $project->setStatus(Project::STATUS_CLOSED);
        $entityManager->persist($project);
        $entityManager->flush();
        return $this->redirectToRoute('project_index');
    }
}
