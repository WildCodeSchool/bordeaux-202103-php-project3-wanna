<?php


namespace App\Service;


use App\Repository\OrganizationRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;

class HomeStatsProvider
{
    private $userRepository;
    private $organizationRepository;
    private $projectRepository;

    public function __construct(UserRepository $userRepository,
                                OrganizationRepository $organizationRepository,
                                ProjectRepository $projectRepository) {
        $this->userRepository = $userRepository;
        $this->organizationRepository = $organizationRepository;
        $this->projectRepository = $projectRepository;
    }

    public function statProvider() : array {
        $stats[0] = count($this->userRepository->findAll());
        $stats[] = count($this->projectRepository->findAll());
        //TODO FIX Nb of different countries members are part of
        $stats[] = 1;
        $stats[] = count($this->organizationRepository->findAll());
        return $stats;
        }
}

