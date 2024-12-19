<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class FicheTechniqueArtisteEndPointsTest extends ApiTestCase
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

    public function testGetFichesTechniques(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/fiches-techniques', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    public function testGetFicheTechniqueById(): void
    {
        $client = static::createClient();

        // Création d'une fiche technique pour le test
        $client->request('POST', '/api/v1/fiche-technique/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'ficheTechniqueArtiste' => [
                    'besoinSonorisation' => 'Besoin de sonorisation',
                    'besoinEclairage' => 'Besoin d\'éclairage',
                    'besoinScene' => 'Besoin de scène',
                    'besoinBackline' => 'Besoin de backline',
                    'besoinEquipements' => 'Besoin d\'équipements',
                ]
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['fiche_technique_artiste'], true);
        $id = $data['id'];

        $client->request('GET', "/api/v1/fiches-technique/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['fiches_techniques_artistes'], true);

        $this->assertEquals('Besoin de sonorisation', $responseData[0]['besoinSonorisation']);
        $this->assertEquals('Besoin d\'éclairage', $responseData[0]['besoinEclairage']);
        $this->assertEquals('Besoin de scène', $responseData[0]['besoinScene']);
        $this->assertEquals('Besoin de backline', $responseData[0]['besoinBackline']);
        $this->assertEquals('Besoin d\'équipements', $responseData[0]['besoinEquipements']);
    }

    public function testCreateFicheTechnique(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/fiche-technique/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'ficheTechniqueArtiste' => [
                    'besoinSonorisation' => 'Besoin de sonorisation',
                    'besoinEclairage' => 'Besoin d\'éclairage',
                    'besoinScene' => 'Besoin de scène',
                    'besoinBackline' => 'Besoin de backline',
                    'besoinEquipements' => 'Besoin d\'équipements',
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['fiche_technique_artiste'], true);

        $this->assertEquals('Besoin de sonorisation', $data['besoinSonorisation']);
        $this->assertEquals('Besoin d\'éclairage', $data['besoinEclairage']);
        $this->assertEquals('Besoin de scène', $data['besoinScene']);
        $this->assertEquals('Besoin de backline', $data['besoinBackline']);
        $this->assertEquals('Besoin d\'équipements', $data['besoinEquipements']);
    }

    public function testUpdateFicheTechnique(): void
    {
        $client = static::createClient();

        // Création d'une fiche technique pour le test
        $client->request('POST', '/api/v1/fiche-technique/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'ficheTechniqueArtiste' => [
                    'besoinSonorisation' => 'Besoin de sonorisation',
                    'besoinEclairage' => 'Besoin d\'éclairage',
                    'besoinScene' => 'Besoin de scène',
                    'besoinBackline' => 'Besoin de backline',
                    'besoinEquipements' => 'Besoin d\'équipements',
                ]
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['fiche_technique_artiste'], true);
        $id = $data['id'];

        // Mise à jour de la fiche technique
        $client->request('PATCH', "/api/v1/fiche-technique/update/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'ficheTechniqueArtiste' => [
                    'besoinSonorisation' => 'Besoin de sonorisation modifié',
                    'besoinEclairage' => 'Besoin d\'éclairage modifié',
                    'besoinScene' => 'Besoin de scène modifié',
                    'besoinBackline' => 'Besoin de backline modifié',
                    'besoinEquipements' => 'Besoin d\'équipements modifié',
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $updatedData = json_decode($client->getResponse()->getContent(), true);
        $updatedData = json_decode($updatedData['fiche_technique_artiste'], true);

        $this->assertEquals('Besoin de sonorisation modifié', $updatedData['besoinSonorisation']);
        $this->assertEquals('Besoin d\'éclairage modifié', $updatedData['besoinEclairage']);
        $this->assertEquals('Besoin de scène modifié', $updatedData['besoinScene']);
        $this->assertEquals('Besoin de backline modifié', $updatedData['besoinBackline']);
        $this->assertEquals('Besoin d\'équipements modifié', $updatedData['besoinEquipements']);
    }

    public function testDeleteFicheTechnique(): void
    {
        $client = static::createClient();

        // Création d'une fiche technique pour le test
        $client->request('POST', '/api/v1/fiche-technique/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'ficheTechniqueArtiste' => [
                    'besoinSonorisation' => 'Besoin de sonorisation',
                    'besoinEclairage' => 'Besoin d\'éclairage',
                    'besoinScene' => 'Besoin de scène',
                    'besoinBackline' => 'Besoin de backline',
                    'besoinEquipements' => 'Besoin d\'équipements',
                ]
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['fiche_technique_artiste'], true);
        $id = $data['id'];

        // Suppression de la fiche technique
        $client->request('DELETE', "/api/v1/fiches-techniques/delete/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $deleteResponse = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('fiche technique de l\'artiste supprimé', $deleteResponse['message']);
    }
}