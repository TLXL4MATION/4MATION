<?php

namespace App\Controller\Admin;

use App\Entity\Adresse;
use App\Entity\Campus;
use App\Entity\Creneau;
use App\Entity\Formateur;
use App\Entity\GroupePromotion;
use App\Entity\ModuleFormation;
use App\Entity\Promotion;
use App\Entity\Salle;
use App\Entity\User;
use App\Repository\CreneauRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/home-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('4MATION');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        //yield MenuItem::linkToCrud('Adresses', 'fa-solid fa-location-dot', Adresse::class);
        yield MenuItem::linkToCrud('Campus', 'fa-solid fa-building-columns', Campus::class);
        yield MenuItem::linkToCrud('Créneaux', 'fa-solid fa-calendar-days', Creneau::class);
        yield MenuItem::linkToCrud('Formateurs', 'fa-solid fa-user-group', Formateur::class);
        yield MenuItem::linkToCrud('Groupes promotion', 'fa-solid fa-people-group', GroupePromotion::class);
        yield MenuItem::linkToCrud('Modules de formation', 'fa-solid fa-sheet-plastic', ModuleFormation::class);
        yield MenuItem::linkToCrud('Promotions', 'fa-solid fa-globe', Promotion::class);
        yield MenuItem::linkToCrud('Salles', 'fa-solid fa-house-laptop', Salle::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa-solid fa-user', User::class);

    }

}
