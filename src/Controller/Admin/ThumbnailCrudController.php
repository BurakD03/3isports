<?php

namespace App\Controller\Admin;

use App\Entity\Thumbnail;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ThumbnailCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Thumbnail::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('titre'),
            TextEditorField::new('descriptionThumb'),
            ImageField::new('image')
            ->setBasePath('uploads/images/thumbnail/')
            ->setUploadDir('public/uploads/images/thumbnail'),
        ];
    }
}