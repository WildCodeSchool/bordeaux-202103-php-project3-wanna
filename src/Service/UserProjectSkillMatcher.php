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
            $differentSkills = array_diff($projectSkills, $userSkills);
            $project->setCommonSkillsWithUser($commonSkills);
            $project->setDifferentSkillsFromUser($differentSkills);
        }
        usort($projects, function($a, $b) {return count($a->getCommonSkillsWithUser()) < count($b->getCommonSkillsWithUser());});
        return $projects;
    }
}




