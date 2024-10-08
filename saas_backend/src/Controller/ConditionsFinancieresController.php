<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\ConditionsFinancieresService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ConditionsFinancieresRepository;
use Symfony\Component\Serializer\SerializerInterface;

class ConditionsFinancieresController extends AbstractController
{
    /**
     * Récupère toutes les conditions financières existantes.
     *
     * @param ConditionsFinancieresRepository $conditionsFinancieresRepository, la classe CRUD des conditions financières
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/conditions-financieres', name: 'get_conditions_financieres', methods: ['GET'])]
    public function getConditionsFinancieres(
        ConditionsFinancieresRepository $conditionsFinancieresRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return ConditionsFinancieresService::getConditionsFinancieres(
            $conditionsFinancieresRepository,
            $serializer
        );
    }

    /**
     * Crée une nouvelle conditions financière.
     *
     * @param Request $request
     * @param ConditionsFinancieresRepository $conditionsFinancieresRepository, la classe CRUD des conditions financières
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/condition-financiere/create', name: 'create_condition_financiere', methods: ['POST'])]
    public function createConditionsFinancieres(
        Request $request,
        ConditionsFinancieresRepository $conditionsFinancieresRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ConditionsFinancieresService::createConditionsFinancieres(
            $conditionsFinancieresRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour une condition financière existante.
     *
     * @param int $id
     * @param Request $request
     * @param ConditionsFinancieresRepository $conditionsFinancieresRepository, la classe CRUD des conditions financières
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/condition-financiere/update/{id}', name: 'update_condition_financiere', methods: ['PATCH'])]
    public function updateConditionsFinancieres(
        int $id,
        Request $request,
        ConditionsFinancieresRepository $conditionsFinancieresRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ConditionsFinancieresService::updateConditionsFinancieres(
            $id,
            $conditionsFinancieresRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime une condition financière.
     *
     * @param int $id
     * @param ConditionsFinancieresRepository $conditionsFinancieresRepository, la classe CRUD des conditions financières
     * @return JsonResponse
     */
    #[Route('/api/v1/condition-financiere/delete/{id}', name: 'delete_condition_financiere', methods: ['DELETE'])]
    public function deleteConditionsFinancieres(
        int $id,
        ConditionsFinancieresRepository $conditionsFinancieresRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return ConditionsFinancieresService::deleteConditionsFinancieres(
            $id,
            $conditionsFinancieresRepository,
            $serializer
        );
    }
}
