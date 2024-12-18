<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class GenreMusicalEndPointsTest extends ApiTestCase
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

    public function testGetGenresMusicaux(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/genres-musicaux', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    public function testGetGenreMusicalById(): void
    {
        $client = static::createClient();

        // Création d'un genre musical pour le test
        $client->request('POST', '/api/v1/genre-musical/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomGenreMusical' => 'Genre Test'
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['genre_musical'], true);
        $id = $data['id'];

        $client->request('GET', "/api/v1/genre-musical/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['genres_musicaux'], true);

        $this->assertEquals('Genre Test', $responseData[0]['nomGenreMusical']);
    }

    public function testCreateGenreMusical(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/genre-musical/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomGenreMusical' => 'Genre Test'
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['genre_musical'], true);

        $this->assertEquals('Genre Test', $data['nomGenreMusical']);
    }

    public function testUpdateGenreMusical(): void
    {
        $client = static::createClient();

        // Création d'un genre musical pour le test
        $client->request('POST', '/api/v1/genre-musical/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomGenreMusical' => 'Genre Test'
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['genre_musical'], true);
        $id = $data['id'];

        // Mise à jour du genre musical
        $client->request('PATCH', "/api/v1/genre-musical/update/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomGenreMusical' => 'Genre Test Modifié'
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $updatedData = json_decode($client->getResponse()->getContent(), true);
        $updatedData = json_decode($updatedData['genre_musical'], true);
        $this->assertEquals('Genre Test Modifié', $updatedData['nomGenreMusical']);
    }

    public function testDeleteGenreMusical(): void
    {
        $client = static::createClient();

        // Création d'un genre musical pour le test
        $client->request('POST', '/api/v1/genre-musical/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'nomGenreMusical' => 'Genre Test'
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['genre_musical'], true);
        $id = $data['id'];

        // Suppression du genre musical
        $client->request('DELETE', "/api/v1/genre-musical/delete/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $deleteResponse = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('Genre musical supprimé', $deleteResponse['message']);
    }
}