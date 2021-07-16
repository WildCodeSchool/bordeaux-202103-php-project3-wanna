<?php

namespace App\Service;

use App\Repository\ProjectRepository;

class UserProjectSkillMatcher
{

    private ProjectRepository $projectRepository;

    public function __construct(
        ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function sortProjectsByStatusAndCommonSkills($user, $projects): array
    {
        $projectsToValidate = array_filter($projects, function ($object) {return $object->getStatus() == '0';});
        $projectsToValidate = $this->sortProjectsByCommonSkills($user, $projectsToValidate);

        $projectsToStart = array_filter($projects, function ($object) {return ($object->getStatus() == '1');});
        $projectsToStart = $this->sortProjectsByCommonSkills($user, $projectsToStart);

        $projectsOnGoing = array_filter($projects, function ($object) {return $object->getStatus() == '2';});
        $projectsOnGoing = $this->sortProjectsByCommonSkills($user, $projectsOnGoing);

        $projectsClosed = array_filter($projects, function ($object) {return $object->getStatus() == '3';});
        $projectsClosed = $this->sortProjectsByCommonSkills($user, $projectsClosed);

        $projects = array_merge($projectsToStart, $projectsOnGoing, $projectsClosed);
        return $projects;
    }


    public function sortProjectsByCommonSkills($user, $projects): array {
        $userSkills = $user->getSkills()->toArray();
        foreach($projects as $project) {
            $projectSkills = $project->getSkills()->toArray();
            $commonSkills = array_intersect($userSkills, $projectSkills);
            $differentSkills = array_diff($projectSkills, $userSkills);
            $project->setCommonSkillsWithUser($commonSkills);
            $project->setDifferentSkillsFromUser($differentSkills);
        }
        usort($projects, function($a, $b) {return count($a->getCommonSkillsWithUser()) < count($b->getCommonSkillsWithUser());});
        return $projects;
    }
}




