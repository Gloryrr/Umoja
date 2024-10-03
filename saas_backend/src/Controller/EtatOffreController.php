<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\EtatOffreRepository;
use App\Services\EtatOffreService;

class EtatOffreController extends AbstractController
{
    /**
     * Récupère tous les états d'offre existants.
     *
     * @param EtatOffreRepository $etatOffreRepository, la classe CRUD des états d'offre
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/genres-musicaux', name: 'get_genres_musicaux', methods: ['GET'])]
    public function getGenresMusicaux(
        EtatOffreRepository $etatOffreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return EtatOffreService::getEtatsOffre(
            $etatOffreRepository,
            $serializer
        );
    }

    /**
     * Crée un nouveau genre musical.
     *
     * @param Request $request
     * @param EtatOffreRepository $etatOffreRepository, la classe CRUD des états d'offre
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/genre-musical/create', name: 'create_genre_musical', methods: ['POST'])]
    public function createGenreMusical(
        Request $request,
        EtatOffreRepository $etatOffreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return EtatOffreService::createEtatOffre(
            $etatOffreRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour un genre  existant.
     *
     * @param int $id
     * @param Request $request
     * @param EtatOffreRepository $etatOffreRepository, la classe CRUD des états d'offre
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/genre-musical/update/{id}', name: 'update_genre_musical', methods: ['PATCH'])]
    public function updateGenreMusical(
        int $id,
        Request $request,
        EtatOffreRepository $etatOffreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return EtatOffreService::updateEtatOffre(
            $id,
            $etatOffreRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime un genre musical.
     *
     * @param int $id
     * @param EtatOffreRepository $etatOffreRepository, la classe CRUD des états d'offre
     * @return JsonResponse
     */
    #[Route('/api/v1/genre-musical/delete/{id}', name: 'delete_genre_musical', methods: ['DELETE'])]
    public function deleteGenreMusical(
        int $id,
        EtatOffreRepository $etatOffreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return EtatOffreService::deleteEtatOffre(
            $id,
            $etatOffreRepository,
            $serializer
        );
    }
}
