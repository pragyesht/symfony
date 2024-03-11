<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InviteControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', 'http://127.0.0.1:8000/invite');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Assert response content
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testCreate(): void
    {
        $client = static::createClient();

        // Send a POST request with JSON payload
        $client->request(
            'POST',
            '/invite/send',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['inv_from' => 1, 'inv_to' => 2])
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Assert response content
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('"msg"', $client->getResponse()->getContent());
    }

    public function testCancel(): void
    {
        $client = static::createClient();

        // Send a DELETE request
        $client->request('DELETE', '/invite/cancel/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Assert response content
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('"msg"', $client->getResponse()->getContent());
    }

    public function testDecline(): void
    {
        $client = static::createClient();

        // Send a PUT request
        $client->request('PUT', '/invite/decline/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Assert response content
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('"msg"', $client->getResponse()->getContent());
    }

    public function testAccept(): void
    {
        $client = static::createClient();

        // Send a PUT request
        $client->request('PUT', '/invite/accept/1');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        // Assert response content
        $this->assertJson($client->getResponse()->getContent());
        $this->assertStringContainsString('"msg"', $client->getResponse()->getContent());
    }
}
