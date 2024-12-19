<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class EtatOffreEndPointsTest extends ApiTestCase
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

    public function testGetEtatsOffre(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/etats-offre', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    public function testGetEtatOffreById(): void
    {
        $client = static::createClient();

        // Création d'un nouvel état d'offre pour le test

        $client->request('POST', '/api/v1/etat-offre/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatOffre' => [
                    'nomEtat' => 'Test Etat Offre'
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['etat_offre'], true);
        $id = $data['id'];

        // Récupération de l'état d'offre par ID
        $client->request('GET', "/api/v1/etat-offre/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['etat_offre'], true);

        $this->assertEquals($id, $responseData[0]['id']);
        $this->assertEquals('Test Etat Offre', $responseData[0]['nomEtat']);
    }

    public function testCreateEtatOffre(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/etat-offre/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatOffre' => [
                    'nomEtat' => 'Nouvel Etat Offre'
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['etat_offre'], true);

        $this->assertEquals('Nouvel Etat Offre', $data['nomEtat']);
    }

    public function testUpdateEtatOffre(): void
    {
        $client = static::createClient();

        // Création d'un nouvel état d'offre pour le test

        $client->request('POST', '/api/v1/etat-offre/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatOffre' => [
                    'nomEtat' => 'Etat Offre Initial'
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['etat_offre'], true);
        $id = $data['id'];

        // Mise à jour de l'état d'offre

        $client->request('PATCH', "/api/v1/etat-offre/update/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatOffre' => [
                    'nomEtat' => 'Etat Offre Modifié'
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $updatedData = json_decode($client->getResponse()->getContent(), true);
        $updatedData = json_decode($updatedData['etat_offre'], true);

        $this->assertEquals('Etat Offre Modifié', $updatedData['nomEtat']);
    }

    public function testDeleteEtatOffre(): void
    {
        $client = static::createClient();

        // Création d'un nouvel état d'offre pour le test

        $client->request('POST', '/api/v1/etat-offre/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatOffre' => [
                    'nomEtat' => 'Etat Offre à Supprimer'
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['etat_offre'], true);
        $id = $data['id'];

        // Suppression de l'état d'offre
        $client->request('DELETE', "/api/v1/etat-offre/delete/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $deleteResponse = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('État d\'offre supprimée', $deleteResponse['message']);
    }
}
