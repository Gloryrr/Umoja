<?php

namespace App\Services;

use App\Repository\BudgetEstimatifRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\BudgetEstimatif;
use App\DTO\BudgetEstimatifDTO;

/**
 * Class BudgetEstimatifService
 * Est le gestionnaire des budgets estimatifs (gestion de la logique métier)
 */
class BudgetEstimatifService
{
    /**
     * Récupère tous les budgets estimatifs et renvoie une réponse JSON.
     *
     * @param BudgetEstimatifRepository $budgetEstimatifRepository Le repository des budgets estimatifs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON contenant les budgets estimatifs.
     */
    public static function getBudgetsEstimatifs(
        BudgetEstimatifRepository $budgetEstimatifRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        // on récupère tous les budgets définis
        $budgetsEstimatifs = $budgetEstimatifRepository->findAll();
        $arrayBudgetsEstimatifsDTO = [];
        foreach ($budgetsEstimatifs as $indFT => $budgetEstimatif) {
            $budgetEstimatifDTO = new budgetEstimatifDTO(
                $budgetEstimatif->getIdBE(),
                $budgetEstimatif->getCachetArtiste(),
                $budgetEstimatif->getFraisDeplacement(),
                $budgetEstimatif->getFraisHebergement(),
                $budgetEstimatif->getFraisRestauration(),
            );

            array_push($arrayBudgetsEstimatifsDTO, $budgetEstimatifDTO);
        }

        $budgetsEstimatifsJSON = $serializer->serialize($arrayBudgetsEstimatifsDTO, 'json');
        return new JsonResponse([
            'budget estimatifs_musicaux' => $budgetsEstimatifsJSON,
            'message' => "Liste des budgets estimatifs",
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Crée un nouveau budget estimatif et renvoie une réponse JSON.
     *
     * @param BudgetEstimatifRepository $budgetEstimatifRepository Le repository des budgets estimatifs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les données du budget estimatif à créer.
     *
     * @return JsonResponse La réponse JSON après la création du budget estimatif.
     *
     * @throws \InvalidArgumentException Si les données requises sont manquantes.
     * @throws \RuntimeException En cas d'erreur lors de la création du budget estimatif.
     */
    public static function createBudgetEstimatif(
        BudgetEstimatifRepository $budgetEstimatifRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // création de l'objet et instanciation des données de l'objet
            $budgetEstimatif = new BudgetEstimatif();
            $budgetEstimatif->setCachetArtiste(
                !(empty($data['cachetArtiste'])) ? $data['cachetArtiste'] : null
            );
            $budgetEstimatif->setFraisDeplacement(
                !(empty($data['fraisDeplacement'])) ? $data['fraisDeplacement'] : null
            );
            $budgetEstimatif->setFraisHebergement(
                !(empty($data['fraisHebergement'])) ? $data['fraisHebergement'] : null
            );
            $budgetEstimatif->setFraisRestauration(
                !(empty($data['fraisRestauration'])) ? $data['fraisRestauration'] : null
            );

            // ajout de l'budget_estimatif en base de données
            $rep = $budgetEstimatifRepository->inscritBudgetEstimatif($budgetEstimatif);

            // vérification de l'action en BDD
            if ($rep) {
                $budgetEstimatifJSON = $serializer->serialize($budgetEstimatif, 'json');
                return new JsonResponse([
                    'budget_estimatif' => $budgetEstimatifJSON,
                    'message' => "budget estimatif inscrit !",
                    'reponse' => Response::HTTP_CREATED,
                    'headers' => [],
                    'serialized' => true
                ]);
            }
            return new JsonResponse([
                'budget_estimatif' => null,
                'message' => "budget estimatif non inscrit, merci de regarder l'erreur décrite",
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la création du budget estimatif", $e->getCode());
        }
    }

    /**
     * Met à jour un budget estimatif existant et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du budget estimatif à mettre à jour.
     * @param BudgetEstimatifRepository $budgetEstimatifRepository Le repository des budgets estimatifs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     * @param mixed $data Les nouvelles données du budget estimatif.
     *
     * @return JsonResponse La réponse JSON après la mise à jour du budget estimatif.
     *
     * @throws \RuntimeException En cas d'erreur lors de la mise à jour du budget estimatif.
     */
    public static function updateBudgetEstimatif(
        int $id,
        BudgetEstimatifRepository $budgetEstimatifRepository,
        SerializerInterface $serializer,
        mixed $data
    ): JsonResponse {
        try {
            // récupération du budget estimatif
            $budgetEstimatif = $budgetEstimatifRepository->find($id);

            // si il n'y pas de budget estimatif trouvé
            if ($budgetEstimatif == null) {
                return new JsonResponse([
                    'budget_estimatif' => null,
                    'message' => 'budget estimatif non trouvé, merci de donner un identifiant valide !',
                    'reponse' => Response::HTTP_NOT_FOUND,
                    'headers' => [],
                    'serialized' => true
                ]);
            }

            // on vérifie qu'aucune données ne manque pour la mise à jour
            // et on instancie les données dans l'objet
            if (!(empty($data['cachetArtiste']) || !(is_null($data['cachetArtiste'])))) {
                $budgetEstimatif->setCachetArtiste($data['cachetArtiste']);
            }
            if (!(empty($data['fraisDeplacement']) || !(is_null($data['fraisDeplacement'])))) {
                $budgetEstimatif->setFraisDeplacement($data['fraisDeplacement']);
            }
            if (!(empty($data['fraisHebergement']) || !(is_null($data['fraisHebergement'])))) {
                $budgetEstimatif->setFraisHebergement($data['fraisHebergement']);
            }
            if (!(empty($data['fraisRestauration']) || !(is_null($data['fraisRestauration'])))) {
                $budgetEstimatif->setFraisRestauration($data['fraisRestauration']);
            }

            // sauvegarde des modifications dans la BDD
            $rep = $budgetEstimatifRepository->updateBudgetEstimatif($budgetEstimatif);

            // si l'action à réussi
            if ($rep) {
                $budgetEstimatif = $serializer->serialize($budgetEstimatif, 'json');

                return new JsonResponse([
                    'budget_estimatif' => $budgetEstimatif,
                    'message' => "budget estimatif modifié avec succès",
                    'reponse' => Response::HTTP_OK,
                    'headers' => [],
                    'serialized' => true
                ]);
            } else {
                return new JsonResponse([
                    'budget_estimatif' => null,
                    'message' => "budget estimatif non modifié, merci de vérifier l'erreur décrite",
                    'reponse' => Response::HTTP_BAD_REQUEST,
                    'headers' => [],
                    'serialized' => false
                ]);
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Erreur lors de la mise à jour du budget estimatif", $e->getCode());
        }
    }

    /**
     * Supprime un budget estimatif et renvoie une réponse JSON.
     *
     * @param int $id L'identifiant du budget estimatif à supprimer.
     * @param BudgetEstimatifRepository $budgetEstimatifRepository Le repository des budgets estimatifs.
     * @param SerializerInterface $serializer Le service de sérialisation.
     *
     * @return JsonResponse La réponse JSON après la suppression du budget estimatif.
     */
    public static function deleteBudgetEstimatif(
        int $id,
        BudgetEstimatifRepository $budgetEstimatifRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        // récupération du budget estimatif à supprimer
        $budgetEstimatif = $budgetEstimatifRepository->find($id);

        // si pas de budget estimatif trouvé
        if ($budgetEstimatif == null) {
            return new JsonResponse([
                'budget_estimatif' => null,
                'message' => 'budget estimatif non trouvé, merci de fournir un identifiant valide',
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        }

        // suppression du budget estimatif en BDD
        $rep = $budgetEstimatifRepository->removeBudgetEstimatif($budgetEstimatif);

        // si l'action à réussi
        if ($rep) {
            $budgetEstimatifJSON = $serializer->serialize($budgetEstimatif, 'json');
            return new JsonResponse([
                'budget_estimatif' => $budgetEstimatifJSON,
                'message' => 'budget estimatif supprimé',
                'reponse' => Response::HTTP_NO_CONTENT,
                'headers' => [],
                'serialized' => false
            ]);
        } else {
            return new JsonResponse([
                'budget_estimatif' => null,
                'message' => 'budget estimatif non supprimé !',
                'reponse' => Response::HTTP_BAD_REQUEST,
                'headers' => [],
                'serialized' => false
            ]);
        }
    }
}
