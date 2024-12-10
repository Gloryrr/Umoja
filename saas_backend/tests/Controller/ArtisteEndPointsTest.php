<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ArtisteEndPointsTest extends ApiTestCase
{
    public string $token;

    public function setUp(): void
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

    /**
     * Teste le endpoint pour récupérer tous les artistes.
     */
    public function testGetAllArtistes(): void
    {
        $client = static::createClient();

        // Ajoutez le token d'accès aux en-têtes de la requête
        $response = $client->request('GET', '/api/v1/artistes', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    /**
     * Teste le endpoint pour récupérer un artiste par ID.
     */
    public function testGetArtisteById(): void
    {
        $client = static::createClient();

        // Créez un artiste pour le test
        $client->request('POST', '/api/v1/artiste/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomArtiste' => 'Artiste Test',
                'descrArtiste' => 'Description de l\'artiste test',
            ],
        ]);

        $this->assertResponseIsSuccessful();

        // Décodez la réponse JSON contenant l'artiste
        $responseData = json_decode($client->getResponse()->getContent(), true);

        // L'artiste est une chaîne JSON, donc nous devons la décoder
        $artiste = json_decode($responseData['artiste'], true);

        // Récupérer l'ID de l'artiste
        $artisteId = $artiste['id'];

        // Teste le GET par ID avec le token dans les en-têtes
        $client->request('GET', "/api/v1/artiste/{$artisteId}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['artiste'], true);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertEquals($responseData[0]['id'], $artisteId);
        $this->assertEquals($responseData[0]['nomArtiste'], 'Artiste Test');

    }

    /**
     * Teste le endpoint pour créer un artiste.
     */
    public function testCreateArtiste(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/artiste/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomArtiste' => 'Artiste Test',
                'descrArtiste' => 'Description de l\'artiste test',
            ],
        ]);

        // récupération des données renvoyées
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $responseData = json_decode($responseData['artiste'], true);

        print_r($responseData);
        $this->assertEquals($responseData['nomArtiste'], 'Artiste Test');
        $this->assertEquals($responseData['descrArtiste'], 'Description de l\'artiste test');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
    }

    /**
     * Teste le endpoint pour mettre à jour un artiste.
     */
    public function testUpdateArtiste(): void
    {
        $client = static::createClient();

        // Créez un artiste pour le test
        $client->request('POST', '/api/v1/artiste/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomArtiste' => 'Artiste Test',
                'descrArtiste' => 'Description de l\'artiste test',
            ],
        ]);

        $this->assertResponseIsSuccessful();

        // récupération des données renvoyées
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $responseData = json_decode($responseData['artiste'], true);

        print_r($responseData);
        $idArtiste = $responseData['id'];

        // On met à jour l'artiste maintenant
        $client->request('PATCH', "/api/v1/artiste/update/{$idArtiste}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomArtiste' => 'Artiste Test Modifié',
                'descrArtiste' => 'Description de l\'artiste test modifiée',
            ],
        ]);

        $this->assertResponseIsSuccessful();

        // récupération des données renvoyées
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $responseData = json_decode($responseData['artiste'], true);
        
        $this->assertEquals($responseData['nomArtiste'], 'Artiste Test Modifié');
        $this->assertEquals($responseData['descrArtiste'], 'Description de l\'artiste test modifiée');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
    }

    /**
     * Teste le endpoint pour supprimer un artiste.
     */
    public function testDeleteArtiste(): void
    {
        $client = static::createClient();

        // Créez un artiste pour le test
        $client->request('POST', '/api/v1/artiste/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomArtiste' => 'Artiste Test',
                'descrArtiste' => 'Description de l\'artiste test',
            ],
        ]);

        $this->assertResponseIsSuccessful();

        // récupération des données renvoyées
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $responseData = json_decode($responseData['artiste'], true);

        $idArtiste = $responseData['id'];

        // On supprime l'artiste maintenant
        $client->request('DELETE', "/api/v1/artiste/delete/{$idArtiste}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        // récupération des données de l'artiste supprimé
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $responseData = json_decode($responseData['artiste'], true);

        $this->assertEquals($responseData['nomArtiste'], 'Artiste Test');
        $this->assertEquals($responseData['descrArtiste'], 'Description de l\'artiste test');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

    }
}
