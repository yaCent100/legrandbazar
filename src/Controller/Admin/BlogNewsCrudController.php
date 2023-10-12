<?php

namespace App\Controller\Admin;

use App\Entity\BlogNews;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BlogNewsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BlogNews::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('titre'),
            TextEditorField::new('content'),
            DateField::new('creatAt'),
        ];
    }
}
