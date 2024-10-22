<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\TypeOffreRepository;
use App\Services\TypeOffreService;

/**
 * Contrôleur pour l'entité TypeOffre.
 *
 * Gère les opérations CRUD de l'entité TypeOffre via une API REST.
 */
class TypeOffreController extends AbstractController
{
    /**
     * Récupère toutes les offres de type existantes.
     *
     * @param TypeOffreRepository $typeOffreRepository, le repository CRUD des offres de type
     * @param SerializerInterface $serializer, le serializer JSON pour les offres de type
     * @return JsonResponse
     */
    #[Route('/api/v1/type-offres', name: 'get_types_offre', methods: ['GET'])]
    public function getTypeOffres(
        TypeOffreRepository $typeOffreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return TypeOffreService::getTypesOffre(
            $typeOffreRepository,
            $serializer
        );
    }

    /**
     * Crée une nouvelle offre de type.
     *
     * @param Request $request, les données de la nouvelle offre de type
     * @param TypeOffreRepository $typeOffreRepository, le repository CRUD des offres de type
     * @param SerializerInterface $serializer, le serializer JSON pour les offres de type
     * @return JsonResponse
     */
    #[Route('/api/v1/type-offre/create', name: 'create_type_offre', methods: ['POST'])]
    public function createTypeOffre(
        Request $request,
        TypeOffreRepository $typeOffreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return TypeOffreService::createTypeOffre(
            $typeOffreRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour une offre de type existante.
     *
     * @param int $id, l'identifiant de l'offre de type à mettre à jour
     * @param Request $request, les nouvelles données de l'offre de type
     * @param TypeOffreRepository $typeOffreRepository, le repository CRUD des offres de type
     * @param SerializerInterface $serializer, le serializer JSON pour les offres de type
     * @return JsonResponse
     */
    #[Route('/api/v1/type-offre/update/{id}', name: 'update_type_offre', methods: ['PATCH'])]
    public function updateTypeOffre(
        int $id,
        Request $request,
        TypeOffreRepository $typeOffreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return TypeOffreService::updateTypeOffre(
            $id,
            $typeOffreRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime une offre de type.
     *
     * @param int $id, l'identifiant de l'offre de type à supprimer
     * @param TypeOffreRepository $typeOffreRepository, le repository CRUD des offres de type
     * @param SerializerInterface $serializer, le serializer JSON pour les offres de type
     * @return JsonResponse
     */
    #[Route('/api/v1/type-offre/delete/{id}', name: 'delete_type_offre', methods: ['DELETE'])]
    public function deleteTypeOffre(
        int $id,
        TypeOffreRepository $typeOffreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return TypeOffreService::deleteTypeOffre(
            $id,
            $typeOffreRepository,
            $serializer
        );
    }
}
