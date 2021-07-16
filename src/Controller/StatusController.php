<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\Project;
use App\Entity\Task;
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

        $notificationContent =
            'The project : \'' .
            $project->getTitle() .
            '\' has been closed'
        ;
        foreach ($project->getVolunteers() as $volunteer) {
            $notification = new Notification(
                $notificationContent,
                $volunteer->getUser(),
                'project_show',
                'details',
                $project
            );
            $entityManager->persist($notification);
        }

        $entityManager->flush();

        $this->addFlash(
            'success',
            'You closed your project : ' . $project->getTitle()
        );

        return $this->redirectToRoute('project_show', [
            'id' => $project->getId(),
        ]);
    }

    /**
     * @param Task $task
     * @param EntityManager $entityManager
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @Route("/startTask/{id}", name="startTask", methods={"POST"})
     */
    public function startTask(Task $task, EntityManagerInterface $entityManager): Response
    {
        $task->setStatus(Task::STATUS_TASK_TO_START);
        $entityManager->persist($task);
        $entityManager->flush();

        return $this->redirectToRoute('project_show', [
            'id' => $task->getProject()->getId(),
            '_fragment' => 'tasks',
        ]);
    }

    /**
     * @param Task $task
     * @param EntityManager $entityManager
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @Route("/inProgressTask/{id}", name="inProgressTask", methods={"POST"})
     */
    public function inProgressTask(Task $task, EntityManagerInterface $entityManager): Response
    {
        $task->setStatus(Task::STATUS_TASK_IN_PROGRESS);
        $entityManager->persist($task);
        $entityManager->flush();

        return $this->redirectToRoute('project_show', [
            'id' => $task->getProject()->getId(),
            '_fragment' => 'tasks',
        ]);
    }

    /**
     * @param Task $task
     * @param EntityManager $entityManager
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @Route("/achievedTask/{id}", name="achievedTask", methods={"POST"})
     */
    public function achievedTask(Task $task, EntityManagerInterface $entityManager): Response
    {
        $task->setStatus(Task::STATUS_TASK_ACHIEVED);
        $entityManager->persist($task);
        $entityManager->flush();

        return $this->redirectToRoute('project_show', [
            'id' => $task->getProject()->getId(),
            '_fragment' => 'tasks',
        ]);
    }
}
