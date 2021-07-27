<?php

namespace App\Controller\Admin;

use App\Entity\Accomplishment;
use App\Entity\Article;
use App\Entity\CarouselSlide;
use App\Entity\FAQ;
use App\Entity\HomeContent;
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
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-chart-line');
        yield MenuItem::linkToCrud('Members', 'fa fa-users', User::class);
        yield MenuItem::linkToCrud('Organizations', 'fas fa-globe', Organization::class);
        yield MenuItem::linkToCrud('Projects', 'fas fa-folder', Project::class);
        yield MenuItem::linkToCrud('Articles', 'fas fa-file-image', Article::class);
        yield MenuItem::linkToCrud('Skills', 'fas fa-graduation-cap', Skill::class);
        yield MenuItem::linkToCrud('Skillsets', 'fas fa-shapes', SkillSet::class);
        yield MenuItem::section('Home Page Edition');
        yield MenuItem::linkToCrud('Homepage Content', 'fas fa-award', HomeContent::class);
        yield MenuItem::linkToCrud('Carousel', 'fas fa-award', CarouselSlide::class);
        yield MenuItem::linkToCrud('FAQs', 'fas fa-award', FAQ::class);
        yield MenuItem::section('Back to main website');
        yield MenuItem::linkToRoute('Homepage', 'fas fa-home', 'home_index');
        yield MenuItem::linkToLogout('Logout', 'fa fa-door-open');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setPaginatorPageSize(30)
            ->setPageTitle('index', '%entity_label_plural% listing')
            ->overrideTemplate('crud/detail', 'admin/index.html.twig')
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
            ;
    }
}
