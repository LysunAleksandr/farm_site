<?php

namespace App\DataFixtures;

use App\Entity\BasketPosition;
use App\Entity\Catalog;
use App\Entity\Ingridient;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword('$2y$13$p1e9P7cIGUXivXY3xAqU5ehEnRmFKA6PYvB98OHG.xGjo.Ph7Kgxe');
        $manager->persist($admin);

        $catalog = new Catalog();
        $catalog->setTitle('Репа');
        $catalog->setPrice(600);
        $catalog->setDescription('Описание репы');
        $catalog->setPhotoFilename('repa.jpg');
        $manager->persist($catalog);

        $catalog1 = new Catalog();
        $catalog1->setTitle('Кабачок');
        $catalog1->setPrice(800);
        $catalog1->setDescription('Описание кабачка');
        $catalog1->setPhotoFilename('kabachok.jpg');
        $manager->persist($catalog1);

        $catalog2 = new Catalog();
        $catalog2->setTitle('Ананас');
        $catalog2->setPrice(900);
        $catalog2->setDescription('Описание ананаса');
        $catalog2->setPhotoFilename('ananas.jpg');
        $manager->persist($catalog2);

        $basket_pos = new BasketPosition();
        $basket_pos->setTitle('Кабачок');
        $basket_pos->setPrice(800);
        $basket_pos->setQuantity(2);
        $basket_pos->setCatalog($catalog1);
        $basket_pos->setSessionID('admin');
        $manager->persist($basket_pos);

        $basket_pos1 = new BasketPosition();
        $basket_pos1->setTitle('Ананас');
        $basket_pos1->setPrice(900);
        $basket_pos1->setQuantity(2);
        $basket_pos1->setCatalog($catalog1);
        $basket_pos1->setSessionID('admin');
        $manager->persist($basket_pos1);

        $manager->flush();
    }
}
