<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\GenreMusicalRepository;
use App\Services\GenreMusicalService;

class GenreMusicalController extends AbstractController
{
    /**
     * Récupère tous les genres musicaux existants.
     *
     * @param GenreMusicalRepository $genreMusicalRepository, la classe CRUD des genres musicaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/genres-musicaux', name: 'get_genres_musicaux', methods: ['GET'])]
    public function getGenresMusicaux(
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return GenreMusicalService::getGenresMusicaux(
            $genreMusicalRepository,
            $serializer
        );
    }

    /**
     * Crée un nouveau genre musical.
     *
     * @param Request $request
     * @param GenreMusicalRepository $GenreMusicalRepository, la classe CRUD des genres musicaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/genre-musical/create', name: 'create_genre_musical', methods: ['POST'])]
    public function createGenreMusical(
        Request $request,
        GenreMusicalRepository $GenreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return GenreMusicalService::createGenreMusical(
            $GenreMusicalRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour un genre  existant.
     *
     * @param int $id
     * @param Request $request
     * @param GenreMusicalRepository $GenreMusicalRepository, la classe CRUD des genres musicaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/genre-musical/update/{id}', name: 'update_genre_musical', methods: ['PATCH'])]
    public function updateGenreMusical(
        int $id,
        Request $request,
        GenreMusicalRepository $GenreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return GenreMusicalService::updateGenreMusical(
            $id,
            $GenreMusicalRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime un genre musical.
     *
     * @param int $id
     * @param GenreMusicalRepository $GenreMusicalRepository, la classe CRUD des genres musicaux
     * @return JsonResponse
     */
    #[Route('/api/v1/genre-musical/delete/{id}', name: 'delete_genre_musical', methods: ['DELETE'])]
    public function deleteGenreMusical(
        int $id,
        GenreMusicalRepository $GenreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return GenreMusicalService::deleteGenreMusical(
            $id,
            $GenreMusicalRepository,
            $serializer
        );
    }
}
