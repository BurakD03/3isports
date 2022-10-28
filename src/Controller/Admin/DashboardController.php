<?php

namespace App\Controller\Admin;

use App\Entity\Accueil;
use App\Entity\Auteur;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Newsletter;
use App\Entity\SousCategorie;
use App\Entity\Thumbnail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(CategorieCrudController::class)->generateUrl());
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
        yield MenuItem::linktoCrud('Catégories', 'fa fa-newspaper', Categorie::class);
        yield MenuItem::linktoCrud('Sous Catégories', 'fa fa-file-word', SousCategorie::class);
        yield MenuItem::linktoCrud('Auteurs', 'fa fa-pen-to-square', Auteur::class);
        yield MenuItem::linktoCrud('Articles', 'fa  fa-pen-to-square', Article::class);
        yield MenuItem::linktoCrud('Thumbnail', 'fa fa-pen-to-square', Thumbnail::class);
        yield MenuItem::linktoCrud('Accueil', 'fa fa-pen-to-square', Accueil::class);
        yield MenuItem::linktoCrud('Newsletter', 'fa fa-pen-to-square', Newsletter::class);

        /*yield MenuItem::linktoCrud('Magazines', 'fa fa-file-pdf', Article::class);
        yield MenuItem::linktoCrud('Biographie', 'fas fa-user-alt', Auteur::class);
        */
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}