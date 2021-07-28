<?php

namespace App\Controller\Admin;

use App\Entity\TchatMessage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TchatMessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TchatMessage::class;
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
