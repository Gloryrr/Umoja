<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ConditionsFinancieresEndPointsTest extends ApiTestCase
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

    public function testGetConditionsFinancieres(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/conditions-financieres', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    public function testGetConditionFinanciereById(): void
    {
        $client = static::createClient();

        // ID à tester, supposons qu'une condition existe avec l'ID 1
        $payload = [
            'minimumGaranti' => 4000,
            'conditionsPaiement' => 'EUR',
            'pourcentageRecette' => 1.5,
        ];

        $client->request('POST', '/api/v1/condition-financiere/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => $payload
        ]);

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['condition_financiere'], true);

        $id = $responseData['id'];

        $client->request('GET', "/api/v1/condition-financiere/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['condition_financiere'], true);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertEquals($responseData[0]['id'], $id);
        $this->assertEquals($responseData[0]['minimunGaranti'], 4000);
        $this->assertEquals($responseData[0]['conditionsPaiement'], 'EUR');
    }

    public function testCreateConditionsFinancieres(): void
    {
        $client = static::createClient();

        $payload = [
            'minimumGaranti' => 4000,
            'conditionsPaiement' => 'EUR',
            'pourcentageRecette' => 1.5,
        ];

        $client->request('POST', '/api/v1/condition-financiere/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => $payload
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['condition_financiere'], true);
 
        print_r($data);

        $this->assertEquals(4000, $data['minimunGaranti']);
        $this->assertEquals('EUR', $data['conditionsPaiement']);
    }

    public function testUpdateConditionsFinancieres(): void
    {
        $client = static::createClient();

        // ID à tester, supposons qu'une condition existe avec l'ID 1
        $payload = [
            'minimumGaranti' => 4000,
            'conditionsPaiement' => 'EUR',
            'pourcentageRecette' => 1.5,
        ];

        $client->request('POST', '/api/v1/condition-financiere/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => $payload
        ]);

        $this->assertResponseIsSuccessful();
        $id = json_decode($client->getResponse()->getContent(), true);
        $id = json_decode($id['condition_financiere'], true);
        $id = $id['id'];

        $payload = [
            'minimumGaranti' => 5000,
            'conditionsPaiement' => 'USD',
            'pourcentageRecette' => 1.5,
        ];

        $data = $client->request('PATCH', "/api/v1/condition-financiere/update/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => $payload
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($data->getContent(), true);
        $data = json_decode($data['condition_financiere'], true);

        print_r($data);

        $this->assertEquals(5000, $data['minimumGaranti']);
        $this->assertEquals('USD', $data['conditionsPaiement']);
    }

    public function testDeleteConditionsFinancieres(): void
    {
        $client = static::createClient();

        // ID à tester, supposons qu'une condition existe avec l'ID 1
        $payload = [
            'minimumGaranti' => 4000,
            'conditionsPaiement' => 'EUR',
            'pourcentageRecette' => 1.5,
        ];

        $client->request('POST', '/api/v1/condition-financiere/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => $payload
        ]);

        $this->assertResponseIsSuccessful();
        $id = json_decode($client->getResponse()->getContent(), true);
        $id = json_decode($id['condition_financiere'], true);
        $id = $id['id'];

        $client->request('DELETE', "/api/v1/condition-financiere/delete/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('condition financière supprimée', $data['message']);
    }
}
