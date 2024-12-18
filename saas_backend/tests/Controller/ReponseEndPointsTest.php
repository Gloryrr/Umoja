<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ReponseEndPointsTest extends ApiTestCase
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

    public function testGetReponses(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/reponses', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    public function testGetReponseById(): void
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
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);
        $offreResponse = json_decode($data['offre'], true); 
        $idOffre = $offreResponse['id'];

        $client->request('POST', "/api/v1/etat-reponse/create", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatReponse' => [
                    'nomEtatReponse' => 'Etat réponse',
                    'descriptionEtatReponse' => 'Description de l\'état réponse',
                ]
            ]
        ]);
        $this->assertResponseIsSuccessful();

        // Création d'une réponse pour le test
        $client->request('POST', '/api/v1/reponse/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'offre' =>[
                    'idOffre' => $idOffre
                ],
                'etatReponse' => [
                    'nomEtatReponse' => 'Etat réponse'
                ],
                'utilisateur' => [
                    'username' => 'admin'
                ],
                'dateDebut' => '2024-12-15',
                'dateFin' => '2024-12-20',
                'prixParticipation' => 1000,
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['reponse_offre'], true);
        $id = $data['id'];

        $client->request('GET', "/api/v1/reponse/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['reponses'], true);

        $this->assertEquals($id, $responseData[0]['id']);
        $this->assertEquals('Etat réponse', $responseData[0]['etatReponse']['nomEtatReponse']);
        $this->assertEquals(1000, $responseData[0]['prixParticipation']);
    }

    public function testCreateReponse(): void
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
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);
        $offreResponse = json_decode($data['offre'], true);
        $idOffre = $offreResponse['id'];

        $client->request('POST', "/api/v1/etat-reponse/create", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatReponse' => [
                    'nomEtatReponse' => 'Etat réponse',
                    'descriptionEtatReponse' => 'Description de l\'état réponse',
                ]
            ]
        ]);
        $this->assertResponseIsSuccessful();

        // Création d'une réponse pour le test
        $client->request('POST', '/api/v1/reponse/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'offre' =>[
                    'idOffre' => $idOffre
                ],
                'etatReponse' => [
                    'nomEtatReponse' => 'Etat réponse'
                ],
                'utilisateur' => [
                    'username' => 'admin'
                ],
                'dateDebut' => '2024-12-15',
                'dateFin' => '2024-12-20',
                'prixParticipation' => 1000,
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['reponse_offre'], true);

        $this->assertEquals('Etat réponse', $data['etatReponse']['nomEtatReponse']);
        $this->assertEquals(1000, $data['prixParticipation']);
        $this->assertEquals('admin', $data['utilisateur']['username']);
        $this->assertEquals($idOffre, $data['offre']['id']);
    }

    public function testUpdateReponse(): void
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
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);
        $offreResponse = json_decode($data['offre'], true);
        $idOffre = $offreResponse['id'];

        $client->request('POST', "/api/v1/etat-reponse/create", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatReponse' => [
                    'nomEtatReponse' => 'Etat réponse',
                    'descriptionEtatReponse' => 'Description de l\'état réponse',
                ]
            ]
        ]);
        $this->assertResponseIsSuccessful();

        // Création d'une réponse pour le test
        $client->request('POST', '/api/v1/reponse/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'offre' =>[
                    'idOffre' => $idOffre
                ],
                'etatReponse' => [
                    'nomEtatReponse' => 'Etat réponse'
                ],
                'utilisateur' => [
                    'username' => 'admin'
                ],
                'dateDebut' => '2024-12-15',
                'dateFin' => '2024-12-20',
                'prixParticipation' => 1000,
            ]
        ]);

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['reponse_offre'], true);
        $id = $data['id'];

        // Mise à jour de la réponse
        $client->request('PATCH', "/api/v1/reponse/update/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'prixParticipation' => 1500
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $updatedData = json_decode($client->getResponse()->getContent(), true);
        $updatedData = json_decode($updatedData['reponse_offre'], true);

        $this->assertEquals(1500, $updatedData['prixParticipation']);
    }

    public function testDeleteReponse(): void
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
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);
        $offreResponse = json_decode($data['offre'], true);
        $idOffre = $offreResponse['id'];

        $client->request('POST', "/api/v1/etat-reponse/create", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'etatReponse' => [
                    'nomEtatReponse' => 'Etat réponse',
                    'descriptionEtatReponse' => 'Description de l\'état réponse',
                ]
            ]
        ]);
        $this->assertResponseIsSuccessful();

        // Création d'une réponse pour le test
        $client->request('POST', '/api/v1/reponse/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'offre' =>[
                    'idOffre' => $idOffre
                ],
                'etatReponse' => [
                    'nomEtatReponse' => 'Etat réponse'
                ],
                'utilisateur' => [
                    'username' => 'admin'
                ],
                'dateDebut' => '2024-12-15',
                'dateFin' => '2024-12-20',
                'prixParticipation' => 1000,
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);
        $data = json_decode($data['reponse_offre'], true);
        $id = $data['id'];

        // Suppression de la réponse
        $client->request('DELETE', "/api/v1/reponse/delete/{$id}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $deleteResponse = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals('Réponse supprimée', $deleteResponse['message']);
    }
}
