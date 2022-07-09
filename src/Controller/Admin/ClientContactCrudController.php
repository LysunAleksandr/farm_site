<?php

namespace App\Controller\Admin;

use App\Entity\ClientContact;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ClientContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ClientContact::class;
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
