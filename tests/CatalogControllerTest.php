<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CatalogControllerTest extends WebTestCase
{
    public function testCatalogControlle(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Pizza!');
    }
/*
    public function testCatalogControlleShow(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/pizza/1');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Add in basket');
    }
*/
}
