<?php

namespace App\Controller;

use App\Repository\ExtrasRepository;
use App\Services\ExtrasService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Contrôleur pour la gestion des Extras.
 */
class ExtrasController extends AbstractController
{
    /**
     * Récupère tous les extras.
     *
     * @param ExtrasRepository $extrasRepository, la classe CRUD des extras
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/extras', name: 'get_extras', methods: ['GET'])]
    public function getExtras(
        ExtrasRepository $extrasRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return ExtrasService::getExtras(
            $extrasRepository,
            $serializer
        );
    }

    /**
     * Crée un nouvel extra.
     *
     * @param Request $request
     * @param ExtrasRepository $extrasRepository, la classe CRUD des extras
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/extras', name: 'create_extra', methods: ['POST'])]
    public function createExtra(
        Request $request,
        ExtrasRepository $extrasRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        return ExtrasService::createExtra(
            $extrasRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour un extra existant.
     *
     * @param int $id
     * @param Request $request
     * @param ExtrasRepository $extrasRepository, la classe CRUD des extras
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/extras/{id}', name: 'update_extra', methods: ['PATCH'])]
    public function updateExtra(
        int $id,
        Request $request,
        ExtrasRepository $extrasRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ExtrasService::updateExtra(
            $id,
            $extrasRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime un extra.
     *
     * @param int $id
     * @param ExtrasRepository $extrasRepository, la classe CRUD des extras
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/extras/{id}', name: 'delete_extra', methods: ['DELETE'])]
    public function deleteExtra(
        int $id,
        ExtrasRepository $extrasRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return ExtrasService::deleteExtra(
            $id,
            $extrasRepository,
            $serializer
        );
    }
}
