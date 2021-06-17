<?php

namespace App\Service;

use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
use App\Repository\ParticipantRepository;

class ProjectUserRoleProvider
{
    private UserRepository $userRepository;
    private ProjectRepository $projectRepository;
    private ParticipantRepository $participantRepository;

    public function __construct(
        UserRepository $userRepository,
        ProjectRepository $projectRepository,
        ParticipantRepository $participantRepository)
    {
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
        $this->participantRepository = $participantRepository;
    }

    public function retrievesRoleInProject($user, $project) {

        $projectUserRole =$this->participantRepository->findUserRoleInProject($user, $project);
        return $projectUserRole;
    }
}



