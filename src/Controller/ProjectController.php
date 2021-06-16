<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Entity\Project;
use App\Entity\Task;
use App\Entity\User;
use App\Form\ProjectType;
use App\Form\TaskType;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/project", name="project_")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/new", name="new")
     */
    public function new(EntityManagerInterface $entityManager, Request $request): Response
    {
        $project = new Project();
        $participant = new Participant();
        $participant->setUser($this->getUser());
        $participant->setRole(Participant::ROLE_PROJECT_OWNER);
        $entityManager->persist($participant);
        $project->addParticipant($participant);
        $project->setStatus(Project::STATUS_REQUEST_SEND);

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();
            return $this->redirectToRoute('project_index');
        }
        return $this->render('component/project/task/task_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="index")
     */
    public function index(ProjectRepository $projectRepository): Response
    {
        $projects = $projectRepository->findAll();
        return $this->render('project/index.html.twig', [
            'projects' => $projects,
        ]);
    }

    /**
     * @Route("/participant/{project}", name="participant_project")
     */
    public function participeToProject(Project $project, EntityManagerInterface $entityManager): Response
    {
        $participant = new Participant();
        $participant->setRole(Participant::ROLE_WAITING_VOLUNTEER);
        $participant->setProject($project);
        $participant->setUser($this->getUser());
        $entityManager->persist($participant);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Demand sent to the project : ' . $project->getTitle()
        );

        return $this->redirectToRoute('project_index');
    }


    /**
     * @Route("/participant/{project}/{user}/accepted", name="participant_project_accepted", methods={"POST"})
     */
    public function acceptParticipation(Project $project, User $user, EntityManagerInterface $entityManager)
    {
        $participation = $user->getParticipationOn($project);
        $participation->setRole(Participant::ROLE_VOLUNTEER);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'You have accepted ' . $user->getFirstname()
                    . ' ' . $user->getLastname()
                    . ' as a volunteer on the project : ' . $project->getTitle()
        );

        return $this->redirectToRoute('project_index');
    }

    /**
     * @Route("/participant/{project}/{user}/removed", name="participant_project_removed", methods={"POST"})
     */
    public function removeParticipation(Project $project, User $user, EntityManagerInterface $entityManager)
    {
        $participation = $user->getParticipationOn($project);
        $entityManager->remove($participation);
        $entityManager->flush();

        $this->addFlash(
            'warning',
            'You have rejected ' . $user->getFirstname()
            . ' ' . $user->getLastname()
            . ' as a volunteer on the project : ' . $project->getTitle()
        );

        return $this->redirectToRoute('project_index');
    }

    /**
     * @Route("/show/{id}", name="show", methods={"GET"})
     */
    public function show(Project $project, Task $task, TaskRepository $taskRepository): Response
    {

        $tasks = $taskRepository->findBy(
            array('project' => $project),
            array('status' => 'ASC')
        );

        return $this->render('project/show.html.twig', [
            'project' => $project,
            'task'    => $task,
            'tasks'   => $tasks,
        ]);
    }

    /**
     * @Route("/show/table/{id}", name="show_table", methods={"GET"})
     */
    public function showTable(Project $project, Task $task, TaskRepository $taskRepository): Response
    {

        $tasks = $taskRepository->findBy(
            array('project' => $project),
            array('status' => 'ASC')
        );

        return $this->render('project/show2.html.twig', [
            'project' => $project,
            'task'    => $task,
            'tasks'   => $tasks,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     */
    public function edit(Request $request, Project $project): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('project_index');
        }

        return $this->render('component/project/task/task_edit.html.twig', [
           'project' => $project,
            'form'   => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Project $project): Response
    {
        if ($this->isCsrfTokenValid('delete' . $project->getId(), $request->request->get('_token'))) {
            $projectManager = $this->getDoctrine()->getManager();
            $projectManager->remove($project);
            $projectManager->flush();
        }

        return $this->redirectToRoute('project_index');
    }


    /**
     * @Route("/{id}/task/new", name="task_new", methods={"GET","POST"})
     */
    public function newTask(Request $request, Project $project): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task->setProject($project));
            $task->setStatus(Task::STATUS_TASK_PENDING_ATTRIBUTION);
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('project_show', [
            'id' => $project->getId(),
            ]);
        }

        return $this->render('component/project/task/task_new.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
            'project' => $project,
        ]);
    }

    /**
     * @Route("/task/{idTask}/edit", name="task_edit", methods={"GET","POST"})
     * @ParamConverter("task", class=Task::class, options={"mapping": {"idTask": "id"}})
     */
    public function editTask(Request $request, Task $task): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('project_show', [
                'id' => $task->getProject()->getId(),
                '_fragment' => 'tasks',
            ]);
        }

        return $this->render('component/project/task/task_edit.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/task/{idTask}", name="task_delete", methods={"POST"})
     * @ParamConverter("task", class=Task::class, options={"mapping": {"idTask": "id"}})
     */
    public function deleteTask(Request $request, Task $task): Response
    {
        if ($this->isCsrfTokenValid('delete' . $task->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($task);
            $entityManager->flush();

            return $this->redirectToRoute('project_show', [
                'id' => $task->getProject()->getId(),
                '_fragment' => 'tasks',
            ]);
        }
    }
}
