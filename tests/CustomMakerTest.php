<?php

namespace App\Tests;

use App\Entity\Catalog;
use App\Entity\Ingridient;
use App\Service\CustomMaker;
use App\Service\CustomMakerInterface;
use PHPUnit\Framework\TestCase;

class CustomMakerTest extends TestCase
{
    public function testCustomMaker(): void
    {
        $catalog = new Catalog();
        $sessionId = '000000000000000';
        $quantity = 2;
        $catalog->setTitle('Title');
        $customMakerInterface = new CustomMaker();
        $Ingridient = new Ingridient();
        $Ingridient->setTitle('Meat');

        $catalog->addIngr($Ingridient);
        $basketPosition = $customMakerInterface->getBasketCastom($catalog,$sessionId,$quantity);
        $this->assertEquals(2,$basketPosition->getQuantity());
        $this->assertEquals('Title',$basketPosition->getTitle());
        $this->assertEquals( '000000000000000',$basketPosition->getSessionID());
        $this->assertEquals( 1,$basketPosition->getIngr()->count());
        $this->assertEquals( 'Meat',$basketPosition->getIngr()->first());

        $this->assertTrue(true);
    }

    public function testCustomMakerException(): void
    {
        $catalog = new Catalog();
        $sessionId = '000000000000000';
        $quantity = 2;
        $catalog->setTitle('Title');
        $customMakerInterface = new CustomMaker();
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('The ingredient field cannot be empty');
        $customMakerInterface->getBasketCastom($catalog, $sessionId, $quantity);
    }
    public function testCustomMakerTitleException(): void
    {
        $catalog = new Catalog();
        $sessionId = '000000000000000';
        $quantity = 2;
        $customMakerInterface = new CustomMaker();
        $this->expectExceptionMessage('App\Entity\BasketPosition::setTitle(): Argument #1 ($title) must be of type string, null given, called in /var/www/app/src/Service/CustomMaker.php on line 25');
        $customMakerInterface->getBasketCastom($catalog, $sessionId, $quantity);
    }
}
