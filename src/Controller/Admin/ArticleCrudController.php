<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function createEntity(string $entityFQCN)
    {
        $article = new Article();
        $article->setUser($this->getUser());

        $article->onPrePersist();
        $article->onPreUpdate();

        return $article;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('Title'),
            TextField::new('Content'),
           TextField::new('Image', 'Paste URL of an image'),

        ];
    }

}
