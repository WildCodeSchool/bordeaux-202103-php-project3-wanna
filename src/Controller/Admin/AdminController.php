<?php

namespace App\Controller\Admin;

use App\Entity\Accomplishment;
use App\Entity\Article;
use App\Entity\Organization;
use App\Entity\Project;
use App\Entity\Skill;
use App\Entity\SkillSet;
use App\Entity\User;
use App\Service\HomeStatsProvider;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class AdminController extends AbstractDashboardController
{
    /**
     * @Route("/admin/administration", name="administration")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Wanna Gonna Admin Dashboard');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Members', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Organizations', 'fas fa-list', Organization::class);
        yield MenuItem::linkToCrud('Projects', 'fas fa-list', Project::class);
        yield MenuItem::linkToCrud('Articles', 'fas fa-list', Article::class);
        yield MenuItem::linkToCrud('Skills', 'fas fa-list', Skill::class);
        yield MenuItem::linkToCrud('Skillsets', 'fas fa-list', SkillSet::class);
        yield MenuItem::linkToCrud('Accomplishments', 'fas fa-list', Accomplishment::class);
        yield MenuItem::section('Back to main website');
        yield MenuItem::linkToRoute('Homepage', 'fas fa-list', 'home_index');
        yield MenuItem::linkToLogout('Logout', 'fa fa-exit');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setPaginatorPageSize(30)
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->overrideTemplate('crud/detail', 'admin/index.html.twig')
            ;
    }
}
