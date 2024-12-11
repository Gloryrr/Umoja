<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use App\Repository\CommentaireRepository;
use App\Repository\OffreRepository;
use App\Repository\UtilisateurRepository;
use App\Services\CommentaireService;

class CommentaireController extends AbstractController
{
    /**
     * Récupère tous les commentaires existants.
     *
     * @param CommentaireRepository $commentaireRepository, la classe CRUD des commentaires
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/commentaires', name: 'get_commentaires', methods: ['GET'])]
    public function getCommentaires(
        CommentaireRepository $commentaireRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return CommentaireService::getCommentaires(
            $commentaireRepository,
            $serializer
        );
    }

    /**
     * Récupère un commentaire à partir de son id.
     *
     * @param int $id
     * @param CommentaireRepository $commentaireRepository, la classe CRUD des commentaires
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/commentaire/{id}', name: 'get_commentaire_by_id', methods: ['GET'])]
    public function getCommentaireById(
        int $id,
        CommentaireRepository $commentaireRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return CommentaireService::getCommentaireById(
            $id,
            $commentaireRepository,
            $serializer
        );
    }

    /**
     * Crée un nouveau commentaire.
     *
     * @param Request $request
     * @param CommentaireRepository $commentaireRepository, la classe CRUD des commentaires
     * @param OffreRepository $offreRepository, la classe CRUD des offres
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/commentaire/create', name: 'create_commentaire', methods: ['POST'])]
    public function createCommentaire(
        Request $request,
        CommentaireRepository $commentaireRepository,
        OffreRepository $offreRepository,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return CommentaireService::createCommentaire(
            $commentaireRepository,
            $offreRepository,
            $utilisateurRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour un commentaire existant.
     *
     * @param int $id
     * @param Request $request
     * @param CommentaireRepository $commentaireRepository, la classe CRUD des commentaires
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/commentaire/update/{id}', name: 'update_commentaire', methods: ['PATCH'])]
    public function updateCommentaire(
        int $id,
        Request $request,
        CommentaireRepository $commentaireRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return CommentaireService::updateCommentaire(
            $id,
            $commentaireRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime un commentaire.
     *
     * @param int $id
     * @param CommentaireRepository $commentaireRepository, la classe CRUD des commentaires
     * @return JsonResponse
     */
    #[Route('/api/v1/commentaire/delete/{id}', name: 'delete_commentaire', methods: ['DELETE'])]
    public function deleteCommentaire(
        int $id,
        CommentaireRepository $commentaireRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return CommentaireService::deleteCommentaire(
            $id,
            $commentaireRepository,
            $serializer
        );
    }
}
