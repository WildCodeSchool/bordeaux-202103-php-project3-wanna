<?php

namespace App\Controller\Admin;

use App\Entity\HomeContent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HomeContentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HomeContent::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
