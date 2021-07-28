<?php

namespace App\Controller\Admin;

use App\Entity\CarouselSlide;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CarouselSlideCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CarouselSlide::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('numero'),
            TextField::new('title'),
            TextEditorField::new('caption'),
            TextField::new('image'),

        ];
    }
}
