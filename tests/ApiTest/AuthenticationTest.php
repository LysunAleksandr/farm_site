<?php
namespace App\Tests\ApiTest;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

class AuthenticationTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    public function testLogin(): void
    {
        $client = self::createClient();

        $user = new User();
        $user->setUsername('admin')
        $user->setPassword(
            self::$container->get('security.user_password_hasher')->hashPassword($user, 'admin')
        );

        $manager = self::$container->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();

        // retrieve a token
        $response = $client->request('POST', '/api/login_check', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'username' => 'admin',
                'password' => 'admin',
            ],
        ]);

        $json = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('token', $json);

        // test not authorized
        $client->request('GET', '/api/catalogs');
        $this->assertResponseStatusCodeSame(401);

        // test authorized
        $client->request('GET', '/api/catalogs', ['auth_bearer' => $json['token']]);
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/api/basket_positions', ['auth_bearer' => $json['token']]);
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/api/ingridients', ['auth_bearer' => $json['token']]);
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/api/orders', ['auth_bearer' => $json['token']]);
        $this->assertResponseIsSuccessful();

        $client->request('GET', '/api/users', ['auth_bearer' => $json['token']]);
        $this->assertResponseIsSuccessful();

    }
}