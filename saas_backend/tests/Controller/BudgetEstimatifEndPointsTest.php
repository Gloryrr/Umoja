<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class BudgetEstimatifEndPointsTest extends ApiTestCase
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
     * Teste le endpoint pour récupérer tous les budgetEstimatifs.
     */
    public function testGetAllBudgetEstimatifs(): void
    {
        $client = static::createClient();

        // Ajoutez le token d'accès aux en-têtes de la requête
        $response = $client->request('GET', '/api/v1/budgets-estimatifs', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    /**
     * Teste le endpoint pour récupérer un budgetEstimatif par ID.
     */
    public function testGetbudgetEstimatifById(): void
    {
        $client = static::createClient();

        // Créez un budgetEstimatif pour le test
        $client->request('POST', '/api/v1/budget-estimatif/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'cachetArtiste' => '5000',
                'fraisHebergement' => '5000',
                'fraisRestauration' => '5000',
                'fraisDeplacement' => '5000',
            ],
        ]);

        $this->assertResponseIsSuccessful();

        // Décodez la réponse JSON contenant l'budgetEstimatif
        $responseData = json_decode($client->getResponse()->getContent(), true);

        // L'budgetEstimatif est une chaîne JSON, donc nous devons la décoder
        $budgetEstimatif = json_decode($responseData['budget_estimatif'], true);

        // Récupérer l'ID de l'budgetEstimatif
        $budgetEstimatifId = $budgetEstimatif['id'];
        $cachetArtiste = $budgetEstimatif['cachetArtiste'];
        $fraisHebergement = $budgetEstimatif['fraisHebergement'];
        $fraisRestauration = $budgetEstimatif['fraisRestauration'];
        $fraisDeplacement = $budgetEstimatif['fraisDeplacement'];

        // Teste le GET par ID avec le token dans les en-têtes
        $client->request('GET', "/api/v1/budget-estimatif/{$budgetEstimatifId}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['budget_estimatif'], true);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertEquals($responseData[0]['id'], $budgetEstimatifId);
        $this->assertEquals($responseData[0]['cachetArtiste'], $cachetArtiste);
        $this->assertEquals($responseData[0]['fraisHebergement'], $fraisHebergement);
        $this->assertEquals($responseData[0]['fraisRestauration'], $fraisRestauration);
        $this->assertEquals($responseData[0]['fraisDeplacement'], $fraisDeplacement);
    }

    /**
     * Teste le endpoint pour créer un budgetEstimatif.
     */
    public function testCreatebudgetEstimatif(): void
    {
        $client = static::createClient();

        // Créez un budgetEstimatif pour le test
        $client->request('POST', '/api/v1/budget-estimatif/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'cachetArtiste' => '5000',
                'fraisHebergement' => '5000',
                'fraisRestauration' => '5000',
                'fraisDeplacement' => '5000',
            ],
        ]);

        // récupération des données renvoyées
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $budgetEstimatif = json_decode($responseData['budget_estimatif'], true);

        
        $budgetEstimatifId = $budgetEstimatif['id'];
        $cachetArtiste = $budgetEstimatif['cachetArtiste'];
        $fraisHebergement = $budgetEstimatif['fraisHebergement'];
        $fraisRestauration = $budgetEstimatif['fraisRestauration'];
        $fraisDeplacement = $budgetEstimatif['fraisDeplacement'];

        $this->assertEquals($budgetEstimatif['id'], $budgetEstimatifId);
        $this->assertEquals($budgetEstimatif['cachetArtiste'], $cachetArtiste);
        $this->assertEquals($budgetEstimatif['fraisHebergement'], $fraisHebergement);
        $this->assertEquals($budgetEstimatif['fraisRestauration'], $fraisRestauration);
        $this->assertEquals($budgetEstimatif['fraisDeplacement'], $fraisDeplacement);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
    }

    /**
     * Teste le endpoint pour mettre à jour un budgetEstimatif.
     */
    public function testUpdatebudgetEstimatif(): void
    {
        $client = static::createClient();

        // Créez un budgetEstimatif pour le test
        $client->request('POST', '/api/v1/budget-estimatif/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'cachetArtiste' => '5000',
                'fraisHebergement' => '5000',
                'fraisRestauration' => '5000',
                'fraisDeplacement' => '5000',
            ],
        ]);

        $this->assertResponseIsSuccessful();

        // récupération des données renvoyées
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $budgetEstimatif = json_decode($responseData['budget_estimatif'], true);

        // vérification des données revnoyées par l'API
        $budgetEstimatifId = $budgetEstimatif['id'];
        $cachetArtiste = $budgetEstimatif['cachetArtiste'];
        $fraisHebergement = $budgetEstimatif['fraisHebergement'];
        $fraisRestauration = $budgetEstimatif['fraisRestauration'];
        $fraisDeplacement = $budgetEstimatif['fraisDeplacement'];

        $this->assertEquals($budgetEstimatif['id'], $budgetEstimatifId);
        $this->assertEquals($budgetEstimatif['cachetArtiste'], $cachetArtiste);
        $this->assertEquals($budgetEstimatif['fraisHebergement'], $fraisHebergement);
        $this->assertEquals($budgetEstimatif['fraisRestauration'], $fraisRestauration);
        $this->assertEquals($budgetEstimatif['fraisDeplacement'], $fraisDeplacement);

        // On met à jour l'budgetEstimatif maintenant
        $client->request('PATCH', "/api/v1/budget-estimatif/update/{$budgetEstimatifId}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'cachetArtiste' => '10000',
                'fraisHebergement' => '10000',
                'fraisRestauration' => '10000',
                'fraisDeplacement' => '10000',
            ],
        ]);

        $this->assertResponseIsSuccessful();

        // récupération des données renvoyées
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $budgetEstimatif = json_decode($responseData['budget_estimatif'], true);
        
        // vérification des données revnoyées par l'API
        $budgetEstimatifId = $budgetEstimatif['id'];
        $cachetArtiste = $budgetEstimatif['cachetArtiste'];
        $fraisHebergement = $budgetEstimatif['fraisHebergement'];
        $fraisRestauration = $budgetEstimatif['fraisRestauration'];
        $fraisDeplacement = $budgetEstimatif['fraisDeplacement'];

        $this->assertEquals($budgetEstimatif['id'], $budgetEstimatifId);
        $this->assertEquals($budgetEstimatif['cachetArtiste'], $cachetArtiste);
        $this->assertEquals($budgetEstimatif['fraisHebergement'], $fraisHebergement);
        $this->assertEquals($budgetEstimatif['fraisRestauration'], $fraisRestauration);
        $this->assertEquals($budgetEstimatif['fraisDeplacement'], $fraisDeplacement);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
    }

    /**
     * Teste le endpoint pour supprimer un budgetEstimatif.
     */
    public function testDeletebudgetEstimatif(): void
    {
        $client = static::createClient();

        // Créez un budgetEstimatif pour le test
        $client->request('POST', '/api/v1/budget-estimatif/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'cachetArtiste' => '5000',
                'fraisHebergement' => '5000',
                'fraisRestauration' => '5000',
                'fraisDeplacement' => '5000',
            ],
        ]);

        $this->assertResponseIsSuccessful();

        // récupération des données renvoyées
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $responseData = json_decode($responseData['budget_estimatif'], true);

        $idbudgetEstimatif = $responseData['id'];

        // On supprime l'budgetEstimatif maintenant
        $client->request('DELETE', "/api/v1/budget-estimatif/delete/{$idbudgetEstimatif}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        // récupération des données de l'budgetEstimatif supprimé
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $responseData = json_decode($responseData['budget_estimatif'], true);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

    }
}
