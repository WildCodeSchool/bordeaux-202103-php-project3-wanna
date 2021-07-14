<?php


namespace App\EventListener;


use App\Entity\Notification;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class UpdateProjectStatusListener
{
    private int $projectStatusOnPreUpdate;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function postLoad(Project $project, LifecycleEventArgs $args): void
    {
        $this->setProjectStatusOnPreUpdate($project->getStatus());
    }

    public function postUpdate(Project $project, LifecycleEventArgs $args)
    {
        if ($this->getProjectStatusOnPreUpdate() === Project::STATUS_REQUEST_SEND &&
            $project->getStatus() === Project::STATUS_REQUEST_VALIDATED) {

            $notificationContent =
                'Congratulations ! Your request for the project ' .
                '\'' .
                $project->getTitle() .
                '\'' .
                ' has been validated by the administrator'
            ;
            $projectOwner = $project->getProjectOwner();
            $notification = new Notification(
                $notificationContent,
                $projectOwner,
                'project_show',
                'details',
                $project
            );
            $this->entityManager->persist($notification);
            $this->entityManager->flush();

        }
    }

    /**
     * @return int
     */
    public function getProjectStatusOnPreUpdate(): int
    {
        return $this->projectStatusOnPreUpdate;
    }

    /**
     * @param int $projectStatusOnPreUpdate
     */
    public function setProjectStatusOnPreUpdate(int $projectStatusOnPreUpdate): void
    {
        $this->projectStatusOnPreUpdate = $projectStatusOnPreUpdate;
    }



}