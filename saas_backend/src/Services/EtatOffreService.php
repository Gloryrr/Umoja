<?php

namespace App\Services;

use App\Repository\EtatOffreRepository;
use App\Repository\OffreRepository;
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
        $etatsOffreJSON = $serializer->serialize(
            $etatsOffre, 
            'json',
            ['groups' => ['etat_offre:read']]
        );
        return new JsonResponse([
            'etats_offre' => $etatsOffreJSON,
            'message' => "Liste des états d'offre",
            'serialized' => true
        ], Response::HTTP_OK);
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
            if (empty($data['etatOffre']['nomEtat'])) {
                throw new \InvalidArgumentException("Le nom de l'état d'offre est requis.");
            }

            // création de l'objet et instanciation des données de l'objet
            $etatOffre = new EtatOffre();
            $etatOffre->setNomEtat($data['etatOffre']['nomEtat']);

            // ajout du nouvel état en base de données
            $rep = $etatOffreRepository->inscritEtatOffre($etatOffre);

            // vérification de l'action en BDD
            if ($rep) {
                $etatOffreJSON = $serializer->serialize(
                    $etatOffre, 
                    'json',
                    ['groups' => ['etat_offre:read']]
                );
                return new JsonResponse([
                    'genre_musical' => $etatOffreJSON,
                    'message' => "Etat d'offre ajoutée !",
                    'serialized' => true
                ], Response::HTTP_CREATED);
            }
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "Etat d'offre non inscrit, merci de regarder l'erreur décrite",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
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
                    'serialized' => true
                ], Response::HTTP_NOT_FOUND);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (isset($data['etatOffre']['nomEtat'])) {
                $etatOffre->setNomEtat($data['etatOffre']['nomEtat']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $etatOffreRepository->updateEtatOffre($etatOffre);

            // si l'action à réussi
            if ($rep) {
                $etatOffre = $serializer->serialize(
                    $etatOffre, 
                    'json',
                    ['groups' => ['etat_offre:read']]
                );

                return new JsonResponse([
                    'genre_musical' => $etatOffre,
                    'message' => "État d'offre modifié avec succès",
                    'serialized' => true
                ], Response::HTTP_OK);
            } else {
                return new JsonResponse([
                    'genre_musical' => null,
                    'message' => "État d'offre non modifié, merci de vérifier l'erreur décrite",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
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
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression de l'état d'offre en BDD
        $rep = $etatOffreRepository->removeEtatOffre($etatOffre);

        // si l'action à réussi
        if ($rep) {
            $etatOffreJSON = $serializer->serialize(
                $etatOffre, 
                'json',
                ['groups' => ['etat_offre:read']]
            );
            return new JsonResponse([
                'genre_musical' => $etatOffreJSON,
                'message' => "État d'offre supprimée",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'genre_musical' => null,
                'message' => "État d'offre non supprimée !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute une offre à l'état d'offre et renvoie une réponse JSON.
     *
     * @param EtatOffreRepository $etatOffreRepository Le repository de l'état d'offre.
     * @param OffreRepository $offreRepository Le repository des offres .
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'état d'offre.
     */
    public static function ajouteOffreEtatOffre(
        EtatOffreRepository $etatOffreRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération de l'état d'offre
        $etatOffre = $etatOffreRepository->find(intval($data['idEtatOffre']));
        $offre = $offreRepository->find(intval($data['idOffre']));

        // si pas trouvée
        if ($etatOffre == null || $offre == null) { 
            return new JsonResponse([
                'etat_offre' => null,
                'message' => "etat d'offre ou offre non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout en BDD
        $etatOffre->addOffre($offre);
        $rep = $etatOffreRepository->updateEtatOffre($etatOffre);

        // réponse après suppression
        if ($rep) {
            $etatOffreJSON = $serializer->serialize(
                $etatOffre, 
                'json',
                ['groups' => ['etat_offre:read']]
            );
            return new JsonResponse([
                'etat_offre' => $etatOffreJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'etat_offre' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire une offre à l'état d'offre et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de l'état d'offre.
     * @param EtatOffreRepository $etatOffreRepository Le repository de l'état d'offre.
     * @param OffreRepository $offreRepository Le repository desoffres .
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de l'état d'offre.
     */
    public static function retireOffreEtatOffre(
        EtatOffreRepository $etatOffreRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération de l'état d'offre à supprimer
        $etatOffre = $etatOffreRepository->find(intval($data['idEtatOffre']));
        $offre = $offreRepository->find(intval($data['idOffre']));

        // si pas trouvé
        if ($etatOffre == null || $offre == null) { 
            return new JsonResponse([
                'etat_offre' => null,
                'message' => "etat d'offre ou offre non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $etatOffre->removeOffre($offre);
        $rep = $etatOffreRepository->updateEtatOffre($etatOffre);

        // réponse après suppression
        if ($rep) {
            $etatOffreJSON = $serializer->serialize(
                $etatOffre, 
                'json',
                ['groups' => ['etat_offre:read']]
            );
            return new JsonResponse([
                'etat_offre' => $etatOffreJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'etat_offre' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
