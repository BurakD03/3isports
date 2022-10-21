<?php

namespace App\Controller\Admin;

use App\Entity\Auteur;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Entity\Thumbnail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CategorieCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('3isports');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Accueil', 'fa fa-home');
        yield MenuItem::section('Gestion des articles');
        yield MenuItem::linktoCrud('Catégories', 'fa fa-file-pdf', Categorie::class);
        yield MenuItem::linktoCrud('Sous Catégories', 'fa fa-file-pdf', SousCategorie::class);
        yield MenuItem::linktoCrud('Auteurs', 'fa fa-file-pdf', Auteur::class);
        yield MenuItem::linktoCrud('Articles', 'fa fa-file-pdf', Article::class);
        yield MenuItem::linktoCrud('Thumbnail', 'fa fa-file-pdf', Thumbnail::class);
        /*yield MenuItem::linktoCrud('Magazines', 'fa fa-file-pdf', Article::class);
        yield MenuItem::linktoCrud('Biographie', 'fas fa-user-alt', Auteur::class);
        */
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}