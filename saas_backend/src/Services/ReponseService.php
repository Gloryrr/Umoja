<?php

namespace App\Services;

use App\Repository\ReponseRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Reponse;

/**
 * Class ReponseService
 * Gestionnaire des réponses (logique métier pour les réponses).
 */
class ReponseService
{
    /**
     * Récupère toutes les réponses et renvoie une réponse JSON.
     *
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les réponses.
     */
    public static function getReponses(
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // On récupère toutes les réponses
        $reponses = $reponseRepository->findAll();
        $reponsesJSON = $serializer->serialize($reponses, 'json');
        return new JsonResponse([
            'reponses' => $reponsesJSON,
            'message' => "Liste des réponses",
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Crée une nouvelle réponse et renvoie une réponse JSON.
     *
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données de la réponse à créer.
     *
     * @return JsonResponse La réponse JSON après la création de la réponse.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création de la réponse.
     */
    public static function createReponse(
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // Vérifie que les données nécessaires sont présentes
            if ((
                empty($data['idEtatReponse']) || 
                empty($data['idOffre']) || 
                empty($data['dateDebut']) || 
                empty($data['dateFin']) || 
                empty($data['prixParticipation'])
            )) {
                throw new \InvalidArgumentException("Toutes les données de la réponse sont requises.");
            }

            // Création de l'objet Reponse
            $reponse = new Reponse();
            $reponse->setIdEtatReponse($data['idEtatReponse']);
            $reponse->setIdOffre($data['idOffre']);
            $reponse->setDateDebut($data['dateDebut']);
            $reponse->setDateFin($data['dateFin']);
            $reponse->setPrixParticipation($data['prixParticipation']);

            // Ajout de la réponse en base de données
            $rep = $reponseRepository->ajouterReponse($reponse);

            // Vérification de l'insertion en BDD
            if ($rep) {
                $reponseJSON = $serializer->serialize($reponse, 'json');
                return new JsonResponse([
                    'reponse_offre' => $reponseJSON,
                    'message' => "Réponse créée avec succès",
                    'reponse' => Response::HTTP_CREATED,
                    'headers' => [],
                    'serialized' => true
                ]);
            }
            return new JsonResponse([
                'reponse_offre' => null,
                'message' => "Réponse non créée, merci de vérifier les données fournies",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création de la réponse", $e->getCode());
        }
    }

    /**
     * Met à jour une réponse existante et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de la réponse à mettre à jour.
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données de la réponse.
     *
     * @return JsonResponse La réponse JSON après la mise à jour.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour de la réponse.
     */
    public static function updateReponse(
        int $id,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // Récupération de la réponse existante
            $reponse = $reponseRepository->find($id);

            // Vérification si la réponse existe
            if ($reponse == null) {
                return new JsonResponse([
                    'reponse_offre' => null,
                    'message' => 'Réponse non trouvée, merci de fournir un identifiant valide !',
                    'reponse' => Response::HTTP_NOT_FOUND,
                    'headers' => [],
                    'serialized' => false
                ]);
            }

            // Mise à jour des données de la réponse
            if (isset($data['idEtatReponse'])) {
                $reponse->setIdEtatReponse($data['idEtatReponse']);
            }
            if (isset($data['idOffre'])) {
                $reponse->setIdOffre($data['idOffre']);
            }
            if (isset($data['dateDebut'])) {
                $reponse->setDateDebut($data['dateDebut']);
            }
            if (isset($data['dateFin'])) {
                $reponse->setDateFin($data['dateFin']);
            }
            if (isset($data['prixParticipation'])) {
                $reponse->setPrixParticipation($data['prixParticipation']);
            }

            // Sauvegarde des modifications dans la BDD
            $rep = $reponseRepository->modifierReponse($reponse);

            // Si la mise à jour a réussi
            if ($rep) {
                $reponseJSON = $serializer->serialize($reponse, 'json');
                return new JsonResponse([
                    'reponse_offre' => $reponseJSON,
                    'message' => "Réponse mise à jour avec succès",
                    'reponse' => Response::HTTP_OK,
                    'headers' => [],
                    'serialized' => true
                ]);
            } else {
                return new JsonResponse([
                    'reponse_offre' => null,
                    'message' => "Réponse non mise à jour, merci de vérifier les données fournies",
                    'reponse' => Response::HTTP_BAD_REQUEST,
                    'headers' => [],
                    'serialized' => false
                ]);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour de la réponse", $e->getCode());
        }
    }

    /**
     * Supprime une réponse et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de la réponse à supprimer.
     * @param ReponseRepository $reponseRepository Le repository des réponses.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de la réponse.
     */
    public static function deleteReponse(
        int $id,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // Récupération de la réponse à supprimer
        $reponse = $reponseRepository->find($id);

        // Si la réponse n'existe pas
        if ($reponse == null) {
            return new JsonResponse([
                'reponse_offre' => null,
                'message' => 'Réponse non trouvée, merci de fournir un identifiant valide',
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // Suppression de la réponse dans la BDD
        $rep = $reponseRepository->supprimerReponse($reponse);

        // Si la suppression a réussi
        if ($rep) {
            $reponseJSON = $serializer->serialize($reponse, 'json');
            return new JsonResponse([
                'reponse_offre' => $reponseJSON,
                'message' => 'Réponse supprimée',
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => true
            ]);
        } else {
            return new JsonResponse([
                'reponse_offre' => null,
                'message' => 'Réponse non supprimée !',
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        }
    }
}
