<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class UtilisateurEndPointsTest extends ApiTestCase
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

    public function testGetUtilisateurs(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/utilisateurs', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    public function testGetUtilisateurByName(): void
    {
        $client = static::createClient();

        $response = $client->request('POST', '/api/v1/utilisateur', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'username' => 'uadmin'
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    public function testCreateUtilisateur(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/utilisateurs/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'username' => 'username test 2',
                'mdpUtilisateur' => 'password test',
                'emailUtilisateur' => 'email test 2'
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['utilisateur'], true);

        $this->assertEquals('username test 2', $data['username']);
        $this->assertEquals('email test 2', $data['emailUtilisateur']);
    }

    public function testUpdateUtilisateur(): void
    {
        $client = static::createClient();

        // Création d'un utilisateur pour le test
        $client->request('POST', '/api/v1/utilisateurs/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'username' => 'username test 3',
                'mdpUtilisateur' => 'password test',
                'emailUtilisateur' => 'email test 3'
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['utilisateur'], true);
        $id = $data['id'];

        // Mise à jour de l'utilisateur
        $client->request('PATCH', "/api/v1/utilisateurs/update/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'username' => 'username test modifié',
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $updatedData = json_decode($client->getResponse()->getContent(), true);
        $updatedData = json_decode($updatedData['utilisateur'], true);

        $this->assertEquals('username test modifié', $updatedData['username']);
    }

    public function testDeleteUtilisateur(): void
    {
        $client = static::createClient();

        // Création d'un utilisateur pour le test
        $client->request('POST', '/api/v1/utilisateurs/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'username' => 'username test 4',
                'mdpUtilisateur' => 'password test',
                'emailUtilisateur' => 'email test 4'
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['utilisateur'], true);
        $id = $data['id'];

        // Suppression de l'utilisateur
        $client->request('DELETE', "/api/v1/utilisateurs/delete/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $deleteResponse = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Utilisateur supprimé', $deleteResponse['message']);
    }
}
