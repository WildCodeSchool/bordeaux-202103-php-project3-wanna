<?php

namespace App\Controller\Admin;

use App\Entity\Accomplishment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AccomplishmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Accomplishment::class;
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
