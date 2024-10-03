<?php

namespace App\Controller;

use App\Entity\FicheTechniqueArtiste;
use App\Repository\FicheTechniqueArtisteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;

class FicheTechniqueArtisteController extends AbstractController
{
    private FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        FicheTechniqueArtisteRepository $ficheTechniqueArtisteRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->ficheTechniqueArtisteRepository = $ficheTechniqueArtisteRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * Récupère toutes les fiches techniques d'artistes.
     */
    #[Route('/api/v1/fiches-techniques', name: 'get_fiches_techniques', methods: ['GET'])]
    public function getFichesTechniques(SerializerInterface $serializer): JsonResponse
    {
        $fiches = $this->ficheTechniqueArtisteRepository->findAll();
        $fichesJSON = $serializer->serialize($fiches, 'json');

        return new JsonResponse([
            'fiches' => $fichesJSON,
            'response' => Response::HTTP_OK,
            'serialized' => true
        ]);
    }

    /**
     * Crée une nouvelle fiche technique d'artiste.
     */
    #[Route('/api/v1/fiches-techniques', name: 'create_fiche_technique', methods: ['POST'])]
    public function createFicheTechnique(Request $request, SerializerInterface $serializer): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $fiche = new FicheTechniqueArtiste();
        $fiche->setBesoinSonorisation($data['besoinSonorisation'] ?? null);
        $fiche->setBesoinEclairage($data['besoinEclairage'] ?? null);
        $fiche->setBesoinScene($data['besoinScene'] ?? null);
        $fiche->setBesoinBackline($data['besoinBackline'] ?? null);
        $fiche->setBesoinEquipements($data['besoinEquipements'] ?? null);

        $this->entityManager->persist($fiche);
        $this->entityManager->flush();

        $ficheJSON = $serializer->serialize($fiche, 'json');

        return new JsonResponse([
            'fiche' => $ficheJSON,
            'response' => Response::HTTP_CREATED,
            'serialized' => true
        ]);
    }

    /**
     * Met à jour une fiche technique d'artiste existante.
     */
    #[Route('/api/v1/fiches-techniques/{id}', name: 'update_fiche_technique', methods: ['PATCH'])]
    public function updateFicheTechnique(int $id, Request $request, SerializerInterface $serializer): JsonResponse
    {
        $fiche = $this->ficheTechniqueArtisteRepository->find($id);

        if (!$fiche) {
            return new JsonResponse([
                'message' => 'Fiche technique non trouvée, merci de donner un identifiant valide !',
                'response' => Response::HTTP_NOT_FOUND
            ]);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['besoinSonorisation'])) {
            $fiche->setBesoinSonorisation($data['besoinSonorisation']);
        }
        if (isset($data['besoinEclairage'])) {
            $fiche->setBesoinEclairage($data['besoinEclairage']);
        }
        if (isset($data['besoinScene'])) {
            $fiche->setBesoinScene($data['besoinScene']);
        }
        if (isset($data['besoinBackline'])) {
            $fiche->setBesoinBackline($data['besoinBackline']);
        }
        if (isset($data['besoinEquipements'])) {
            $fiche->setBesoinEquipements($data['besoinEquipements']);
        }

        $this->entityManager->flush();

        $ficheJSON = $serializer->serialize($fiche, 'json');

        return new JsonResponse([
            'fiche' => $ficheJSON,
            'response' => Response::HTTP_OK,
            'serialized' => true
        ]);
    }

    /**
     * Supprime une fiche technique d'artiste.
     */
    #[Route('/api/v1/fiches-techniques/{id}', name: 'delete_fiche_technique', methods: ['DELETE'])]
    public function deleteFicheTechnique(int $id): JsonResponse
    {
        $fiche = $this->ficheTechniqueArtisteRepository->find($id);

        if (!$fiche) {
            return new JsonResponse([
                'message' => 'Fiche technique non trouvée, merci de fournir un identifiant valide',
                'response' => Response::HTTP_NOT_FOUND
            ]);
        }

        $this->entityManager->remove($fiche);
        $this->entityManager->flush();

        return new JsonResponse([
            'message' => 'Fiche technique supprimée',
            'response' => Response::HTTP_NO_CONTENT
        ]);
    }
}
