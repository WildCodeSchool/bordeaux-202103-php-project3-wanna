<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Notification;
use App\Entity\Participant;
use App\Entity\Project;
use App\Entity\Sdg;
use App\Entity\Task;
use App\Entity\Tchat;
use App\Entity\TchatMessage;
use App\Entity\User;
use App\Form\AttributionTaskType;
use App\Form\FileType;
use App\Form\ProjectType;
use App\Form\TaskType;
use App\Form\TchatMessageType;
use App\Repository\FileRepository;
use App\Repository\NotificationRepository;
use App\Repository\ProjectRepository;
use App\Repository\SdgRepository;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Service\ProjectUserRoleProvider;
use App\Service\UserProjectSkillMatcher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
    public function new(EntityManagerInterface $entityManager, Request $request, UserRepository $userRepository): Response
    {
        $project = new Project();
        $participant = new Participant();
        $tchat = new Tchat();
        $participant->setUser($this->getUser());
        $participant->setRole(Participant::ROLE_PROJECT_OWNER);
        $entityManager->persist($participant);
        $project->addParticipant($participant);
        $project->setStatus(Project::STATUS_REQUEST_SEND);

        if ($participant->getUser() === null) {
            return $this->redirectToRoute('app_register');
        }

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tchat->setName($project->getTitle());
            $tchat->setProject($project);
            $tchat->addUser($this->getUser());
            $entityManager->persist($tchat);
            $entityManager->persist($project);

            $notificationContent =
                $this->getUser()->getFullNameIfMemberOrONG() .
                ' create a new request : \'' .
                $project->getTitle() .
                '\'. As an admin, you can accept or decline it'
            ;
            $adminUsers = $userRepository->findAllAdmin();
            foreach ($adminUsers as $adminUser) {
                $notification = new Notification(
                    $notificationContent,
                    $adminUser,
                    'project_show',
                    'details',
                    $project
                );
                $entityManager->persist($notification);
            }

            $entityManager->flush();
            return $this->redirectToRoute('project_show', [
                'id' => $project->getId(),
            ]);
        }

        return $this->render('project/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="index")
     */
    public function index(
        ProjectRepository $projectRepository,
        SdgRepository $sdgRepository,
        UserProjectSkillMatcher $userProjectSkillMatcher
    ): Response {
        $user = $this->getUser();

        $projects = $projectRepository->findAll();
        $sdgs = $sdgRepository->findAll();

        if ($user) {
            $projects = $userProjectSkillMatcher->sortProjectsByStatusAndCommonSkills($user, $projects);
        }

        return $this->render('project/index.html.twig', [
            'projects' => $projects,
            'sdgs' => $sdgs,
        ]);
    }

    /**
     * @Route("/{id}/show/", name="show", methods={"GET","POST"})
     */
    public function show(
        Project $project,
        Task $task,
        TaskRepository $taskRepository,
        ProjectUserRoleProvider $projectUserRoleProvider,
        FileRepository $fileRepository,
        NotificationRepository $notificationRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $tasks = $taskRepository->findBy(
            array('project' => $project),
            array('status' => 'ASC')
        );

        $files = $fileRepository->findBy(
            array('project' => $project),
            array('name' => 'ASC')
        );

        $project->getTextStatus();
        $user = $this->getUser();

        $projectUserRole = null;
        $participation = $projectUserRoleProvider->retrievesRoleInProject($user, $project);
        if ($participation) {
            $projectUserRole = $participation->getRole();
        }

        $file = new File();
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file->setProject($project);
            $file->setUser($this->getUser());
            $file->setIsShared(1);
            $entityManager->persist($file);

            $notificationContent =
                $file->getUser()->getFullNameIfMemberOrONG() .
                ' shared a file  : ' .
                ' on the project : \'' .
                $project->getTitle() .
                '\''
            ;
            foreach ($project->getParticipants() as $notifiedParticipant) {
                if ($notifiedParticipant->getUser() !== $file->getUser()) {
                    $notification = new Notification(
                        $notificationContent,
                        $notifiedParticipant->getUser(),
                        'project_show',
                        'files',
                        $project
                    );
                    $entityManager->persist($notification);
                }
            }

            $entityManager->flush();
            return $this->redirectToRoute('project_show', ['id' => $project, '_fragment' => 'files']);
        }

        $tchatMessage = new TchatMessage();
        $tchatMessageForm = $this->createForm(TchatMessageType::class, $tchatMessage);
        $tchatMessageForm->handleRequest($request);

        if ($tchatMessageForm->isSubmitted() && $tchatMessageForm->isValid()) {
            $tchatMessage->setTchat($project->getTchat());
            $tchatMessage->setSpeaker($this->getUser());
            $tchatMessage->setSendAt(new \DateTime('now'));
            $entityManager->persist($tchatMessage);

            $notificationContent =
                'You have unread messages in the project : \'' .
                $project->getTitle() .
                '\''
            ;
            foreach ($project->getParticipants() as $notifiedParticipant) {
                $notifiedUser = $notifiedParticipant->getUser();
                $lastTchatNotification = $notificationRepository->findLastTchatNotificationByUserAndProject($notifiedUser, $project);
                if (
                    $notifiedUser !== $tchatMessage->getSpeaker() &&
                    ($lastTchatNotification === null ||
                    $lastTchatNotification->getIsRead())
                ) {
                    $notification = new Notification(
                        $notificationContent,
                        $notifiedParticipant->getUser(),
                        'project_show',
                        'tchat',
                        $project
                    );
                    $entityManager->persist($notification);
                }
            }

            $entityManager->flush();
            return $this->redirectToRoute('project_show', ['id' => $project, '_fragment' => 'tchat']);
        }

        return $this->render('project/show.html.twig', [
            'project' => $project,
            'task'    => $task,
            'tasks'   => $tasks,
            'project_user_role' => $projectUserRole,
            'form'    => $form->createView(),
            'tchatMessageForm' => $tchatMessageForm->createView(),
            'files'   => $files,
        ]);
    }

    /**
     * @Route("/{id}/close", name="close", methods={"GET", "POST"})
     */
    public function closeProject(Project $project, Request $request)
    {
        return $this->render('project/close.html.twig', [
            'project' => $project,
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

        $notificationContent =
            $this->getUser()->getFullNameIfMemberOrONG() .
            ' wants to contribute to your project : \'' .
            $project->getTitle() .
            '\' ! You can accept or decline the demand'
        ;
        $notification = new Notification(
            $notificationContent,
            $project->getProjectOwner(),
            'project_show',
            'members',
            $project
        );
        $entityManager->persist($notification);

        $entityManager->flush();

        $this->addFlash(
            'success',
            'Demand sent to the project : ' . $project->getTitle()
        );

        return $this->redirectToRoute('project_show', array('id' => $project->getId()));
    }


    /**
     * @Route("/participant/{project}/{user}/accepted", name="participant_project_accepted", methods={"POST"})
     */
    public function acceptParticipation(
        Project $project,
        User $user,
        Tchat $tchat,
        EntityManagerInterface $entityManager
    ): Response {
        $participation = $user->getParticipationOn($project);
        $participation->setRole(Participant::ROLE_VOLUNTEER);
        $tchat->addUser($user);


        $notificationContent =
            'Congratulations ! ' .
            $this->getUser()->getFullNameIfMemberOrONG() .
            ' added you as a Volunteer on this following project : \'' .
            $project->getTitle() .
            '\''
            ;
        $notification = new Notification(
            $notificationContent,
            $user,
            'project_show',
            'members',
            $project
        );
        $entityManager->persist($notification);

        $entityManager->flush();

        $this->addFlash(
            'success',
            'You have accepted ' . $user->getFirstname()
            . ' ' . $user->getLastname()
            . ' as a volunteer on the project : ' . $project->getTitle()
        );

        return $this->redirectToRoute('project_show', ['id' => $project, '_fragment' => 'members']);
    }

    /**
     * @Route("/participant/{project}/{user}/removed", name="participant_project_removed", methods={"POST"})
     */
    public function removeParticipation(
        Project $project,
        User $user,
        Tchat $tchat,
        EntityManagerInterface $entityManager
    ): Response {
        $participation = $user->getParticipationOn($project);
        $entityManager->remove($participation);
        $tchat->removeUser($user);

        $notificationContent =
            'Sorry. ' .
            $this->getUser()->getFullNameIfMemberOrONG() .
            ' declined your demand as a Volunteer on the following project : \''  .
            $project->getTitle() .
            '\''
        ;
        $notification = new Notification(
            $notificationContent,
            $user,
            'project_show',
            'details',
            $project
        );
        $entityManager->persist($notification);

        $entityManager->flush();

        $this->addFlash(
            'warning',
            'You have rejected ' . $user->getFirstname()
            . ' ' . $user->getLastname()
            . ' as a volunteer on the project : ' . $project->getTitle()
        );

        return $this->redirectToRoute('project_show', ['id' => $project, '_fragment' => 'members']);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     * @param Request $request
     * @param Project $project
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function edit(
        Request $request,
        Project $project,
        SdgRepository $sdgRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        $sdgs = $sdgRepository->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('project_show', array('id' => $project->getId()));
        }

        return $this->render('project/edit.html.twig', [
            'project' => $project,
            'sdgs' => $sdgs,
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
        if ($project->getStatus() != Project::STATUS_CLOSED) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($task->setProject($project));
                $task->setStatus(Task::STATUS_TASK_TO_START);
                $entityManager->persist($task);
                $entityManager->flush();
                return $this->redirectToRoute('project_show', [
                    'id'         => $project->getId(),
                    '_fragment' => 'tasks'
                ]);
            }
            return $this->render('component/project/_project_tasks_new.html.twig', [
                'task' => $task,
                'form' => $form->createView(),
                'project' => $project,
            ]);
        } else {
            return $this->render('component/project/_error.html.twig', [
                'project' => $project,
            ]);
        }
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
     * @Route("/task/{idTask}/attribute", name="task_attribute")
     * @ParamConverter("task", class=Task::class, options={"mapping": {"idTask": "id"}})
     */
    public function attributeTask(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(AttributionTaskType::class, $task, ['project' => $task->getProject()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notificationContent =
                $this->getUser()->getFullNameIfMemberOrONG() .
                ' assigned you the task \'' .
                $task->getName() .
                '\' on the project : \'' .
                $task->getProject()->getTitle() .
                '\''
            ;
            foreach ($task->getUsers() as $notifiedUser) {
                $notification = new Notification(
                    $notificationContent,
                    $notifiedUser,
                    'project_show',
                    'tasks',
                    $task->getProject()
                );
                $entityManager->persist($notification);
            }

            $entityManager->flush();

            $this->addFlash(
                "success",
                "the task has been assigned."
            );

            return $this->redirectToRoute('project_show', [
                'id' => $task->getProject()->getId(),
                '_fragment' => 'tasks',
            ]);
        }

        return $this->render('component/project/task/task_attribute.html.twig', [
            'task'    => $task,
            'form'    => $form->createView(),
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

    /**
     * @Route("/file/{idFile}", name="file_delete", methods={"POST"})
     * @ParamConverter("file", class=File::class, options={"mapping": {"idFile": "id"}})
     */
    public function deleteFile(Request $request, File $file): Response
    {
        if ($this->isCsrfTokenValid('delete' . $file->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($file);
            $entityManager->flush();

            return $this->redirectToRoute('project_show', [
               'id' => $file->getProject()->getId(),
                '_fragment' => 'files',
            ]);
        }
    }
}
