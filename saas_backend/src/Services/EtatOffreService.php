<?php

namespace App\Services;

use App\Repository\EtatOffreRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\EtatOffre;

/**
 * Class EtatOffreService
 * Est le gestionnaire des états d'offre (gestion de la logique métier)
 */
class EtatOffreService
{
    /**
     * Récupère toutes les états d'offre et renvoie une réponse JSON.
     *
     * @param EtatOffreRepository $etatOffreRepository Le repository des états d'offre.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les états d'offre.
     */
    public static function getEtatsOffre(
        EtatOffreRepository $etatOffreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les états
        $etatsOffre = $etatOffreRepository->findAll();
        $etatsOffreJSON = $serializer->serialize($etatsOffre, 'json');
        return new JsonResponse([
            'etats_offre' => $etatsOffreJSON,
            'message' => "Liste des états d'offre",
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Crée un nouvel état d'offre et renvoie une réponse JSON.
     *
     * @param EtatOffreRepository $etatOffreRepository Le repository des états d'offre.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données de l'état d'offre à créer.
     *
     * @return JsonResponse La réponse JSON après la création de l'état d'offre.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création de l'état.
     */
    public static function createEtatOffre(
        EtatOffreRepository $etatOffreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // vérifie qu'aucune donnée ne manque pour la création de l'état
            if (empty($data['nomEtat'])) {
                throw new \InvalidArgumentException("Le nom de l'état d'offre est requis.");
            }

            // création de l'objet et instanciation des données de l'objet
            $etatOffre = new EtatOffre();
            $etatOffre->setNomEtat($data['nomEtat']);

            // ajout du nouvel état en base de données
            $rep = $etatOffreRepository->inscritEtatOffre($etatOffre);

            // vérification de l'action en BDD
            if ($rep) {
                $etatOffreJSON = $serializer->serialize($etatOffre, 'json');
                return new JsonResponse([
                    'genre_musical' => $etatOffreJSON,
                    'message' => "Etat d'offre ajoutée !",
                    'reponse' => Response::HTTP_CREATED,
                    'headers' => [],
                    'serialized' => true
                ]);
            }
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "Etat d'offre non inscrit, merci de regarder l'erreur décrite",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création de l'état d'offre", $e->getCode());
        }
    }

    /**
     * Met à jour un état d'offre existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'état d'offre à mettre à jour.
     * @param EtatOffreRepository $etatOffreRepository Le repository des états d'offre.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données de l'état d'offre.
     *
     * @return JsonResponse La réponse JSON après la mise à jour de l'état d'offre.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour de l'état d'offre.
     */
    public static function updateEtatOffre(
        int $id,
        EtatOffreRepository $etatOffreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération de l'état
            $etatOffre = $etatOffreRepository->find($id);

            // si il n'y pas de genre trouvé
            if ($etatOffre == null) {
                return new JsonResponse([
                    'genre_musical' => null,
                    'message' => "État d'offre non trouvé, merci de donner un identifiant valide !",
                    'reponse' => Response::HTTP_NOT_FOUND,
                    'headers' => [],
                    'serialized' => true
                ]);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['nomEtat'])) {
                $etatOffre->setNomEtat($data['nomEtat']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $etatOffreRepository->updateEtatOffre($etatOffre);

            // si l'action à réussi
            if ($rep) {
                $etatOffre = $serializer->serialize($etatOffre, 'json');

                return new JsonResponse([
                    'genre_musical' => $etatOffre,
                    'message' => "État d'offre modifié avec succès",
                    'reponse' => Response::HTTP_OK,
                    'headers' => [],
                    'serialized' => true
                ]);
            } else {
                return new JsonResponse([
                    'genre_musical' => null,
                    'message' => "État d'offre non modifié, merci de vérifier l'erreur décrite",
                    'reponse' => Response::HTTP_BAD_REQUEST,
                    'headers' => [],
                    'serialized' => false
                ]);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour de l'état d'offre", $e->getCode());
        }
    }

    /**
     * Supprime un état d'offre et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'état d'offre à supprimer.
     * @param EtatOffreRepository $etatOffreRepository Le repository des états d'offre.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'état d'offre.
     */
    public static function deleteEtatOffre(
        int $id,
        EtatOffreRepository $etatOffreRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de l'état d'offre à supprimer
        $etatOffre = $etatOffreRepository->find($id);

        // si pas de état d'offre trouvé
        if ($etatOffre == null) {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "État d'offre non trouvée, merci de fournir un identifiant valide",
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // suppression de l'état d'offre en BDD
        $rep = $etatOffreRepository->removeEtatOffre($etatOffre);

        // si l'action à réussi
        if ($rep) {
            $etatOffreJSON = $serializer->serialize($etatOffre, 'json');
            return new JsonResponse([
                'genre_musical' => $etatOffreJSON,
                'message' => "État d'offre supprimée",
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "État d'offre non supprimée !",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        }
    }
}
