<?php

namespace App\Services;

use App\Entity\BudgetEstimatif;
use App\Entity\Concerner;
use App\Entity\ConditionsFinancieres;
use App\Entity\Creer;
use App\Entity\EtatOffre;
use App\Entity\Extras;
use App\Entity\FicheTechniqueArtiste;
use App\Entity\Rattacher;
use App\Entity\TypeOffre;
use App\Entity\Offre;
use App\Entity\Poster;
use App\Repository\OffreRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\CreerRepository;
use App\Repository\ReseauRepository;
use App\Repository\PosterRepository;
use App\Repository\GenreMusicalRepository;
use App\Repository\RattacherRepository;
use App\Repository\ArtisteRepository;
use App\Repository\ConcernerRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OffreService
 * Est le gestionnaire des offres (gestion de la logique métier)
 */
class OffreService
{
    /**
     * Récupère toutes les offres et renvoie une réponse JSON.
     *
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les offres.
     */
    public static function getOffres(
        OffreRepository $offreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $Offres = $offreRepository->findAll();
        $OffresJSON = $serializer->serialize($Offres, 'json');
        return new JsonResponse([
            'Offres' => $OffresJSON,
            'serialized' => true
        ], Response::HTTP_OK, ['Access-Control-Allow-Origin' => '*']);
    }

