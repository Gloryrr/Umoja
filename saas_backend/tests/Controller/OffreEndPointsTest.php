<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class OffreEndPointsTest extends ApiTestCase
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

    public function testGetOffres(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/offres', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    public function testGetOffreById(): void
    {
        $client = static::createClient();

        // Création d'une offre pour le test
        $client->request('POST', '/api/v1/offre/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                "detailOffre" => [
                    "titleOffre" => "Concert de fin d'année",
                    "deadLine" => "2024-12-30",
                    "descrTournee" => "Une tournée exceptionnelle pour finir l'année en beauté.",
                    "dateMinProposee" => "2024-12-15",
                    "dateMaxProposee" => "2024-12-20",
                    "villeVisee" => "Paris",
                    "regionVisee" => "Île-de-France",
                    "placesMin" => 50,
                    "placesMax" => 100,
                    "nbArtistesConcernes" => 3,
                    "nbInvitesConcernes" => 2
                ],
                "extras" => [
                    "descrExtras" => "Options VIP disponibles",
                    "coutExtras" => 200,
                    "exclusivite" => "zbziscnsi",
                    "exception" => "Aucune exception",
                    "clausesConfidentialites" => "Confidentialité stricte"
                ],
                "etatOffre" => [
                    "nomEtatOffre" => "En cours"
                ],
                "typeOffre" => [
                    "nomTypeOffre" => "Tournée"
                ],
                "conditionsFinancieres" => [
                    "minimumGaranti" => 5000,
                    "conditionsPaiement" => "EUR",
                    "pourcentageRecette" => 15.0
                ],
                "budgetEstimatif" => [
                    "cachetArtiste" => 3000,
                    "fraisDeplacement" => 1000,
                    "fraisHebergement" => 800,
                    "fraisRestauration" => 700
                ],
                "ficheTechniqueArtiste" => [
                    "liensPromotionnels" => ["http://youtube.com/artist1", "http://spotify.com/artist2"],
                    "ordrePassage" => "1,2,3",
                    "besoinBackline" => "efbeoufboef",
                    "besoinEclairage" => "efbeoufboef",
                    "besoinEquipements" => "efbeoufboef",
                    "besoinScene" => "efbeoufboef",
                    "besoinSonorisation" => "efbeoufboef",
                    "nbArtistes" => 3,
                    "artiste" => ["Artiste 1", "Artiste 2", "Artiste 3"]
                ],
                "utilisateur" => [
                    "username" => "admin"
                ],
                "donneesSupplementaires" => [
                    "nbReseaux" => 0,
                    "reseau" => [],
                    "nbGenresMusicaux" => 0,
                    "genreMusical" => [],
                ],
                "image" => [
                    "file" => "null"
                ]
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['offre'], true);
        $id = $data['id'];

        $client->request('GET', "/api/v1/offre/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = $responseData['offre'];

        $this->assertEquals('Concert de fin d\'année', $responseData['titleOffre']);
        $this->assertEquals('Une tournée exceptionnelle pour finir l\'année en beauté.', $responseData['descrTournee']);
        $this->assertEquals('Paris', $responseData['villeVisee']);
        $this->assertEquals('Île-de-France', $responseData['regionVisee']);
        $this->assertEquals(50, $responseData['placesMin']);
        $this->assertEquals(100, $responseData['placesMax']);
        $this->assertEquals(3, $responseData['nbArtistesConcernes']);
    }

    public function testCreateOffre(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/offre/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                "detailOffre" => [
                    "titleOffre" => "Concert de fin d'année",
                    "deadLine" => "2024-12-30",
                    "descrTournee" => "Une tournée exceptionnelle pour finir l'année en beauté.",
                    "dateMinProposee" => "2024-12-15",
                    "dateMaxProposee" => "2024-12-20",
                    "villeVisee" => "Paris",
                    "regionVisee" => "Île-de-France",
                    "placesMin" => 50,
                    "placesMax" => 100,
                    "nbArtistesConcernes" => 3,
                    "nbInvitesConcernes" => 2
                ],
                "extras" => [
                    "descrExtras" => "Options VIP disponibles",
                    "coutExtras" => 200,
                    "exclusivite" => "zbziscnsi",
                    "exception" => "Aucune exception",
                    "clausesConfidentialites" => "Confidentialité stricte"
                ],
                "etatOffre" => [
                    "nomEtatOffre" => "En cours"
                ],
                "typeOffre" => [
                    "nomTypeOffre" => "Tournée"
                ],
                "conditionsFinancieres" => [
                    "minimumGaranti" => 5000,
                    "conditionsPaiement" => "EUR",
                    "pourcentageRecette" => 15.0
                ],
                "budgetEstimatif" => [
                    "cachetArtiste" => 3000,
                    "fraisDeplacement" => 1000,
                    "fraisHebergement" => 800,
                    "fraisRestauration" => 700
                ],
                "ficheTechniqueArtiste" => [
                    "liensPromotionnels" => ["http://youtube.com/artist1", "http://spotify.com/artist2"],
                    "ordrePassage" => "1,2,3",
                    "besoinBackline" => "efbeoufboef",
                    "besoinEclairage" => "efbeoufboef",
                    "besoinEquipements" => "efbeoufboef",
                    "besoinScene" => "efbeoufboef",
                    "besoinSonorisation" => "efbeoufboef",
                    "nbArtistes" => 3,
                    "artiste" => ["Artiste 1", "Artiste 2", "Artiste 3"]
                ],
                "utilisateur" => [
                    "username" => "admin"
                ],
                "donneesSupplementaires" => [
                    "nbReseaux" => 0,
                    "reseau" => [],
                    "nbGenresMusicaux" => 0,
                    "genreMusical" => [],
                ],
                "image" => [
                    "file" => "null"
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['offre'], true);

        print_r($data);

        $this->assertEquals('Concert de fin d\'année', $data['titleOffre']);
        $this->assertEquals('Une tournée exceptionnelle pour finir l\'année en beauté.', $data['descrTournee']);
    }

    public function testUpdateOffre(): void
    {
        $client = static::createClient();

        // Création d'une offre pour le test
        $client->request('POST', '/api/v1/offre/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                "detailOffre" => [
                    "titleOffre" => "Concert de fin d'année",
                    "deadLine" => "2024-12-30",
                    "descrTournee" => "Une tournée exceptionnelle pour finir l'année en beauté.",
                    "dateMinProposee" => "2024-12-15",
                    "dateMaxProposee" => "2024-12-20",
                    "villeVisee" => "Paris",
                    "regionVisee" => "Île-de-France",
                    "placesMin" => 50,
                    "placesMax" => 100,
                    "nbArtistesConcernes" => 3,
                    "nbInvitesConcernes" => 2
                ],
                "extras" => [
                    "descrExtras" => "Options VIP disponibles",
                    "coutExtras" => 200,
                    "exclusivite" => "zbziscnsi",
                    "exception" => "Aucune exception",
                    "clausesConfidentialites" => "Confidentialité stricte"
                ],
                "etatOffre" => [
                    "nomEtatOffre" => "En cours"
                ],
                "typeOffre" => [
                    "nomTypeOffre" => "Tournée"
                ],
                "conditionsFinancieres" => [
                    "minimumGaranti" => 5000,
                    "conditionsPaiement" => "EUR",
                    "pourcentageRecette" => 15.0
                ],
                "budgetEstimatif" => [
                    "cachetArtiste" => 3000,
                    "fraisDeplacement" => 1000,
                    "fraisHebergement" => 800,
                    "fraisRestauration" => 700
                ],
                "ficheTechniqueArtiste" => [
                    "liensPromotionnels" => ["http://youtube.com/artist1", "http://spotify.com/artist 2"],
                    "ordrePassage" => "1,2,3",
                    "besoinBackline" => "efbeoufboef",
                    "besoinEclairage" => "efbeoufboef",
                    "besoinEquipements" => "efbeoufboef",
                    "besoinScene" => "efbeoufboef",
                    "besoinSonorisation" => "efbeoufboef",
                    "nbArtistes" => 3,
                    "artiste" => ["Artiste 1", "Artiste 2", "Artiste 3"]
                ],
                "utilisateur" => [
                    "username" => "admin"
                ],
                "donneesSupplementaires" => [
                    "nbReseaux" => 0,
                    "reseau" => [],
                    "nbGenresMusicaux" => 0,
                    "genreMusical" => [],
                ],
                "image" => [
                    "file" => "null"
                ]
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['offre'], true);
        $id = $data['id'];

        $client->request('PATCH', "/api/v1/offre/update/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                "detailOffre" => [
                    "titleOffre" => "Concert de fin d'année modifié",
                    "deadLine" => "2024-12-30",
                    "descrTournee" => "Une tournée exceptionnelle pour finir l'année en beauté.",
                    "dateMinProposee" => "2024-12-15",
                    "dateMaxProposee" => "2024-12-20",
                    "villeVisee" => "Paris",
                    "regionVisee" => "Île-de-France",
                    "placesMin" => 50,
                    "placesMax" => 100,
                    "nbArtistesConcernes" => 3,
                    "nbInvitesConcernes" => 2
                ],
                "extras" => [
                    "descrExtras" => "Options VIP disponibles",
                    "coutExtras" => 200,
                    "exclusivite" => "zbziscnsi",
                    "exception" => "Aucune exception",
                    "clausesConfidentialites" => "Confidentialité stricte"
                ],
                "etatOffre" => [
                    "nomEtatOffre" => "En cours"
                ],
                "typeOffre" => [
                    "nomTypeOffre" => "Tournée"
                ],
                "conditionsFinancieres" => [
                    "minimumGaranti" => 5000,
                    "conditionsPaiement" => "EUR",
                    "pourcentageRecette" => 15.0
                ],
                "budgetEstimatif" => [
                    "cachetArtiste" => 3000,
                    "fraisDeplacement" => 1000,
                    "fraisHebergement" => 800,
                    "fraisRestauration" => 700
                ],
                "ficheTechniqueArtiste" => [
                    "liensPromotionnels" => ["http://youtube.com/artist1", "http://spotify.com/artist2"],
                    "ordrePassage" => "1,2,3",
                    "besoinBackline" => "efbeoufboef",
                    "besoinEclairage" => "efbeoufboef",
                    "besoinEquipements" => "efbeoufboef",
                    "besoinScene" => "efbeoufboef",
                    "besoinSonorisation" => "efbeoufboef",
                    "nbArtistes" => 3,
                    "artiste" => ["Artiste 1", "Artiste 2", "Artiste 3"]
                ],
                "utilisateur" => [
                    "username" => "admin"
                ],
                "donneesSupplementaires" => [
                    "nbReseaux" => 0,
                    "reseau" => [],
                    "nbGenresMusicaux" => 0,
                    "genreMusical" => [],
                ],
                "image" => [
                    "file" => "null"
                ]
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['offre'], true);

        $this->assertEquals('Concert de fin d\'année modifié', $responseData['titleOffre']);
        $this->assertEquals('Une tournée exceptionnelle pour finir l\'année en beauté.', $responseData['descrTournee']);
        $this->assertEquals('Paris', $responseData['villeVisee']);
        $this->assertEquals('Île-de-France', $responseData['regionVisee']);
        $this->assertEquals(50, $responseData['placesMin']);
        $this->assertEquals(100, $responseData['placesMax']);
        $this->assertEquals(3, $responseData['nbArtistesConcernes']);
        $this->assertEquals(2, $responseData['nbInvitesConcernes']);
    }

    public function testDeleteOffre(): void
    {
        $client = static::createClient();

        // Création d'une offre pour le test
        $client->request('POST', '/api/v1/offre/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                "detailOffre" => [
                    "titleOffre" => "Concert de fin d'année",
                    "deadLine" => "2024-12-30",
                    "descrTournee" => "Une tournée exceptionnelle pour finir l'année en beauté.",
                    "dateMinProposee" => "2024-12-15",
                    "dateMaxProposee" => "2024-12-20",
                    "villeVisee" => "Paris",
                    "regionVisee" => "Île-de-France",
                    "placesMin" => 50,
                    "placesMax" => 100,
                    "nbArtistesConcernes" => 3,
                    "nbInvitesConcernes" => 2
                ],
                "extras" => [
                    "descrExtras" => "Options VIP disponibles",
                    "coutExtras" => 200,
                    "exclusivite" => "zbziscnsi",
                    "exception" => "Aucune exception",
                    "clausesConfidentialites" => "Confidentialité stricte"
                ],
                "etatOffre" => [
                    "nomEtatOffre" => "En cours"
                ],
                "typeOffre" => [
                    "nomTypeOffre" => "Tournée"
                ],
                "conditionsFinancieres" => [
                    "minimumGaranti" => 5000,
                    "conditionsPaiement" => "EUR",
                    "pourcentageRecette" => 15.0
                ],
                "budgetEstimatif" => [
                    "cachetArtiste" => 3000,
                    "fraisDeplacement" => 1000,
                    "fraisHebergement" => 800,
                    "fraisRestauration" => 700
                ],
                "ficheTechniqueArtiste" => [
                    "liensPromotionnels" => ["http://youtube.com/artist1", "http://spotify.com/artist 2"],
                    "ordrePassage" => "1,2,3",
                    "besoinBackline" => "efbeoufboef",
                    "besoinEclairage" => "efbeoufboef",
                    "besoinEquipements" => "efbeoufboef",
                    "besoinScene" => "efbeoufboef",
                    "besoinSonorisation" => "efbeoufboef",
                    "nbArtistes" => 3,
                    "artiste" => ["Artiste 1", "Artiste 2", "Artiste 3"]
                ],
                "utilisateur" => [
                    "username" => "admin"
                ],
                "donneesSupplementaires" => [
                    "nbReseaux" => 0,
                    "reseau" => [],
                    "nbGenresMusicaux" => 0,
                    "genreMusical" => [],
                ],
                "image" => [
                    "file" => "null"
                ]
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['offre'], true);

        $id = $data['id'];

        $client->request('DELETE', "/api/v1/offre/delete/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $deleteResponse = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('offre supprimée', $deleteResponse['message']);
    }
}