<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            'firstname',
            'lastname',
            'email',
            'password',
            AssociationField::new('organization'),
            AssociationField::new('languages'),
            AssociationField::new('country'),
            ChoiceField::new('roles', 'Roles')
                ->allowMultipleChoices()
                ->autocomplete()
                ->setChoices(['User' => 'ROLE_USER',
                        'Admin' => 'ROLE_ADMIN',
                        'SuperAdmin' => 'ROLE_SUPER_ADMIN']
                ),

        ];
    }

}
