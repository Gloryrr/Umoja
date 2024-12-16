<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class CommentaireEndPointsTest extends ApiTestCase
{
    public string $token;

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

    public function testGetCommentaires(): void
    {
        $client = static::createClient();

        $response = $client->request('GET', '/api/v1/commentaires', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJson($response->getContent());
    }

    public function testCreateCommentaire(): void
    {
        $client = static::createClient();

        // Création d'une offre
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

        // Récupération des données de l'offre créée
        $offreResponse = json_decode($client->getResponse()->getContent(), true);

        // decode de la reponse pour recuperer l'id de l'offre
        $offreResponse = json_decode($offreResponse['offre'], true);
        $idOffre = $offreResponse['id']; // Supposons que la réponse inclut un champ `id`.


        $client->request('POST', '/api/v1/commentaire/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'commentaire' => [
                    'idOffre' => $idOffre,
                    'username' => 'admin',
                    'contenu' => 'Un commentaire de test.'
                ]
            ],
        ]);

        // récupération des données renvoyées
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $responseData = json_decode($responseData['commentaire'], true);

        print_r($responseData);
        $this->assertEquals($responseData['offre']['id'], $idOffre);
        $this->assertEquals($responseData['utilisateur']['username'], 'admin');
        $this->assertEquals($responseData['commentaire'], 'Un commentaire de test.');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
    }

    public function testGetCommentaireById(): void
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

        // Récupération des données de l'offre créée
        $offreResponse = json_decode($client->getResponse()->getContent(), true);

        // decode de la reponse pour recuperer l'id de l'offre
        $offreResponse = json_decode($offreResponse['offre'], true);
        $idOffre = $offreResponse['id']; // Supposons que la réponse inclut un champ `id`.

        // Créez un artiste pour le test
        $client->request('POST', '/api/v1/commentaire/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'commentaire' => [
                    'idOffre' => $idOffre,
                    'username' => 'admin',
                    'contenu' => 'Un commentaire de test.'
                ]
            ],
        ]);

        $this->assertResponseIsSuccessful();

        // Décodez la réponse JSON contenant le commentaire
        $responseData = json_decode($client->getResponse()->getContent(), true);

        // Le commentaire est une chaîne JSON, donc nous devons la décoder
        $commentaire = json_decode($responseData['commentaire'], true);

        // Récupérer l'ID du commentaire
        $commentaireId = $commentaire['id'];

        // Teste le GET par ID avec le token dans les en-têtes
        $client->request('GET', "/api/v1/commentaire/{$commentaireId}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $responseData = json_decode($responseData['commentaires'], true);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertEquals($responseData['id'], $commentaireId);
        $this->assertEquals($responseData['commentaire'], 'Un commentaire de test.');
    }

    public function testUpdateCommentaire(): void
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

        // Récupération des données de l'offre créée
        $offreResponse = json_decode($client->getResponse()->getContent(), true);

        // decode de la reponse pour recuperer l'id de l'offre
        $offreResponse = json_decode($offreResponse['offre'], true);
        $idOffre = $offreResponse['id']; // Supposons que la réponse inclut un champ `id`.

        // Créez un artiste pour le test
        $client->request('POST', '/api/v1/commentaire/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'commentaire' => [
                    'idOffre' => $idOffre,
                    'username' => 'admin',
                    'contenu' => 'Un commentaire de test.'
                ]
            ],
        ]);

        $this->assertResponseIsSuccessful();

        // récupération des données renvoyées
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $responseData = json_decode($responseData['commentaire'], true);

        print_r($responseData);
        $idCommentaire = $responseData['id'];

        $client->request('PATCH', "/api/v1/commentaire/update/{$idCommentaire}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'commentaire' => [
                    'username' => 'admin',
                    'contenu' => 'Un commentaire de test modifié.'
                ]
            ],
        ]);

        $this->assertResponseIsSuccessful();

        // récupération des données renvoyées
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $responseData = json_decode($responseData['commentaire'], true);

        $this->assertEquals($responseData['commentaire'], 'Un commentaire de test modifié.');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
    }

    public function testDeleteCommentaire(): void
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

        // Récupération des données de l'offre créée
        $offreResponse = json_decode($client->getResponse()->getContent(), true);

        // decode de la reponse pour recuperer l'id de l'offre
        $offreResponse = json_decode($offreResponse['offre'], true);
        $idOffre = $offreResponse['id']; // Supposons que la réponse inclut un champ `id`.

        // Créez un commentaire pour le test
        $client->request('POST', '/api/v1/commentaire/create', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ],
            'json' => [
                'commentaire' => [
                    'idOffre' => $idOffre,
                    'username' => 'admin',
                    'contenu' => 'Un commentaire de test.'
                ]
            ],
        ]);

        $this->assertResponseIsSuccessful();

        // récupération des données renvoyées
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $responseData = json_decode($responseData['commentaire'], true);

        $idCommentaire = $responseData['id'];

        // On supprime l'artiste maintenant
        $client->request('DELETE', "/api/v1/commentaire/delete/{$idCommentaire}", [
            'headers' => [
                'Authorization' => "Bearer {$this->token}"
            ]
        ]);

        // récupération des données de l'artiste supprimé
        $responseData = json_decode($client->getResponse()->getContent(), true);
        // vérification de la réponse, les données doivent être les données envoyées par JSON
        $responseData = json_decode($responseData['commentaire'], true);

        $this->assertEquals($responseData['commentaire'], 'Un commentaire de test.');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
    }
}
