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
    private $encoderFactory;

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setUsername('admin');
        $admin->setPassword('$2y$13$p1e9P7cIGUXivXY3xAqU5ehEnRmFKA6PYvB98OHG.xGjo.Ph7Kgxe');
        $manager->persist($admin);

        $ingridient1 = new Ingridient();
        $ingridient1->setTitle('meat');
        $manager->persist($ingridient1);

        $ingridient2 = new Ingridient();
        $ingridient2->setTitle('pepperoni');
        $manager->persist($ingridient2);

        $ingridient3 = new Ingridient();
        $ingridient3->setTitle('vegetables');
        $manager->persist($ingridient3);

        $ingridient4 = new Ingridient();
        $ingridient4->setTitle('pineapples');
        $manager->persist($ingridient4);

        $ingridient5 = new Ingridient();
        $ingridient5->setTitle('cheese');
        $manager->persist($ingridient5);

        $ingridient6 = new Ingridient();
        $ingridient6->setTitle('mushrooms');
        $manager->persist($ingridient6);

        $catalog = new Catalog();
        $catalog->setTitle('Carbonara');
        $catalog->setPrice(600);
        $catalog->setDescription('Carbonara description');
        $catalog->setPhotoFilename('carbonara.jpg');
        $catalog->addIngr($ingridient1);
        $catalog->addIngr($ingridient2);
        $manager->persist($catalog);

        $catalog1 = new Catalog();
        $catalog1->setTitle('Margarita');
        $catalog1->setPrice(800);
        $catalog1->setDescription('Margarita description');
        $catalog1->setPhotoFilename('margarita.jpg');
        $catalog1->addIngr($ingridient3);
        $catalog1->addIngr($ingridient4);
        $manager->persist($catalog1);

        $catalog2 = new Catalog();
        $catalog2->setTitle('Peperoni');
        $catalog2->setPrice(900);
        $catalog2->setDescription('Peperoni description');
        $catalog2->setPhotoFilename('peper.jpg');
        $catalog2->addIngr($ingridient4);
        $catalog2->addIngr($ingridient5);
        $manager->persist($catalog2);

        $basket_pos = new BasketPosition();
        $basket_pos->setTitle('Margarita');
        $basket_pos->setPrice(800);
        $basket_pos->setQuantity(2);
        $basket_pos->setCatalog($catalog1);
        $basket_pos->setSessionID('admin');
        $basket_pos->addIngr($ingridient3);
        $basket_pos->addIngr($ingridient4);
        $manager->persist($basket_pos);

        $basket_pos1 = new BasketPosition();
        $basket_pos1->setTitle('Peperoni');
        $basket_pos1->setPrice(900);
        $basket_pos1->setQuantity(2);
        $basket_pos1->setCatalog($catalog1);
        $basket_pos1->setSessionID('admin');
        $basket_pos1->addIngr($ingridient4);
        $basket_pos1->addIngr($ingridient5);
        $manager->persist($basket_pos1);

        $manager->flush();
    }
}
