<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderControllerTest extends WebTestCase
{
    public function testOrderController(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/order');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Order');
    }

}
