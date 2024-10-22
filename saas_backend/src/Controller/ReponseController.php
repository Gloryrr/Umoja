<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReponseRepository;
use App\Services\ReponseService;

/**
 * Contrôleur pour l'entité Reponse.
 *
 * Gère les opérations CRUD de l'entité Reponse via une API REST.
 */
class ReponseController extends AbstractController
{
    /**
     * Récupère toutes les réponses existantes.
     *
     * @param ReponseRepository $reponseRepository, le repository CRUD des réponses
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reponses', name: 'get_reponses', methods: ['GET'])]
    public function getReponses(
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return ReponseService::getReponses(
            $reponseRepository,
            $serializer
        );
    }

    /**
     * Crée une nouvelle réponse.
     *
     * @param Request $request, les données de la nouvelle réponse
     * @param ReponseRepository $reponseRepository, le repository CRUD des réponses
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reponse/create', name: 'create_reponse', methods: ['POST'])]
    public function createReponse(
        Request $request,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ReponseService::createReponse(
            $reponseRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour une réponse existante.
     *
     * @param int $id, l'identifiant de la réponse à mettre à jour
     * @param Request $request, les nouvelles données de la réponse
     * @param ReponseRepository $reponseRepository, le repository CRUD des réponses
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reponse/update/{id}', name: 'update_reponse', methods: ['PATCH'])]
    public function updateReponse(
        int $id,
        Request $request,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ReponseService::updateReponse(
            $id,
            $reponseRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime une réponse.
     *
     * @param int $id, l'identifiant de la réponse à supprimer
     * @param ReponseRepository $reponseRepository, le repository CRUD des réponses
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reponse/delete/{id}', name: 'delete_reponse', methods: ['DELETE'])]
    public function deleteReponse(
        int $id,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return ReponseService::deleteReponse(
            $id,
            $reponseRepository,
            $serializer
        );
    }
}