    /**
     * Crée une nouvelle offre et renvoie une réponse JSON.
     *
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données de l'offre à créer.
     *
     * @return JsonResponse La réponse JSON après la création de l'offre.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création de l'offre.
     */
    public static function createOffre(
        OffreRepository $offreRepository,
        UtilisateurRepository $utilisateurRepository,
        CreerRepository $creerRepository,
        ReseauRepository $reseauRepository,
        PosterRepository $posterRepository,
        RattacherRepository $rattacherRepository,
        GenreMusicalRepository $genreMusicalRepository,
        ArtisteRepository $artisteRepository,
        ConcernerRepository $concernerRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // vérifie qu'aucune donnée ne manque pour la création de l'offre
            if (
                (
                empty($data['detailOffre']['titleOffre']) &&
                empty($data['detailOffre']['deadLine']) &&
                empty($data['detailOffre']['descrTournee']) &&
                empty($data['detailOffre']['dateMinProposee']) &&
                empty($data['detailOffre']['dateMaxProposee']) &&
                empty($data['detailOffre']['villeVisee']) &&
                empty($data['detailOffre']['regionVisee']) &&
                empty($data['detailOffre']['placesMin']) &&
                empty($data['detailOffre']['placesMax']) &&
                empty($data['detailOffre']['nbArtistesConcernes']) &&
                empty($data['detailOffre']['nbInvitesConcernes']) &&
                empty($data['detailOffre']['liensPromotionnels']) &&
                empty($data['extras']) &&
                empty($data['etatOffre']) &&
                empty($data['typeOffre']) &&
                empty($data['conditionsFinancieres']) &&
                empty($data['budgetEstimatif']) &&
                empty($data['donneesSupplementaires']['ficheTechniqueArtiste']) &&
                empty($data['utilisateur']) &&
                empty($data['donneesSupplementaires']['reseau']) &&
                empty($data['donneesSupplementaires']['genreMusical']) &&
                empty($data['donneesSupplementaires']['artiste'])
                )
            ) {
                throw new \InvalidArgumentException("L'offre n'est pas complète.");
            }

            // création de l'objet et instanciation des données de l'objet
            $offre = new Offre();
            $offre->setTitleOffre($data['detailOffre']['titleOffre']);
            $offre->setDeadLine(date_create($data['detailOffre']['deadLine']));
            $offre->setDescrTournee($data['detailOffre']['descrTournee']);
            $offre->setDateMinProposee(date_create($data['detailOffre']['dateMinProposee']));
            $offre->setDateMaxProposee(date_create($data['detailOffre']['dateMaxProposee']));
            $offre->setVilleVisee($data['detailOffre']['villeVisee']);
            $offre->setRegionVisee($data['detailOffre']['regionVisee']);
            $offre->setPlacesMin(intval($data['detailOffre']['placesMin']));
            $offre->setPlacesMax(intval($data['detailOffre']['placesMax']));
            $offre->setNbArtistesConcernes(intval($data['detailOffre']['nbArtistesConcernes']));
            $offre->setNbInvitesConcernes(intval($data['detailOffre']['nbInvitesConcernes']));
            $offre->setLiensPromotionnels($data['detailOffre']['liensPromotionnels']);

            $extras = new Extras();
            $extras->setDescrExtras($data['extras']['descrExtras']);
            $extras->setCoutExtras(intval($data['extras']['coutExtras']));
            $extras->setExclusivite($data['extras']['exclusivite']);
            $extras->setException($data['extras']['exception']);
            $extras->setOrdrePassage($data['extras']['ordrePassage']);
            $extras->setClausesConfidentialites($data['extras']['clausesConfidentialites']);
            $offre->setExtras($extras);

            $etatOffre = new EtatOffre();
            $etatOffre->setNomEtat($data['etatOffre']['nomEtatOffre']);
            $offre->setEtatOffre($etatOffre);

            $typeOffre = new TypeOffre();
            $typeOffre->setNomTypeOffre($data['typeOffre']['nomTypeOffre']);
            $offre->setTypeOffre($typeOffre);

            $conditionsFinancieres = new ConditionsFinancieres();
            $conditionsFinancieres->setMinimunGaranti(intval($data['conditionsFinancieres']['minimumGaranti']));
            $conditionsFinancieres->setConditionsPaiement($data['conditionsFinancieres']['conditionsPaiement']);
            $conditionsFinancieres->setPourcentageRecette(floatval($data['conditionsFinancieres']['pourcentageRecette']));
            $offre->setConditionsFinancieres($conditionsFinancieres);

            $budgetEstimatif = new BudgetEstimatif();
            $budgetEstimatif->setCachetArtiste(intval($data['budgetEstimatif']['cachetArtiste']));
            $budgetEstimatif->setFraisDeplacement(intval($data['budgetEstimatif']['fraisDeplacement']));
            $budgetEstimatif->setFraisHebergement(intval($data['budgetEstimatif']['fraisHebergement']));
            $budgetEstimatif->setFraisRestauration(intval($data['budgetEstimatif']['fraisRestauration']));
            $offre->setBudgetEstimatif($budgetEstimatif);

            $ficheTechniqueArtiste = new FicheTechniqueArtiste();
            $ficheTechniqueArtiste->setBesoinBackline($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinBackline']);
            $ficheTechniqueArtiste->setBesoinEclairage($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinEclairage']);
            $ficheTechniqueArtiste->setBesoinEquipements($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinEquipements']);
            $ficheTechniqueArtiste->setBesoinScene($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinScene']);
            $ficheTechniqueArtiste->setBesoinSonorisation($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinSonorisation']);
            $offre->setFicheTechniqueArtiste($ficheTechniqueArtiste);

            // ajout de l'offre en base de données
            $rep = $offreRepository->inscritOffre($offre);

            // création de l'objet de l'utilisateur qui a mit en ligne l'offre
            $utilisateur = $utilisateurRepository->trouveUtilisateurByUsername($data['utilisateur']['username']);
            print_r($utilisateur);
            $creer = new Creer();
            $creer->setContact($data['utilisateur']['contact']);
            $creer->setIdUtilisateur($utilisateur[0]);
            $creer->setIdOffre($offre);
            $creerRepository->ajouterCreer($creer);

            // ajoute l'offre sur le ou les réseau(x) indiqués
            $nb_reseaux = intval($data['donneesSupplementaires']['nbReseaux']);
            print_r($nb_reseaux);
            for ($i = 0; $i < $nb_reseaux; $i++) {
                $reseau = $reseauRepository->trouveReseauByName($data['donneesSupplementaires']['reseau'][$i]);
                print_r($reseau);
                $poster = new Poster();
                $poster->setIdOffre($offre);
                $poster->setIdReseau($reseau[0]);
                $posterRepository->inscritPoster($poster);
            }

            $nb_genres_musicaux = intval($data['donneesSupplementaires']['nbGenresMusicaux']);
            for ($i = 0; $i < $nb_genres_musicaux; $i++) {
                $genreMusical = $genreMusicalRepository->trouveGenreMusicalByName($data['donneesSupplementaires']['genreMusical'][$i]);
                print_r($genreMusical);
                $rattacher = new Rattacher();
                $rattacher->setIdOffre($offre);
                $rattacher->setIdGenreMusical($genreMusical[0]);
                $rattacherRepository->ajouterRattacher($rattacher);
            }

            $nb_artistes = intval($data['donneesSupplementaires']['nbArtistes']);
            for ($i = 0; $i < $nb_artistes; $i++) {
                $artiste = $artisteRepository->trouveArtisteByName($data['donneesSupplementaires']['artiste'][$i]);
                print_r($artiste);
                $concerner = new Concerner();
                $concerner->setIdOffre($offre);
                $concerner->setIdArtiste($artiste[0]);
                $concernerRepository->ajouterConcerner($concerner);
            }


            // vérification de l'action en BDD
            if ($rep) {
                $offreJSON = $serializer->serialize($offre, 'json');
                return new JsonResponse([
                    'offre' => $offreJSON,
                    'message' => "Offre inscrite !",
                    'serialized' => true
                ]);
            }
            return new JsonResponse([
                'offre' => null,
                'message' => "Offre non inscrite, merci de regarder l'erreur décrite",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST, ['Access-Control-Allow-Origin' => '*']);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création de l'offre", $e->getMessage());
        }
    }

    /**
     * Met à jour une offre existante et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'offre à mettre à jour.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données de l'offre.
     *
     * @return JsonResponse La réponse JSON après la mise à jour de l'offre.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour de l'offre.
     */
    public static function updateOffre(
        int $id,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération de l'offre
            $offre = $offreRepository->find($id);

            // si il n'y pas d'offre trouvé
            if ($offre == null) {
                return new JsonResponse([
                    'offre' => null,
                    'message' => 'offre non trouvée, merci de donner un identifiant valide !',
                    'reponse' => Response::HTTP_NOT_FOUND,
                    'serialized' => true
                ]);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['titleOffre'])) {
                $offre->setTitleOffre($data['titleOffre']);
            }
            if (isset($data['deadline'])) {
                $offre->setDeadline($data['deadline']);
            }
            if (isset($data['descrTournee'])) {
                $offre->setDescrTournee($data['descrTournee']);
            }
            if (isset($data['dateMinProposee'])) {
                $offre->setDateMinProposee($data['dateMinProposee']);
            }
            if (isset($data['dateMaxProposee'])) {
                $offre->setDateMaxProposee($data['dateMaxProposee']);
            }
            if (isset($data['villeVisee'])) {
                $offre->setVilleVisee($data['villeVisee']);
            }
            if (isset($data['regionVisee'])) {
                $offre->setRegionVisee($data['regionVisee']);
            }
            if (isset($data['placesMin'])) {
                $offre->setPlacesMin($data['placesMin']);
            }
            if (isset($data['placesMax'])) {
                $offre->setPlacesMax($data['placesMax']);
            }
            if (isset($data['nbArtistesConcernes'])) {
                $offre->setNbArtistesConcernes($data['nbArtistesConcernes']);
            }
            if (isset($data['nbInvitesConcernes'])) {
                $offre->setNbInvitesConcernes($data['nbInvitesConcernes']);
            }
            if (isset($data['liensPromotionnels'])) {
                $offre->setLiensPromotionnels($data['liensPromotionnels']);
            }
            if (isset($data['etatOffre'])) {
                $etatOffre = new EtatOffre();
                if (isset($data['etatOffre']['nomEtatOffre'])) {
                    $etatOffre->setNomEtat($data['etatOffre']['nomEtatOffre']);
                }
                $offre->setExtras($etatOffre);
            }
            if (isset($data['typeOffre'])) {
                $typeOffre = new TypeOffre();
                if (isset($data['typeOffre']['nomTypeOffre'])) {
                    $typeOffre->setNomTypeOffre($data['typeOffre']['nomTypeOffre']);
                }
                $offre->setExtras($typeOffre);
            }
            if (isset($data['conditionFinancieres'])) {
                $conditionsFinancieres = new ConditionsFinancieres();
                if (isset($data['conditionsFinancieres']['minimumGaranti'])) {
                    $conditionsFinancieres->setMinimunGaranti($data['conditionsFinancieres']['minimumGaranti']);
                }
                if (isset($data['conditionsFinancieres']['conditionsPaiement'])) {
                    $conditionsFinancieres->setConditionsPaiement($data['conditionsFinancieres']['conditionsPaiement']);
                }
                if (isset($data['conditionsFinancieres']['pourcentageRecette'])) {
                    $conditionsFinancieres->setPourcentageRecette($data['conditionsFinancieres']['pourcentageRecette']);
                }
                $offre->setConditionsFinancieres($conditionsFinancieres);
            }
            if (isset($data['budgetEstimatif'])) {
                $budgetEstimatif = new BudgetEstimatif();
                if (isset($data['budgetEstimatif']['cachetArtiste'])) {
                    $budgetEstimatif->setCachetArtiste($data['budgetEstimatif']['cachetArtiste']);
                }
                if (isset($data['budgetEstimatif']['fraisDeplacement'])) {
                    $budgetEstimatif->setFraisDeplacement($data['budgetEstimatif']['fraisDeplacement']);
                }
                if (isset($data['budgetEstimatif']['fraisHebergement'])) {
                    $budgetEstimatif->setFraisHebergement($data['budgetEstimatif']['fraisHebergement']);
                }
                if (isset($data['budgetEstimatif']['fraisRestauration'])) {
                    $budgetEstimatif->setFraisRestauration($data['budgetEstimatif']['fraisRestauration']);
                }
                $offre->setBudgetEstimatif($budgetEstimatif);
            }
            if (isset($data['donneesSupplementaires']['ficheTechniqueArtiste'])) {
                $ficheTechniqueArtiste = new FicheTechniqueArtiste();
                if (isset($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinBackline'])) {
                    $ficheTechniqueArtiste->setBesoinBackline($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinBackline']);
                }
                if (isset($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinEclairage'])) {
                    $ficheTechniqueArtiste->setBesoinEclairage($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinEclairage']);
                }
                if (isset($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinEquipements'])) {
                    $ficheTechniqueArtiste->setBesoinEquipements($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinEquipements']);
                }
                if (isset($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinScene'])) {
                    $ficheTechniqueArtiste->setBesoinScene($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinScene']);
                }
                if (isset($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinSonorisation'])) {
                    $ficheTechniqueArtiste->setBesoinSonorisation($data['donneesSupplementaires']['ficheTechniqueArtiste']['besoinSonorisation']);
                }
                $offre->setFicheTechniqueArtiste($ficheTechniqueArtiste);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $offreRepository->updateOffre($offre);

            // si l'action à réussi
            if ($rep) {
                $offreJSON = $serializer->serialize($offre, 'json');

                return new JsonResponse([
                    'offre' => $offreJSON,
                    'message' => "Offre modifiée avec succès",
                    'reponse' => Response::HTTP_OK,
                    'serialized' => true
                ]);
            } else {
                return new JsonResponse([
                    'offre' => null,
                    'message' => "Offre non modifiée, merci de vérifier l'erreur décrite",
                    'reponse' => Response::HTTP_BAD_REQUEST,
                    'serialized' => false
                ]);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour de l'offre", $e->getMessage());
        }
    }

    /**
     * Supprime une offre et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'offre à supprimer.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'offre.
     */
    public static function deleteOffre(
        int $id,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre à supprimer
        $offre = $offreRepository->find($id);

        // si pas d'offre trouvé
        if ($offre == null) {
            return new JsonResponse([
                'offre' => null,
                'message' => 'offre non trouvée, merci de fournir un identifiant valide',
                'reponse' => Response::HTTP_NOT_FOUND,
                'serialized' => false
            ]);
        }

        // suppression de l'offre en BDD
        $rep = $offreRepository->removeOffre($offre);

        // si l'action à réussi
        if ($rep) {
            $offreJSON = $serializer->serialize($offre, 'json');
            return new JsonResponse([
                'offre' => $offreJSON,
                'message' => 'offre supprimée',
                'reponse' => Response::HTTP_NO_CONTENT,
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'offre' => null,
                'message' => 'offre non supprimée !',
                'reponse' => Response::HTTP_BAD_REQUEST,
                'serialized' => false
            ]);
        }
    }

    /**
     * Ajoute artiste correpondant à l'offre et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour ajouter un artiste correpondant à l'offre.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param ArtisteRepository $artisteRepository Le repository des artistes.
     * @param ConcernerRepository $concernerRepository Le repository des artistes qui sont concernés par des offres
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives d'ajout d'artiste correpondant à l'offre.
     */
    public static function ajouteArtisteOffre(
        mixed $data,
        OffreRepository $offreRepository,
        ArtisteRepository $artisteRepository,
        ConcernerRepository $concernerRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et de l'artiste ciblés
        $offre = $offreRepository->find($data['idOffre']);
        $artiste = $artisteRepository->find($data['idArtiste']);

        // si pas d'offre ou d'artiste trouvé
        if ($offre == null || $artiste == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Artiste ou offre non trouvés, merci de fournir des identifiants valides',
                'reponse' => Response::HTTP_NOT_FOUND,
                'serialized' => false
            ]);
        }

        // ajout de l'objet en BDD
        $concerner = new Concerner();
        $concerner->setIdOffre($offre);
        $concerner->setIdArtiste($artiste);
        $rep = $concernerRepository->ajouterConcerner($concerner);

        // si l'action à réussi
        if ($rep) {
            $concernerJSON = $serializer->serialize($concerner, 'json');
            return new JsonResponse([
                'concerner' => $concernerJSON,
                'message' => "Artiste ajouté à l'offre.",
                'reponse' => Response::HTTP_NO_CONTENT,
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'concerner' => null,
                'message' => "Artiste non ajouté au à l'offre !",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'serialized' => false
            ]);
        }
    }

    /**
     * Retire un artiste de l'offre et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour retirer un artiste de l'offre.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param ArtisteRepository $artisteRepository Le repository des utilisateurs.
     * @param ConcernerRepository $concernerRepository Le repository des appartenance.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives de retrait d'un artiste de l'offre.
     */
    public static function retireArtisteOffre(
        mixed $data,
        OffreRepository $offreRepository,
        ArtisteRepository $artisteRepository,
        ConcernerRepository $concernerRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et de l'artiste ciblés
        $offre = $offreRepository->find($data['idOffre']);
        $artiste = $artisteRepository->find($data['idArtiste']);

        if ($offre == null || $artiste == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Artiste ou offre non trouvés, merci de fournir des identifiants valides',
                'reponse' => Response::HTTP_NOT_FOUND,
                'serialized' => false
            ]);
        }

        // ajout de l'objet en BDD
        $concerner = new Concerner();
        $concerner->setIdOffre($offre);
        $concerner->setIdArtiste($artiste);
        $rep = $concernerRepository->supprimerConcerner($concerner);

        // si l'action à réussi
        if ($rep) {
            $concernerJSON = $serializer->serialize($concerner, 'json');
            return new JsonResponse([
                'concerner' => $concernerJSON,
                'message' => "Artiste supprimé de l'offre.",
                'reponse' => Response::HTTP_NO_CONTENT,
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'concerner' => null,
                'message' => "Artiste non supprimé de l'offre !",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'serialized' => false
            ]);
        }
    }

    /**
     * Ajoute un genre musical à l'offre et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour ajouter un genre à l'offre.
     * @param OffreRepository $offreRepository Le repository des offres.
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param RattacherRepository $rattacherRepository Le repository des rattachements.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives d'ajout d'un genre musical à l'offre.
     */
    public static function ajouteGenreMusicalReseau(
        mixed $data,
        OffreRepository $offreRepository,
        GenreMusicalRepository $genreMusicalRepository,
        RattacherRepository $rattacherRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et du genre musical ciblés
        $offre = $offreRepository->find($data['idOffre']);
        $genreMusical = $genreMusicalRepository->find($data['idGenreMusical']);

        // si pas d'offre ou genre musical trouvé
        if ($offre == null || $genreMusical == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Offre ou genre musical non trouvé, merci de fournir un identifiant valide',
                'reponse' => Response::HTTP_NOT_FOUND,
                'serialized' => false
            ]);
        }

        // ajout de l'objet en BDD
        $rattacher = new Rattacher();
        $rattacher->setIdGenreMusical($genreMusical);
        $rattacher->setIdOffre($offre);
        $rep = $rattacherRepository->ajouterRattacher($rattacher);

        // si l'action à réussi
        if ($rep) {
            $rattacherJSON = $serializer->serialize($rattacher, 'json');
            return new JsonResponse([
                'rattacher' => $rattacherJSON,
                'message' => "Genre musical rattaché à l'offre",
                'reponse' => Response::HTTP_NO_CONTENT,
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'rattacher' => null,
                'message' => "Genre musical non rattaché à l'offre !",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'serialized' => false
            ]);
        }
    }

    /**
     * Retire un genre musical du réseau et renvoie une réponse JSON.
     *
     * @param mixed $data Les données requises pour retirer un genre du réseau.
     * @param OffreRepository $offreRepository Le repository des réseaux.
     * @param GenreMusicalRepository $genreMusicalRepository Le repository des genres musicaux.
     * @param RattacherRepository $rattacherRepository Le repository des liaisons.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après tentatives de retrait d'un genre musical du réseau.
     */
    public static function retireGenreMusicalReseau(
        mixed $data,
        OffreRepository $offreRepository,
        GenreMusicalRepository $genreMusicalRepository,
        RattacherRepository $rattacherRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'offre et du genre musical ciblés
        $offre = $offreRepository->find($data['idOffre']);
        $genreMusical = $genreMusicalRepository->find($data['idGenreMusical']);

        // si pas d'offre ou genre musical trouvé
        if ($offre == null || $genreMusical == null) {
            return new JsonResponse([
                'object' => null,
                'message' => 'Offre ou genre musical non trouvé, merci de fournir un identifiant valide',
                'reponse' => Response::HTTP_NOT_FOUND,
                'serialized' => false
            ]);
        }

        // ajout de l'objet en BDD
        $rattacher = new Rattacher();
        $rattacher->setIdGenreMusical($genreMusical);
        $rattacher->setIdOffre($offre);
        $rep = $rattacherRepository->supprimerRattacher($rattacher);

        // si l'action à réussi
        if ($rep) {
            $rattacherJSON = $serializer->serialize($rattacher, 'json');
            return new JsonResponse([
                'rattacher' => $rattacherJSON,
                'message' => "Genre musical supprimé de l'offre",
                'reponse' => Response::HTTP_NO_CONTENT,
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'rattacher' => null,
                'message' => "Genre musical non supprimé de l'offre !",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'serialized' => false
            ]);
        }
    }
}
