<?php

namespace App\Services;

use App\Repository\ConditionsFinancieresRepository;
use App\Repository\OffreRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\ConditionsFinancieres;

/**
 * Class ConditionsFinancieresService
 * Est le gestionnaire des conditions financières (gestion de la logique métier)
 */
class ConditionsFinancieresService
{
    /**
     * Récupère tous les conditions financières et renvoie une réponse JSON.
     *
     * @param ConditionsFinancieresRepository $conditionsFinancieresRepository Le repository des conditions financières.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les conditions financières.
     */
    public static function getConditionsFinancieres(
        ConditionsFinancieresRepository $conditionsFinancieresRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les budgets définis
        $conditionsFinancieres = $conditionsFinancieresRepository->findAll();
        $conditionsFinancieresJSON = $serializer->serialize(
            $conditionsFinancieres, 
            'json',
            ['groups' => ['conditions_financieres:read']]
        );
        return new JsonResponse([
            'conditions_financieres' => $conditionsFinancieresJSON,
            'message' => "Liste des conditions financières",
            'serialized' => true
        ], Response::HTTP_OK);
    }

    /**
     * Crée une nouvelle condition financière et renvoie une réponse JSON.
     *
     * @param ConditionsFinancieresRepository $conditionsFinancieresRepository Le repository des conditions financières.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données de la condition financière à créer.
     *
     * @return JsonResponse La réponse JSON après la création de la condition financière.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création de la condition financière.
     */
    public static function createConditionsFinancieres(
        ConditionsFinancieresRepository $conditionsFinancieresRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // création de l'objet et instanciation des données de l'objet
            $conditionsFinancieres = new ConditionsFinancieres();
            $conditionsFinancieres->setMinimunGaranti(
                !(empty($data['minimumGaranti'])) ? $data['minimumGaranti'] : null
            );
            $conditionsFinancieres->setConditionsPaiement(
                !(empty($data['conditionsPaiement'])) ? $data['conditionsPaiment'] : null
            );
            $conditionsFinancieres->setPourcentageRecette(
                !(empty($data['pourcentageRecette'])) ? $data['pourcentageRecette'] : null
            );

            // ajout de la conditions financieres en base de données
            $rep = $conditionsFinancieresRepository->inscritConditionsFinancieres($conditionsFinancieres);

            // vérification de l'action en BDD
            if ($rep) {
                $conditionsFinancieresJSON = $serializer->serialize(
                    $conditionsFinancieres, 
                    'json',
                    ['groups' => ['conditions_financieres:read']]
                );
                return new JsonResponse([
                    'conditions_financieres' => $conditionsFinancieresJSON,
                    'message' => "condition financière inscrit !",
                    'serialized' => true
                ], Response::HTTP_CREATED);
            }
            return new JsonResponse([
                'conditions_financieres' => null,
                'message' => "condition financière non inscrit, merci de regarder l'erreur décrite",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création de la condition financière", $e->getCode());
        }
    }

    /**
     * Met à jour une condition financière existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de la condition financière à mettre à jour.
     * @param ConditionsFinancieresRepository $conditionsFinancieresRepository Le repository des conditions financières.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données de la condition financière.
     *
     * @return JsonResponse La réponse JSON après la mise à jour de la condition financière.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour de la condition financière.
     */
    public static function updateConditionsFinancieres(
        int $id,
        ConditionsFinancieresRepository $conditionsFinancieresRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération de la condition financière
            $conditionsFinancieres = $conditionsFinancieresRepository->find($id);

            // si il n'y pas de condition financière trouvée
            if ($conditionsFinancieres == null) {
                return new JsonResponse([
                    'conditions_financieres' => null,
                    'message' => 'condition financière non trouvée, merci de donner un identifiant valide !',
                    'serialized' => true
                ], Response::HTTP_NOT_FOUND);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (!(empty($data['minimumGaranti']) || !(is_null($data['minimumGaranti'])))) {
                $conditionsFinancieres->setMinimunGaranti($data['minimumGaranti']);
            }
            if (!(empty($data['conditionsPaiement']) || !(is_null($data['conditionsPaiement'])))) {
                $conditionsFinancieres->setConditionsPaiement($data['conditionsPaiement']);
            }
            if (!(empty($data['pourcentageRecette']) || !(is_null($data['pourcentageRecette'])))) {
                $conditionsFinancieres->setPourcentageRecette($data['pourcentageRecette']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $conditionsFinancieresRepository->updateConditionsFinancieres($conditionsFinancieres);

            // si l'action à réussi
            if ($rep) {
                $conditionsFinancieres = $serializer->serialize(
                    $conditionsFinancieres, 
                    'json',
                    ['groups' => ['conditions_financieres:read']]
                );

                return new JsonResponse([
                    'conditions_financieres' => $conditionsFinancieres,
                    'message' => "condition financière modifiée avec succès",
                    'serialized' => true
                ], Response::HTTP_OK);
            } else {
                return new JsonResponse([
                    'conditions_financieres' => null,
                    'message' => "condition financière non modifiée, merci de vérifier l'erreur décrite",
                    'serialized' => false
                ], Response::HTTP_BAD_REQUEST);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour de la condition financière", $e->getCode());
        }
    }

    /**
     * Supprime une condition financière et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant de la condition financière à supprimer.
     * @param ConditionsFinancieresRepository $conditionsFinancieresRepository Le repository des conditions financières.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression de la condition financière.
     */
    public static function deleteConditionsFinancieres(
        int $id,
        ConditionsFinancieresRepository $conditionsFinancieresRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération de la condition financière à supprimer
        $conditionsFinancieres = $conditionsFinancieresRepository->find($id);

        // si pas de condition financière trouvé
        if ($conditionsFinancieres == null) {
            return new JsonResponse([
                'conditions_financieres' => null,
                'message' => 'condition financière non trouvée, merci de fournir un identifiant valide',
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression de la condition financière en BDD
        $rep = $conditionsFinancieresRepository->removeConditionsFinancieres($conditionsFinancieres);

        // si l'action à réussi
        if ($rep) {
            $conditionsFinancieresJSON = $serializer->serialize(
                $conditionsFinancieres, 
                'json',
                ['groups' => ['conditions_financieres:read']]
            );
            return new JsonResponse([
                'conditions_financieres' => $conditionsFinancieresJSON,
                'message' => 'condition financière supprimée',
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'conditions_financieres' => null,
                'message' => 'condition financière non supprimée !',
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Ajoute une offre aux conditions financieres et renvoie une réponse JSON.
     *
     * @param ConditionsFinancieresRepository $conditionsFinancieresRepository Le repository des conditions financières.
     * @param OffreRepository $offreRepository Le repository desoffres .
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression des conditions financières.
     */
    public static function ajouteOffreConditionsFinancieres(
        ConditionsFinancieresRepository $conditionsFinancieresRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération des conditions financières
        $conditionsFinancieres = $conditionsFinancieresRepository->find(intval($data['idConditionsFinancieres']));
        $offre = $offreRepository->find(intval($data['idOffre']));

        // si pas trouvée
        if ($conditionsFinancieres == null || $offre == null) { 
            return new JsonResponse([
                'conditions_financieres' => null,
                'message' => "conditions financières ou offre non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // ajout en BDD
        $conditionsFinancieres->addOffre($offre);
        $rep = $conditionsFinancieresRepository->updateConditionsFinancieres($conditionsFinancieres);

        // réponse après suppression
        if ($rep) {
            $conditionsFinancieresJSON = $serializer->serialize(
                $conditionsFinancieres, 
                'json',
                ['groups' => ['conditions_financieres:read']]
            );
            return new JsonResponse([
                'conditions_financieres' => $conditionsFinancieresJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'conditions_financieres' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Retire une offre au conditions financières et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant des conditions financières.
     * @param ConditionsFinancieresRepository $conditionsFinancieresRepository Le repository des conditions financières.
     * @param OffreRepository $offreRepository Le repository desoffres .
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression des conditions financières.
     */
    public static function retireOffreConditionsFinancieres(
        ConditionsFinancieresRepository $conditionsFinancieresRepository,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        // récupération des conditions financières à supprimer
        $conditionsFinancieres = $conditionsFinancieresRepository->find(intval($data['idConditionsEstimatif']));
        $offre = $offreRepository->find(intval($data['idOffre']));

        // si pas trouvé
        if ($conditionsFinancieres == null || $offre == null) { 
            return new JsonResponse([
                'conditions_financieres' => null,
                'message' => "conditions financières ou offre non trouvée, merci de fournir un identifiant valide",
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        }

        // suppression en BDD
        $conditionsFinancieres->removeOffre($offre);
        $rep = $conditionsFinancieresRepository->updateConditionsFinancieres($conditionsFinancieres);

        // réponse après suppression
        if ($rep) {
            $conditionsFinancieresJSON = $serializer->serialize(
                $conditionsFinancieres, 
                'json',
                ['groups' => ['conditions_financieres:read']]
            );
            return new JsonResponse([
                'conditions_financieres' => $conditionsFinancieresJSON,
                'message' => "Type d'offre supprimé",
                'serialized' => false
            ], Response::HTTP_NO_CONTENT);
        } else {
            return new JsonResponse([
                'conditions_financieres' => null,
                'message' => "Type d'offre non supprimé !",
                'serialized' => false
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
