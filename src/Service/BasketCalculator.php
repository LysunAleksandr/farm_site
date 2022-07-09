<?php


namespace App\Service;


use App\Entity\BasketPosition;
use Doctrine\ORM\EntityManagerInterface;

class BasketCalculator implements BasketCalcInterface
{
    private $entityManager;

    public function __construct( EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getBasketPrice(string $sessionID): float
    {
        $basketPositions = $this->entityManager->getRepository(BasketPosition::class)->findBy(['sessionID' => $sessionID ]);
        $totalPrice = 0;
        foreach ($basketPositions  as $basketPosition) {
            $totalPrice = $totalPrice  + $basketPosition->getTotalPrice();
        }

        return $totalPrice;
    }

    public function getBasketQuantity(string $sessionID): int
    {
        $basketPositions = $this->entityManager->getRepository(BasketPosition::class)->findBy(['sessionID' => $sessionID ]);
        $totalQuantity = 0;
        foreach ($basketPositions  as $basketPosition) {
            $totalQuantity = $totalQuantity  + $basketPosition->getQuantity();
        }

        return $totalQuantity;
    }

}