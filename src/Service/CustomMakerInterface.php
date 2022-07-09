<?php


namespace App\Service;


use App\Entity\BasketPosition;
use App\Entity\Catalog;

interface CustomMakerInterface
{
    public function getBasketCastom( Catalog $catalog, string $sessionId,int $quantity): ?BasketPosition;

}