<?php

namespace App\Controller\Admin;

use App\Entity\Catalog;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CatalogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Catalog::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            yield TextField::new('title'),
            yield TextField::new('description'),
            yield Field ::new('price'),
            yield ImageField::new('photoFilename')
                ->setBasePath('images')
                ->setUploadDir('public/uploads/photos')
                ->setRequired(false),
//            yield ArrayField::new('ingridients'),
//            yield AssociationField::new('Ingridient1'),
            yield AssociationField::new('Ingr')


        ];
    }

}
