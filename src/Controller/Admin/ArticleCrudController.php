<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\Admin\ThumbnailType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Controller\Admin\ThumbnailCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Request;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $article = new Article();

        return $article;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('titre'),
            TextEditorField::new('description'),
            AssociationField::new('sousCategorie')->autocomplete(),
            ImageField::new('image')
            ->setBasePath('uploads/images/articles/')
            ->setUploadDir('public/uploads/images/articles'),
            AssociationField::new('auteur')->autocomplete(),
            TextField::new('alt'),
            TextEditorField::new('url'),
            //AssociationField::new('thumbnail')->autocomplete()->setCrudController(ThumbnailCrudController::class)
            TextField::new('thumbnail')->setFormType(ThumbnailType::class)->setFormTypeOption('label', 'Créer un thumbnail différent ?')->onlyWhenCreating(),

        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/new', 'admin/EasyAdminBundle/crud/create.html.twig')
        ;
    }
}