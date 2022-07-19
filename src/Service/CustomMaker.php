<?php


namespace App\Service;


use App\Entity\BasketPosition;
use App\Entity\Catalog;
use Doctrine\ORM\EntityManagerInterface;

class CustomMaker implements CustomMakerInterface
{
 //   private $entityManager;

    public function __construct( )
    {
      //  $this->entityManager = $entityManager;
    }

    public function getBasketCastom( Catalog $catalog, string $sessionId,int $quantity): BasketPosition
    {
        $basketPosition = new BasketPosition();
        $basketPosition->setSessionID($sessionId);
        $basketPosition->setTitle($catalog->getTitle());
        $basketPosition->setPrice(1000);
        $basketPosition->setQuantity($quantity);

        return $basketPosition;

    }

}