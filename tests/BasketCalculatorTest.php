<?php

namespace App\Tests;

use App\Entity\BasketPosition;
use App\Repository\BasketPositionRepository;
use App\Service\BasketCalculator;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class BasketCalculatorTest extends TestCase
{

    public function testBasketCalculator() : void
    {

        $basketPosition = $this->createMock(BasketPosition::class);

        $basketPosition->expects($this->once())
            ->method('getQuantity')
            ->will($this->returnValue(2));

        $basketPositions = [$basketPosition];

        $basketRepository = $this
            ->getMockBuilder(BasketPositionRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $basketRepository->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue($basketPositions));


        $entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($basketRepository));

        $basketCalculator = new BasketCalculator($entityManager);
        $quantity =  $basketCalculator->getBasketQuantity('000');
        $this->assertEquals(2,$quantity);

    }

    public function testBasketCalculator2() : void
    {

        $basketPosition = $this->createMock(BasketPosition::class);

        $basketPosition->expects($this->once())
            ->method('getTotalPrice')
            ->will($this->returnValue(1000));

        $basketPositions = [$basketPosition];

        $basketRepository = $this
            ->getMockBuilder(BasketPositionRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $basketRepository->expects($this->once())
            ->method('findBy')
            ->will($this->returnValue($basketPositions));


        $entityManager = $this
            ->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->will($this->returnValue($basketRepository));

        $basketCalculator = new BasketCalculator($entityManager);

        $price = $basketCalculator->getBasketPrice('000');
        $this->assertEquals(1000,$price);

    }

}
