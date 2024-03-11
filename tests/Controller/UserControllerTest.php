<?php
// tests/Controller/UserControllerTest.php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/user');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreate(): void
    {
        $client = static::createClient();

        // Send a POST request with JSON payload
        $client->request(
            'POST',
            '/user/create',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['name' => 'Test User'])
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Assert response content
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('"msg"', $client->getResponse()->getContent());
    }

    public function testInsert(): void
    {
        $client = static::createClient();

        // Send a GET request
        $client->request('GET', '/user/insert');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Assert response content
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('"msg"', $client->getResponse()->getContent());
    }
}
