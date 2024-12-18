<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class TypeOffreEndPointsTest extends ApiTestCase
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

    public function testGetTypeOffres(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/type-offres', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    public function testGetTypeOffreById(): void
    {
        $client = static::createClient();

        // Création d'un type d'offre pour le test
        $client->request('POST', '/api/v1/type-offre/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomTypeOffre' => 'Type Test'
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['type_offre'], true);
        $id = $data['id'];

        // Récupération par ID
        $response = $client->request('GET', "/api/v1/type-offre/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());

        $typeOffre = json_decode($response->getContent(), true);
        $typeOffre = json_decode($typeOffre['types_offre'], true);

        $this->assertEquals('Type Test', $typeOffre[0]['nomTypeOffre']);
    }

    public function testCreateTypeOffre(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/type-offre/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomTypeOffre' => 'Type Test'
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['type_offre'], true);

        $this->assertEquals('Type Test', $data['nomTypeOffre']);
    }

    public function testUpdateTypeOffre(): void
    {
        $client = static::createClient();

        // Création d'un type d'offre pour le test
        $client->request('POST', '/api/v1/type-offre/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomTypeOffre' => 'Type Test'
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['type_offre'], true);
        $id = $data['id'];

        // Mise à jour du type d'offre
        $client->request('PATCH', "/api/v1/type-offre/update/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomTypeOffre' => 'Type Test Modifié'
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $updatedData = json_decode($client->getResponse()->getContent(), true);
        $updatedData = json_decode($updatedData['type_offre'], true);

        $this->assertEquals('Type Test Modifié', $updatedData['nomTypeOffre']);
    }

    public function testDeleteTypeOffre(): void
    {
        $client = static::createClient();

        // Création d'un type d'offre pour le test
        $client->request('POST', '/api/v1/type-offre/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomTypeOffre' => 'Type Test'
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['type_offre'], true);
        $id = $data['id'];

        // Suppression du type d'offre
        $client->request('DELETE', "/api/v1/type-offre/delete/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $deleteResponse = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Type d\'offre supprimé', $deleteResponse['message']);
    }
}
