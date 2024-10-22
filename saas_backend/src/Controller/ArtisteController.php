<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\ArtisteRepository;
use App\Services\ArtisteService;

class ArtisteController extends AbstractController
{
    /**
     * Récupère tous les artistes existants.
     *
     * @param ArtisteRepository $artisteRepository, la classe CRUD des artistes
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/artistes', name: 'get_artistes', methods: ['GET'])]
    public function getartistes(
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return Artisteservice::getArtistes(
            $artisteRepository,
            $serializer
        );
    }

    /**
     * Crée un nouveau artiste.
     *
     * @param Request $request
     * @param ArtisteRepository $artisteRepository, la classe CRUD des artistes
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/artiste/create', name: 'create_artiste', methods: ['POST'])]
    public function createArtiste(
        Request $request,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return Artisteservice::createArtiste(
            $artisteRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour un artiste existant.
     *
     * @param int $id
     * @param Request $request
     * @param ArtisteRepository $artisteRepository, la classe CRUD des artistes
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/artiste/update/{id}', name: 'update_artiste', methods: ['PATCH'])]
    public function updateArtiste(
        int $id,
        Request $request,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return Artisteservice::updateArtiste(
            $id,
            $artisteRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime un artiste.
     *
     * @param int $id
     * @param ArtisteRepository $artisteRepository, la classe CRUD des artistes
     * @return JsonResponse
     */
    #[Route('/api/v1/artiste/delete/{id}', name: 'delete_artiste', methods: ['DELETE'])]
    public function deleteArtiste(
        int $id,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return Artisteservice::deleteArtiste(
            $id,
            $artisteRepository,
            $serializer
        );
    }
}
