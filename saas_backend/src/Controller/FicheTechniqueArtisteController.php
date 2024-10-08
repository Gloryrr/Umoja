<?php

namespace App\Controller;

use App\Repository\FicheTechniqueArtisteRepository;
use App\Services\FicheTechniqueArtisteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FicheTechniqueArtisteController extends AbstractController
{
    /**
     * Récupère toutes les fiches techniques d'artistes.
     */
    #[Route('/api/v1/fiches-techniques', name: 'get_fiches_techniques', methods: ['GET'])]
    public function getFichesTechniques(
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return FicheTechniqueArtisteService::getFichesTechniquesArtiste(
            $ficheTechniqueArtisteRepository,
            $serializer
        );
    }

    /**
     * Crée une nouvelle fiche technique d'artiste.
     */
    #[Route('/api/v1/fiche-technique', name: 'create_fiche_technique', methods: ['POST'])]
    public function createFicheTechnique(
        Request $request,
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return FicheTechniqueArtisteService::createFicheTechniqueArtiste(
            $ficheTechniqueArtisteRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour une fiche technique d'artiste existante.
     */
    #[Route('/api/v1/fiche-technique/{id}', name: 'update_fiche_technique', methods: ['PATCH'])]
    public function updateFicheTechnique(
        int $id,
        Request $request,
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return FicheTechniqueArtisteService::updateFicheTechniqueArtiste(
            $id,
            $ficheTechniqueArtisteRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime une fiche technique d'artiste.
     */
    #[Route('/api/v1/fiches-techniques/{id}', name: 'delete_fiche_technique', methods: ['DELETE'])]
    public function deleteFicheTechnique(
        int $id,
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return FicheTechniqueArtisteService::deleteFicheTechniqueArtiste(
            $id,
            $ficheTechniqueArtisteRepository,
            $serializer
        );
    }
}
