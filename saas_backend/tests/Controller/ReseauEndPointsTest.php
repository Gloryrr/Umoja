<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ReseauEndPointsTest extends ApiTestCase
{
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        // Récupération du token pour les tests
        $this->token = $this->getAccessToken();
    }

    /**
     * Récupère un token d'accès pour un utilisateur.
     */
    private function getAccessToken(): string
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/login', [
            'json' => [
                "username" => "admin",
                "mdpUtilisateur" => "admin",
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);

        return $data['token'];
    }

    public function testGetReseaux(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/reseaux', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    public function testGetReseauByName(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/reseau', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomReseau' => 'Reseau Test',
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['reseau'], true);

        $this->assertEquals('Reseau Test', $data[0]['nomReseau']);
    }

    public function testCreateReseau(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/reseau/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomReseau' => 'Reseau Test'
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['reseau'], true);

        $this->assertEquals('Reseau Test', $data['nomReseau']);
    }

    public function testUpdateReseau(): void
    {
        $client = static::createClient();

        // Création d'un réseau pour le test
        $client->request('POST', '/api/v1/reseau/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomReseau' => 'Reseau Test'
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['reseau'], true);
        $id = $data['id'];

        // Mise à jour du réseau
        $client->request('PATCH', "/api/v1/reseau/update/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomReseau' => 'Reseau Test Modifié'
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $updatedData = json_decode($client->getResponse()->getContent(), true);
        $updatedData = json_decode($updatedData['reseau'], true);

        $this->assertEquals('Reseau Test Modifié', $updatedData['nomReseau']);
    }

    public function testDeleteReseau(): void
    {
        $client = static::createClient();

        // Création d'un réseau pour le test
        $client->request('POST', '/api/v1/reseau/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomReseau' => 'Reseau Test'
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['reseau'], true);
        $id = $data['id'];

        // Suppression du réseau
        $client->request('DELETE', "/api/v1/reseau/delete/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $deleteResponse = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('réseau supprimé', $deleteResponse['message']);
    }
}