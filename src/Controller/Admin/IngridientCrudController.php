<?php

namespace App\Controller\Admin;

use App\Entity\Ingridient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class IngridientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ingridient::class;
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
