<?php

namespace App\Controller\Admin;

use App\Entity\SkillSet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SkillSetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SkillSet::class;
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
