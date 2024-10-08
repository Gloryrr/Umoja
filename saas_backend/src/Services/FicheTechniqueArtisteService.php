<?php

namespace App\Services;

use App\DTO\FicheTechniqueArtisteDTO;
use App\Entity\Preferencer;
use App\Repository\GenreMusicalRepository;
use App\Repository\PreferencerRepository;
use App\Repository\FicheTechniqueArtisteRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\FicheTechniqueArtiste;

/**
 * Class FicheTechniqueArtisteService
 * Est le gestionnaire des fiches techniques des artistes (gestion de la logique métier)
 */
class FicheTechniqueArtisteService
{
    /**
     * Récupère toutes les fiches techniques des artistes et renvoie une réponse JSON.
     *
     * @param FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository, le repository des fiches techniques.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les fiches techniques des artistes.
     */
    public static function getFichesTechniquesArtiste(
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère toutes les fiches techniques
        $fichesTechniquesArtiste = $ficheTechniqueArtisteRepository->findAll();
        $arrayFichesTechniquesArtisteDTO = [];
        foreach ($fichesTechniquesArtiste as $indFT => $ficheTechniqueArtiste) {
            $ficheTechniqueArtisteDTO = new FicheTechniqueArtisteDTO(
                $ficheTechniqueArtiste->getIdFT(),
                $ficheTechniqueArtiste->getBesoinSonorisation(),
                $ficheTechniqueArtiste->getBesoinEclairage(),
                $ficheTechniqueArtiste->getBesoinScene(),
                $ficheTechniqueArtiste->getBesoinBackline(),
                $ficheTechniqueArtiste->getBesoinEquipements()
            );

            array_push($arrayFichesTechniquesArtisteDTO, $ficheTechniqueArtisteDTO);
        }

        $fichesTechniquesArtisteJSON = $serializer->serialize($arrayFichesTechniquesArtisteDTO, 'json');
        return new JsonResponse([
            'fiches_techniques_artistes' => $fichesTechniquesArtisteJSON,
            'message' => "Liste des fiches techniques des artistes",
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Créer une nouvelle fiche technique d'artiste et renvoie une réponse JSON.
     *
     * @param FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository Le repository des fiches techniques.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données de la fiche technique à créer.
     *
     * @return JsonResponse La réponse JSON après la création de la fiche technique.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création de la fiche technique.
     */
    public static function createFicheTechniqueArtiste(
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // création de l'objet et instanciation des données de l'objet
            $ficheTechniqueArtiste = new FicheTechniqueArtiste();
            $ficheTechniqueArtiste->setBesoinSonorisation(
                !(empty($data['besoinSonorisation'])) ? $data['besoinSonorisation'] : null
            );
            $ficheTechniqueArtiste->setBesoinEclairage(
                !(empty($data['besoinEclairage'])) ? $data['besoinEclairage'] : null
            );
            $ficheTechniqueArtiste->setBesoinScene(
                !(empty($data['besoinScene'])) ? $data['besoinScene'] : null
            );
            $ficheTechniqueArtiste->setBesoinBackline(
                !(empty($data['besoinBackline'])) ? $data['besoinBackline'] : null
            );
            $ficheTechniqueArtiste->setBesoinEquipements(
                !(empty($data['besoinEquipements'])) ? $data['besoinEquipements'] : null
            );

            // ajout de la fiche technique en base de données
            $rep = $ficheTechniqueArtisteRepository->inscritFicheTechniqueArtiste($ficheTechniqueArtiste);

            // vérification de l'action en BDD
            if ($rep) {
                $ficheTechniqueArtisteJSON = $serializer->serialize($ficheTechniqueArtiste, 'json');
                return new JsonResponse([
                    'fiche_technique_artiste' => $ficheTechniqueArtisteJSON,
                    'message' => "fiche technique de l'artiste inscrit !",
                    'reponse' => Response::HTTP_CREATED,
                    'headers' => [],
                    'serialized' => true
                ]);
            }
            return new JsonResponse([
                'fiche_technique_artiste' => null,
                'message' => "fiche technique de l'artiste non inscrit, merci de regarder l'erreur décrite",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création de la fiche technique", $e->getMessage());
        }
    }

    /**
     * Met à jour une fiche technique de l'artiste existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de la fiche technique à mettre à jour.
     * @param FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository Le repository des fiches techniques.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données de la fiche technique.
     *
     * @return JsonResponse La réponse JSON après la mise à jour de la fiche technique.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour de la fiche technique.
     */
    public static function updateFicheTechniqueArtiste(
        int $id,
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération de la fiche technique
            $ficheTechniqueArtiste = $ficheTechniqueArtisteRepository->find($id);

            // si il n'y pas de fiche technique trouvée
            if ($ficheTechniqueArtiste == null) {
                return new JsonResponse([
                    'fiche_technique_artiste' => null,
                    'message' => "fiche technique de l'artiste non trouvée, merci de donner un identifiant valide !",
                    'reponse' => Response::HTTP_NOT_FOUND,
                    'headers' => [],
                    'serialized' => true
                ]);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['besoinSonorisation'])) {
                $ficheTechniqueArtiste->setBesoinSonorisation($data['besoinSonorisation']);
            }
            if (isset($data['besoinEclairage'])) {
                $ficheTechniqueArtiste->setBesoinEclairage($data['besoinEclairage']);
            }
            if (isset($data['besoinScene'])) {
                $ficheTechniqueArtiste->setBesoinScene($data['besoinScene']);
            }
            if (isset($data['besoinBackline'])) {
                $ficheTechniqueArtiste->setBesoinBackline($data['besoinBackline']);
            }
            if (isset($data['setBesoinEquipements'])) {
                $ficheTechniqueArtiste->setBesoinEquipements($data['setBesoinEquipements']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $ficheTechniqueArtisteRepository->updateFicheTechniqueArtiste($ficheTechniqueArtiste);

            // si l'action à réussi
            if ($rep) {
                $ficheTechniqueArtisteJSON = $serializer->serialize($ficheTechniqueArtiste, 'json');

                return new JsonResponse([
                    'fiche_technique_artiste' => $ficheTechniqueArtisteJSON,
                    'message' => "fiche technique de l'artiste modifiée avec succès",
                    'reponse' => Response::HTTP_OK,
                    'headers' => [],
                    'serialized' => true
                ]);
            } else {
                return new JsonResponse([
                    'fiche_technique_artiste' => null,
                    'message' => "fiche technique de l'artiste non modifiée, merci de vérifier l'erreur décrite",
                    'reponse' => Response::HTTP_BAD_REQUEST,
                    'headers' => [],
                    'serialized' => false
                ]);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour de la fiche technique", $e->getMessage());
        }
    }

    /**
     * Supprime une fiche technique de l'artiste et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de la fiche technique à supprimer.
     * @param FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository Le repository des fiches techniques.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de la fiche technique.
     */
    public static function deleteFicheTechniqueArtiste(
        int $id,
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de la fiche technique à supprimer
        $ficheTechniqueArtiste = $ficheTechniqueArtisteRepository->find($id);

        // si pas de fiche technique trouvée
        if ($ficheTechniqueArtiste == null) {
            return new JsonResponse([
                'fiche_technique_artiste' => null,
                'message' => "fiche technique de l'artiste non trouvée, merci de fournir un identifiant valide",
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // suppression de la fiche technique en BDD
        $rep = $ficheTechniqueArtisteRepository->removeFicheTechniqueArtiste($ficheTechniqueArtiste);

        // si l'action à réussi
        if ($rep) {
            $ficheTechniqueArtisteJSON = $serializer->serialize($ficheTechniqueArtiste, 'json');
            return new JsonResponse([
                'fiche_technique_artiste' => $ficheTechniqueArtisteJSON,
                'message' => "fiche technique de l'artiste supprimé",
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'fiche_technique_artiste' => null,
                'message' => "fiche technique de l'artiste non supprimé !",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        }
    }
}
