<?php

namespace App\Services;

use App\Repository\ConditionsFinancieresRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\ConditionsFinancieres;
use App\DTO\ConditionsFinancieresDTO;

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
        $arrayConditionsFinancieresDTO = [];
        foreach ($conditionsFinancieres as $indCF => $conditionFinanciere) {
            $conditionsFinancieresDTO = new ConditionsFinancieresDTO(
                $conditionFinanciere->getIdCF(),
                $conditionFinanciere->getMinimunGaranti(),
                $conditionFinanciere->getConditionsPaiement(),
                $conditionFinanciere->getPourcentageRecette()
            );

            array_push($arrayConditionsFinancieresDTO, $conditionsFinancieresDTO);
        }

        $conditionsFinancieresJSON = $serializer->serialize($arrayConditionsFinancieresDTO, 'json');
        return new JsonResponse([
            'conditions_financieres' => $conditionsFinancieresJSON,
            'message' => "Liste des conditions financières",
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
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
                $conditionsFinancieresJSON = $serializer->serialize($conditionsFinancieres, 'json');
                return new JsonResponse([
                    'conditions_financieres' => $conditionsFinancieresJSON,
                    'message' => "condition financière inscrit !",
                    'reponse' => Response::HTTP_CREATED,
                    'headers' => [],
                    'serialized' => true
                ]);
            }
            return new JsonResponse([
                'conditions_financieres' => null,
                'message' => "condition financière non inscrit, merci de regarder l'erreur décrite",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
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
                    'reponse' => Response::HTTP_NOT_FOUND,
                    'headers' => [],
                    'serialized' => true
                ]);
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
                $conditionsFinancieres = $serializer->serialize($conditionsFinancieres, 'json');

                return new JsonResponse([
                    'conditions_financieres' => $conditionsFinancieres,
                    'message' => "condition financière modifiée avec succès",
                    'reponse' => Response::HTTP_OK,
                    'headers' => [],
                    'serialized' => true
                ]);
            } else {
                return new JsonResponse([
                    'conditions_financieres' => null,
                    'message' => "condition financière non modifiée, merci de vérifier l'erreur décrite",
                    'reponse' => Response::HTTP_BAD_REQUEST,
                    'headers' => [],
                    'serialized' => false
                ]);
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
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // suppression de la condition financière en BDD
        $rep = $conditionsFinancieresRepository->removeConditionsFinancieres($conditionsFinancieres);

        // si l'action à réussi
        if ($rep) {
            $conditionsFinancieresJSON = $serializer->serialize($conditionsFinancieres, 'json');
            return new JsonResponse([
                'conditions_financieres' => $conditionsFinancieresJSON,
                'message' => 'condition financière supprimée',
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'conditions_financieres' => null,
                'message' => 'condition financière non supprimée !',
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        }
    }
}
