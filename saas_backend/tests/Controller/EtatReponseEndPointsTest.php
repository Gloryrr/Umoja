<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class EtatReponseEndPointsTest extends ApiTestCase
{
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        // récupération du token pour les tests
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
                // "emailUtilisateur" => "test@exemple.com",
            ]
        ]);

        $this->assertResponseIsSuccessful();

        // Décodez la réponse pour récupérer le token
        $data = json_decode($client->getResponse()->getContent(), true);

        return $data['token'];
    }

    public function testGetEtatsReponse(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/etats-reponse', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],      
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    public function testGetEtatReponseById(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/etat-reponse/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatReponse' => [
                    'nomEtatReponse' => 'Nouveau Etat',
                    'descriptionEtatReponse' => 'Description de l\'état',
                ]
            ]
        ]);

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['etat_reponse'], true);
        $id = $responseData['id'];

        $client->request('GET', "/api/v1/etats-reponse/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['etats_reponse'], true);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertEquals($responseData[0]['id'], $id);
        $this->assertEquals($responseData[0]['nomEtatReponse'], 'Nouveau Etat');
        $this->assertEquals($responseData[0]['descriptionEtatReponse'], 'Description de l\'état');
    }

    public function testCreateEtatReponse(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/etat-reponse/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatReponse' => [
                    'nomEtatReponse' => 'Nouveau Etat',
                    'descriptionEtatReponse' => 'Description de l\'état',
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['etat_reponse'], true);

        $this->assertEquals('Nouveau Etat', $data['nomEtatReponse']);
        $this->assertEquals('Description de l\'état', $data['descriptionEtatReponse']);
    }

    public function testUpdateEtatOffre(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/etat-reponse/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatReponse' => [
                    'nomEtatReponse' => 'Nouveau Etat',
                    'descriptionEtatReponse' => 'Description de l\'état',
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $dataResponse = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($dataResponse['etat_reponse'], true);

        print_r($data);

        $id = $data['id'];

        print_r($id);

        // Mise à jour de l'état d'offre

        $client->request('PATCH', "/api/v1/etat-reponse/update/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatReponse' => [
                    'nomEtatReponse' => 'Etat Offre Modifié',
                    'descriptionEtatReponse' => 'Description de l\'état',
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $updatedData = json_decode($client->getResponse()->getContent(), true);
        $updatedData = json_decode($updatedData['etat_reponse'], true);

        print_r($updatedData);

        $this->assertEquals('Etat Offre Modifié', $updatedData['nomEtatReponse']);
        $this->assertEquals('Description de l\'état', $updatedData['descriptionEtatReponse']);
    }

    public function testDeleteEtatReponse(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/etat-reponse/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatReponse' => [
                    'nomEtatReponse' => 'Nouveau Etat',
                    'descriptionEtatReponse' => 'Description de l\'état',
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['etat_reponse'], true);
        $id = $data['id'];

        $client->request('DELETE', "/api/v1/etat-reponse/delete/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $deleteResponse = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('État de réponse supprimée', $deleteResponse['message']);
    }
}
