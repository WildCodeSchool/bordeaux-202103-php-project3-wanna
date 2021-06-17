<?php

namespace App\Service;

use App\Entity\Project;
use App\Entity\Statistic;
use App\Repository\OrganizationRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;

class HomeStatsProvider
{
    private UserRepository $userRepository;
    private OrganizationRepository $organizationRepository;
    private ProjectRepository $projectRepository;

    public function __construct(
        UserRepository $userRepository,
        OrganizationRepository $organizationRepository,
        ProjectRepository $projectRepository
    ) {
        $this->userRepository = $userRepository;
        $this->organizationRepository = $organizationRepository;
        $this->projectRepository = $projectRepository;
    }

    public function statCompilator(): object
    {
        $statistic = new Statistic();
        $statistic
            ->setUserTotal(count($this->userRepository->findAll()))
            ->setOrganizationTotal(count($this->organizationRepository->findAll()))
            ->setVolunteerTotal($statistic->getUserTotal() - $statistic->getOrganizationTotal())
            ->setProjectTotal(count($this->projectRepository->findAll()))
            ->setOnGoingProjectTotal(count($this->projectRepository->findby(['status' => Project::STATUS_OPEN])))
            ->setSkillTotal(count($this->userRepository->findUniqueUserSkills()))
            ->setCountryTotal(count($this->userRepository->findUniqueUserCountries()))
            ->setLanguageTotal(count($this->userRepository->findUniqueUserLanguages()));
        return $statistic;
    }
}
