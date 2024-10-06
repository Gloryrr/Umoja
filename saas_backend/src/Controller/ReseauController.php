<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReseauRepository;
use App\Services\ReseauService;

class ReseauController extends AbstractController
{
    /**
     * Récupère tous les réseaux existants.
     *
     * @param ReseauRepository $ReseauRepository, la classe CRUD des réseaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reseaux', name: 'get_reseaux', methods: ['GET'])]
    public function getReseaux(
        ReseauRepository $ReseauRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return ReseauService::getReseaux(
            $ReseauRepository,
            $serializer
        );
    }

    /**
     * Crée un nouveau réseau.
     *
     * @param Request $request
     * @param ReseauRepository $ReseauRepository, la classe CRUD des réseaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reseau/create', name: 'create_reseau', methods: ['POST'])]
    public function createReseau(
        Request $request,
        ReseauRepository $ReseauRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ReseauService::createReseau(
            $ReseauRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour un genre  existant.
     *
     * @param int $id
     * @param Request $request
     * @param ReseauRepository $ReseauRepository, la classe CRUD des réseaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reseau/update/{id}', name: 'update_reseau', methods: ['PATCH'])]
    public function updateReseau(
        int $id,
        Request $request,
        ReseauRepository $ReseauRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ReseauService::updateReseau(
            $id,
            $ReseauRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime un réseau.
     *
     * @param int $id
     * @param ReseauRepository $ReseauRepository, la classe CRUD des réseaux
     * @return JsonResponse
     */
    #[Route('/api/v1/reseau/delete/{id}', name: 'delete_reseau', methods: ['DELETE'])]
    public function deleteReseau(
        int $id,
        ReseauRepository $ReseauRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return ReseauService::deleteReseau(
            $id,
            $ReseauRepository,
            $serializer
        );
    }

    // /**
    //  * Ajoute un utilisateur au réseau
    //  *
    //  * @param Request $requete, la requête avec les données d'jaout
    //  * @param ReseauRepository $ReseauRepository, la classe CRUD des réseaux
    //  * @return JsonResponse
    //  */
    // #[Route('/api/v1/reseau/add-membre', name: 'add_membre', methods: ['POST'])]
    // public function ajouteMembreReseau(
    //     Request $request,
    //     ReseauRepository $reseauRepository,
    //     UtilisateurRepository $utilisateurRepository,
    //     SerializerInterface $serializer
    // ): JsonResponse {
    //     $data = json_decode($request->getContent(), true);
    //     return ReseauService::ajouteMembreReseau(
    //         $data,
    //         $reseauRepository,
    //         $utilisateurRepository,
    //         $serializer
    //     );
    // }

    // /**
    //  * Supprime un utilisateur au réseau
    //  *
    //  * @param Request $request, la requête avec les données de suppression
    //  * @param ReseauRepository $ReseauRepository, la classe CRUD des réseaux
    //  * @return JsonResponse
    //  */
    // #[Route('/api/v1/reseau/delete-membre', name: 'delete_membre', methods: ['DELETE'])]
    // public function supprimeMembreReseau(
    //     int $id,
    //     ReseauRepository $ReseauRepository,
    //     SerializerInterface $serializer
    // ): JsonResponse {
    //     return ReseauService::supprimeMembre(
    //         $requete,
    //         $ReseauRepository,
    //         $serializer
    //     );
    // }
}
