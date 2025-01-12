<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ExtrasEndPointsTest extends ApiTestCase
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

        // Décode la réponse pour récupérer le token
        $data = json_decode($client->getResponse()->getContent(), true);

        return $data['token'];
    }

    public function testGetExtras(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/extras', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],      
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    public function testGetExtraById(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/extras/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'extras' => [
                    'descrExtras' => 'Description de l\'extra',
                    'coutExtras' => 10,
                    'exclusivite' => 'Exclusivité de l\'extra',
                    'exception' => 'Exception de l\'extra',
                    'ordrePassage' => 'Ordre de passage de l\'extra',
                    'clausesConfidentialites' => 'Clauses de confidentialité de l\'extra',
                ]
            ]
        ]);

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['extra'], true);
        $id = $responseData['id'];

        $client->request('GET', "/api/v1/extras/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['extras'], true);

        $this->assertEquals('Description de l\'extra', $responseData[0]['descrExtras']);
        $this->assertEquals(10, $responseData[0]['coutExtras']);
        $this->assertEquals('Exclusivité de l\'extra', $responseData[0]['exclusivite']);
        $this->assertEquals('Exception de l\'extra', $responseData[0]['exception']);
        $this->assertEquals('Ordre de passage de l\'extra', $responseData[0]['ordrePassage']);
        $this->assertEquals('Clauses de confidentialité de l\'extra', $responseData[0]['clausesConfidentialites']);
        $this->assertEquals($id, $responseData[0]['id']);

    }

    public function testCreateExtra(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/extras/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'extras' => [
                    'descrExtras' => 'Description de l\'extra',
                    'coutExtras' => 10,
                    'exclusivite' => 'Exclusivité de l\'extra',
                    'exception' => 'Exception de l\'extra',
                    'ordrePassage' => 'Ordre de passage de l\'extra',
                    'clausesConfidentialites' => 'Clauses de confidentialité de l\'extra',
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($data['extra'], true);

        $this->assertEquals('Description de l\'extra', $responseData['descrExtras']);
        $this->assertEquals(10, $responseData['coutExtras']);
        $this->assertEquals('Exclusivité de l\'extra', $responseData['exclusivite']);
        $this->assertEquals('Exception de l\'extra', $responseData['exception']);
        $this->assertEquals('Ordre de passage de l\'extra', $responseData['ordrePassage']);
        $this->assertEquals('Clauses de confidentialité de l\'extra', $responseData['clausesConfidentialites']);
    }

    public function testUpdateExtra(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/extras/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'extras' => [
                    'descrExtras' => 'Description de l\'extra',
                    'coutExtras' => 10,
                    'exclusivite' => 'Exclusivité de l\'extra',
                    'exception' => 'Exception de l\'extra',
                    'ordrePassage' => 'Ordre de passage de l\'extra',
                    'clausesConfidentialites' => 'Clauses de confidentialité de l\'extra',
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['extra'], true);
        $id = $data['id'];

        $client->request('PATCH', "/api/v1/extras/update/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'extras' => [
                    'descrExtras' => 'Description de l\'extra modifié',
                    'coutExtras' => 20,
                    'exclusivite' => 'Exclusivité de l\'extra modifié',
                    'exception' => 'Exception de l\'extra modifié',
                    'ordrePassage' => 'Ordre de passage de l\'extra modifié',
                    'clausesConfidentialites' => 'Clauses de confidentialité de l\'extra modifié',
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $updatedData = json_decode($client->getResponse()->getContent(), true);
        $updatedData = json_decode($updatedData['extra'], true);

        $this->assertEquals('Description de l\'extra modifié', $updatedData['descrExtras']);
        $this->assertEquals(20, $updatedData['coutExtras']);
        $this->assertEquals('Exclusivité de l\'extra modifié', $updatedData['exclusivite']);
        $this->assertEquals('Exception de l\'extra modifié', $updatedData['exception']);
        $this->assertEquals('Ordre de passage de l\'extra modifié', $updatedData['ordrePassage']);
        $this->assertEquals('Clauses de confidentialité de l\'extra modifié', $updatedData['clausesConfidentialites']);
    }

    public function testDeleteExtra(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/extras/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'extras' => [
                    'descrExtras' => 'Description de l\'extra modifié',
                    'coutExtras' => 20,
                    'exclusivite' => 'Exclusivité de l\'extra modifié',
                    'exception' => 'Exception de l\'extra modifié',
                    'ordrePassage' => 'Ordre de passage de l\'extra modifié',
                    'clausesConfidentialites' => 'Clauses de confidentialité de l\'extra modifié',
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['extra'], true);
        $id = $data['id'];

        $client->request('DELETE', "/api/v1/extras/delete/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $deleteResponse = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('Extra supprimé avec succès.', $deleteResponse['message']);
    }
}
