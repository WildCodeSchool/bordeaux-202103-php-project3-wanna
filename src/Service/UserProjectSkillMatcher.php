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

    public function sortProjectsByCommonSkills($user, $projects): array {
        $userSkills = $user->getSkills()->toArray();
        foreach($projects as $project) {
            $projectSkills = $project->getSkills()->toArray();
            $commonSkills = array_intersect($userSkills, $projectSkills);
            $project->setCommonSkillsWithUser($commonSkills);
        }
        usort($projects, function($a, $b) {return count($a->getCommonSkillsWithUser()) < count($b->getCommonSkillsWithUser());});
        return $projects;
    }
}




