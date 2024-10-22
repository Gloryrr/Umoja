<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\BudgetEstimatifRepository;
use App\Services\BudgetEstimatifService;

class BudgetEstimatifController extends AbstractController
{
    /**
     * Récupère tous les budgets estimatifs existants.
     *
     * @param BudgetEstimatifRepository $budgetEstimatifRepository, la classe CRUD des budgets estimatifs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/budgets-estimatifs', name: 'get_budgets_estimatifs', methods: ['GET'])]
    public function getBudgetsEstimatifs(
        BudgetEstimatifRepository $budgetEstimatifRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return BudgetEstimatifService::getBudgetsEstimatifs(
            $budgetEstimatifRepository,
            $serializer
        );
    }

    /**
     * Crée un nouveau budget estimatif.
     *
     * @param Request $request
     * @param BudgetEstimatifRepository $budgetEstimatifRepository, la classe CRUD des budgets estimatifs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/budget-estimatif/create', name: 'create_budget_estimatif', methods: ['POST'])]
    public function createBudgetEstimatif(
        Request $request,
        BudgetEstimatifRepository $budgetEstimatifRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return BudgetEstimatifService::createBudgetEstimatif(
            $budgetEstimatifRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour un budget estimatif existant.
     *
     * @param int $id
     * @param Request $request
     * @param BudgetEstimatifRepository $budgetEstimatifRepository, la classe CRUD des budgets estimatifs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/budget-estimatif/update/{id}', name: 'update_budget_estimatif', methods: ['PATCH'])]
    public function updateBudgetEstimatif(
        int $id,
        Request $request,
        BudgetEstimatifRepository $budgetEstimatifRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return BudgetEstimatifService::updateBudgetEstimatif(
            $id,
            $budgetEstimatifRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime un budget estimatif.
     *
     * @param int $id
     * @param BudgetEstimatifRepository $budgetEstimatifRepository, la classe CRUD des budgets estimatifs
     * @return JsonResponse
     */
    #[Route('/api/v1/budget-estimatif/delete/{id}', name: 'delete_budget_estimatif', methods: ['DELETE'])]
    public function deleteBudgetEstimatif(
        int $id,
        BudgetEstimatifRepository $budgetEstimatifRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return BudgetEstimatifService::deleteBudgetEstimatif(
            $id,
            $budgetEstimatifRepository,
            $serializer
        );
    }
}
