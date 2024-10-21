<?php

namespace App\Services;

use App\Repository\EtatReponseRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\EtatReponse;

/**
 * Class EtatReponseService
 * Est le gestionnaire des états de réponse (gestion de la logique métier)
 */
class EtatReponseService
{
    /**
     * Récupère tous les états de réponse et renvoie une réponse JSON.
     *
     * @param EtatReponseRepository $etatReponseRepository Le repository des états de réponse.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les états de réponse.
     */
    public static function getEtatsReponse(
        EtatReponseRepository $etatReponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les états
        $etatsReponse = $etatReponseRepository->findAll();
        $etatsReponseJSON = $serializer->serialize($etatsReponse, 'json');
        return new JsonResponse([
            'etats_reponse' => $etatsReponseJSON,
            'message' => "Liste des états de réponse",
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Crée un nouvel état de réponse et renvoie une réponse JSON.
     *
     * @param EtatReponseRepository $etatReponseRepository Le repository des états de réponse.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données de l'état de réponse à créer.
     *
     * @return JsonResponse La réponse JSON après la création de l'état de réponse.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création de l'état.
     */
    public static function createEtatReponse(
        EtatReponseRepository $etatReponseRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // vérifie qu'aucune donnée ne manque pour la création de l'état
            if (empty($data['nomEtatReponse'])) {
                throw new \InvalidArgumentException("Le nom de l'état de réponse est requis.");
            }

            // création de l'objet et instanciation des données de l'objet
            $etatReponse = new EtatReponse();
            $etatReponse->setNomEtatReponse($data['nomEtatReponse']);
            $etatReponse->setDescriptionEtatReponse($data['descriptionEtatReponse'] ?? '');

            // ajout du nouvel état en base de données
            $rep = $etatReponseRepository->ajouterEtatReponse($etatReponse);

            // vérification de l'action en BDD
            if ($rep) {
                $etatReponseJSON = $serializer->serialize($etatReponse, 'json');
                return new JsonResponse([
                    'etat_reponse' => $etatReponseJSON,
                    'message' => "État de réponse ajouté !",
                    'reponse' => Response::HTTP_CREATED,
                    'headers' => [],
                    'serialized' => true
                ]);
            }
            return new JsonResponse([
                'etat_reponse' => null,
                'message' => "État de réponse non inscrit, merci de vérifier l'erreur décrite",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création de l'état de réponse", $e->getCode());
        }
    }

    /**
     * Met à jour un état de réponse existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'état de réponse à mettre à jour.
     * @param EtatReponseRepository $etatReponseRepository Le repository des états de réponse.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données de l'état de réponse.
     *
     * @return JsonResponse La réponse JSON après la mise à jour de l'état de réponse.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour de l'état de réponse.
     */
    public static function updateEtatReponse(
        int $id,
        EtatReponseRepository $etatReponseRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération de l'état
            $etatReponse = $etatReponseRepository->find($id);

            // si pas trouvé
            if ($etatReponse == null) {
                return new JsonResponse([
                    'etat_reponse' => null,
                    'message' => "État de réponse non trouvé, merci de donner un identifiant valide !",
                    'reponse' => Response::HTTP_NOT_FOUND,
                    'headers' => [],
                    'serialized' => true
                ]);
            }

            // mise à jour des données
            if (isset($data['nomEtatReponse'])) {
                $etatReponse->setNomEtatReponse($data['nomEtatReponse']);
            }
            if (isset($data['descriptionEtatReponse'])) {
                $etatReponse->setDescriptionEtatReponse($data['descriptionEtatReponse']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $etatReponseRepository->modifierEtatReponse($etatReponse);

            // réponse après la mise à jour
            if ($rep) {
                $etatReponse = $serializer->serialize($etatReponse, 'json');
                return new JsonResponse([
                    'etat_reponse' => $etatReponse,
                    'message' => "État de réponse modifié avec succès",
                    'reponse' => Response::HTTP_OK,
                    'headers' => [],
                    'serialized' => true
                ]);
            } else {
                return new JsonResponse([
                    'etat_reponse' => null,
                    'message' => "État de réponse non modifié, merci de vérifier l'erreur décrite",
                    'reponse' => Response::HTTP_BAD_REQUEST,
                    'headers' => [],
                    'serialized' => false
                ]);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour de l'état de réponse", $e->getCode());
        }
    }

    /**
     * Supprime un état de réponse et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'état de réponse à supprimer.
     * @param EtatReponseRepository $etatReponseRepository Le repository des états de réponse.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'état de réponse.
     */
    public static function deleteEtatReponse(
        int $id,
        EtatReponseRepository $etatReponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // récupération de l'état de réponse à supprimer
        $etatReponse = $etatReponseRepository->find($id);

        // si pas trouvé
        if ($etatReponse == null) {
            return new JsonResponse([
                'etat_reponse' => null,
                'message' => "État de réponse non trouvé, merci de fournir un identifiant valide",
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // suppression en BDD
        $rep = $etatReponseRepository->supprimerEtatReponse($etatReponse);

        // réponse après suppression
        if ($rep) {
            $etatReponseJSON = $serializer->serialize($etatReponse, 'json');
            return new JsonResponse([
                'etat_reponse' => $etatReponseJSON,
                'message' => "État de réponse supprimé",
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'etat_reponse' => null,
                'message' => "État de réponse non supprimé !",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        }
    }
}