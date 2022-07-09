<?php


namespace App\Service;


use App\Entity\BasketPosition;
use App\Entity\Catalog;
use App\Entity\Ingridient;
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
        $ingridients = $catalog->getIngr();

        $i = 0;
        foreach ($ingridients  as $ingridient) {
            $basketPosition->addIngr($ingridient);
            $i=$i+1;
        }
        if ($i == 0) {
            throw new \RuntimeException('The ingredient field cannot be empty');
        }
        return $basketPosition;

    }

}