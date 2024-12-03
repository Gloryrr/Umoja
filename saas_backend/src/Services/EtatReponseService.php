<?php

namespace App\Services;

use App\Repository\EtatReponseRepository;
use App\Repository\ReponseRepository;
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
        $etatsReponseJSON = $serializer->serialize(
            $etatsReponse,
            'json',
            ['groups' => ['etat_reponse:read']]
        );
        return new JsonResponse([
            'etats_reponse' => $etatsReponseJSON,
            'message' => "Liste des états de réponse",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Récupère un état de réponse par son id et renvoie une réponse JSON.
     *
     * @param int $id, L'identifiant de l'état de réponse
     * @param EtatReponseRepository $etatReponseRepository Le repository des états de réponse.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les états de réponse.
     */
    public static function getEtatReponseById(
        int $id,
        EtatReponseRepository $etatReponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les états
        $etatsReponse = $etatReponseRepository->findBy(['id' => $id]);
        $etatsReponseJSON = $serializer->serialize(
            $etatsReponse,
            'json',
            ['groups' => ['etat_reponse:read']]
        );
        return new JsonResponse([
            'etats_reponse' => $etatsReponseJSON,
            'message' => "Liste des états de réponse",
            'serialized' => true
        ], Response::HTTP_OK);
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
            if (empty($data['etatReponse']['nomEtatReponse'])) {
                throw new \InvalidArgumentException("Le nom de l'état de réponse est requis.");
            }

            // création de l'objet et instanciation des données de l'objet
            $etatReponse = new EtatReponse();
            $etatReponse->setNomEtatReponse($data['etatReponse']['nomEtatReponse']);
            $etatReponse->setDescriptionEtatReponse($data['etatReponse']['descriptionEtatReponse'] ?? '');

            // ajout du nouvel état en base de données
            $rep = $etatReponseRepository->ajouterEtatReponse($etatReponse);

            // vérification de l'action en BDD
            if ($rep) {
                $etatReponseJSON = $serializer->serialize(
                    $etatReponse,
                    'json',
                    ['groups' => ['etat_reponse:read']]
                );
                return new JsonResponse([
                    'etat_reponse' => $etatReponseJSON,
                    'message' => "État de réponse ajouté !",
                    'serialized' => true
                ], Response::HTTP_CREATED);
            }
            return new JsonResponse([
                'etat_reponse' => null,
                'message' => "État de réponse non inscrit, merci de vérifier l'erreur décrite",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
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
                    'serialized' => true
                ], Response::HTTP_NOT_FOUND);
            }

            // mise à jour des données
            if (isset($data['etatReponse']['nomEtatReponse'])) {
                $etatReponse->setNomEtatReponse($data['etatReponse']['nomEtatReponse']);
            }
            if (isset($data['etatReponse']['descriptionEtatReponse'])) {
                $etatReponse->setDescriptionEtatReponse($data['etatReponse']['descriptionEtatReponse']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $etatReponseRepository->modifierEtatReponse($etatReponse);

            // réponse après la mise à jour
            if ($rep) {
                $etatReponse = $serializer->serialize(
                    $etatReponse,
                    'json',
                    ['groups' => ['etat_reponse:read']]
                );
                return new JsonResponse([
                    'etat_reponse' => $etatReponse,
                    'message' => "État de réponse modifié avec succès",
                    'serialized' => true
                ], Response::HTTP_OK);
            } else {
                return new JsonResponse([
                    'etat_reponse' => null,
                    'message' => "État de réponse non modifié, merci de vérifier l'erreur décrite",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
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
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $rep = $etatReponseRepository->supprimerEtatReponse($etatReponse);

        // réponse après suppression
        if ($rep) {
            $etatReponseJSON = $serializer->serialize(
                $etatReponse,
                'json',
                ['groups' => ['etat_reponse:read']]
            );
            return new JsonResponse([
                'etat_reponse' => $etatReponseJSON,
                'message' => "État de réponse supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'etat_reponse' => null,
                'message' => "État de réponse non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute une réponse à l'état de réponse et renvoie une réponse JSON.
     *
     * @param EtatReponseRepository $etatReponseRepository Le repository de l'état de réponse.
     * @param ReponseRepository $reponseRepository Le repository des réponses .
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'état de réponse.
     */
    public static function ajouteReponseEtatReponse(
        EtatReponseRepository $etatReponseRepository,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération de l'état de réponse
        $etatReponse = $etatReponseRepository->find(intval($data['idEtatReponse']));
        $reponse = $reponseRepository->find(intval($data['idReponse']));

        // si pas trouvée
        if ($etatReponse == null || $reponse == null) {
            return new JsonResponse([
                'etats_reponses' => null,
                'message' => "etat de réponse ou réponse non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout en BDD
        $etatReponse->addReponse($reponse);
        $rep = $etatReponseRepository->modifierEtatReponse($etatReponse);

        // réponse après suppression
        if ($rep) {
            $etatReponseJSON = $serializer->serialize(
                $etatReponse,
                'json',
                ['groups' => ['etat_reponse:read']]
            );
            return new JsonResponse([
                'etats_reponses' => $etatReponseJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'etats_reponses' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire une réponse à l'état de réponse et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'état de réponse.
     * @param EtatReponseRepository $etatReponseRepository Le repository de l'état de réponse.
     * @param ReponseRepository $reponseRepository Le repository des réponses .
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'état de réponse.
     */
    public static function retireOffreEtatOffre(
        EtatReponseRepository $etatReponseRepository,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération de l'état de réponse à supprimer
        $etatReponse = $etatReponseRepository->find(intval($data['idEtatReponse']));
        $reponse = $reponseRepository->find(intval($data['idReponse']));

        // si pas trouvé
        if ($etatReponse == null || $reponse == null) {
            return new JsonResponse([
                'etats_reponses' => null,
                'message' => "etat de réponse ou réponse non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $etatReponse->removeReponse($reponse);
        $rep = $etatReponseRepository->modifierEtatReponse($etatReponse);

        // réponse après suppression
        if ($rep) {
            $etatReponseJSON = $serializer->serialize(
                $etatReponse,
                'json',
                ['groups' => ['etat_reponse:read']]
            );
            return new JsonResponse([
                'etats_reponses' => $etatReponseJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'etats_reponses' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
