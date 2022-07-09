<?php


namespace App\Service;


interface BasketCalcInterface
{
    public function getBasketPrice(string $sessionID): ?float;

    public function getBasketQuantity(string $sessionID): ?int;
}