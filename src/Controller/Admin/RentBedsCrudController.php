<?php

namespace App\Controller\Admin;

use App\Entity\RentBeds;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RentBedsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RentBeds::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            yield TextField::new('title'),
            yield TextField::new('description'),
            yield IntegerField::new('square'),
            yield Field ::new('price'),
            yield DateField::new('dateEndRent'),
            yield TextField::new('videolink'),
            yield ImageField::new('photoFilename')
                ->setBasePath('images')
                ->setUploadDir('public/uploads/photos')
                ->setRequired(false),
            yield AssociationField::new('renter')
        ];
    }

}
