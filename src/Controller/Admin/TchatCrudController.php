<?php

namespace App\Controller\Admin;

use App\Entity\Tchat;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TchatCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tchat::class;
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
