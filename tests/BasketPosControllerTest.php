<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasketPosControllerTest extends WebTestCase
{
    public function testBasketPosController(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/basket');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Basket');
    }
}
