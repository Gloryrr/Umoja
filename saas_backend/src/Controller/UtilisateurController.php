<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UtilisateurRepository;
use App\Services\UtilisateurService;

class UtilisateurController extends AbstractController
{
    /**
     * Récupère tous les utilisateurs.
     *
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/utilisateurs', name: 'get_utilisateurs', methods: ['GET'])]
    public function getUtilisateurs(
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return UtilisateurService::getUtilisateurs(
            $utilisateurRepository,
            $serializer
        );
    }

    /**
     * Crée un nouvel utilisateur.
     *
     * @param Request $request
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/utilisateurs/create', name: 'create_utilisateur', methods: ['POST'])]
    public function createUtilisateur(
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return UtilisateurService::createUtilisateur(
            $utilisateurRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour un utilisateur existant.
     *
     * @param int $id
     * @param Request $request
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/utilisateurs/update/{id}', name: 'update_utilisateur', methods: ['PATCH'])]
    public function updateUtilisateur(
        int $id,
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return UtilisateurService::updateUtilisateur(
            $id,
            $utilisateurRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime un utilisateur.
     *
     * @param int $id
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @return JsonResponse
     */
    #[Route('/api/v1/utilisateurs/delete/{id}', name: 'delete_utilisateur', methods: ['DELETE'])]
    public function deleteUtilisateur(
        int $id,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return UtilisateurService::deleteUtilisateur(
            $id,
            $utilisateurRepository,
            $serializer
        );
    }
}
