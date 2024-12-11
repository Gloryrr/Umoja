<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReponseRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\OffreRepository;
use App\Repository\EtatReponseRepository;
use App\Services\ReponseService;

/**
 * Contrôleur pour l'entité Reponse.
 *
 * Gère les opérations CRUD de l'entité Reponse via une API REST.
 */
class ReponseController extends AbstractController
{
    /**
     * Récupère toutes les réponses existantes.
     *
     * @param ReponseRepository $reponseRepository, le repository CRUD des réponses
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reponses', name: 'get_reponses', methods: ['GET'])]
    public function getReponses(
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return ReponseService::getReponses(
            $reponseRepository,
            $serializer
        );
    }

    /**
     * Récupère toutes les réponses existantes pour une offre donnée.
     *
     * @param int $id, l'identifiant de l'offre
     * @param ReponseRepository $reponseRepository, le repository CRUD des réponses
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reponses/offre/{id}', name: 'get_reponses_pour_offre', methods: ['GET'])]
    public function getReponsesPourOffre(
        int $id,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return ReponseService::getReponsesPourOffre(
            $id,
            $reponseRepository,
            $serializer
        );
    }

    /**
     * Récupère une réponse par son id.
     *
     * @param int $id, l'identifiant de la réponse
     * @param ReponseRepository $reponseRepository, le repository CRUD des réponses
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reponse/{id}', name: 'get_reponses_by_id', methods: ['GET'])]
    public function getReponse(
        int $id,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return ReponseService::getReponse(
            $id,
            $reponseRepository,
            $serializer
        );
    }

    /**
     * Crée une nouvelle réponse.
     *
     * @param Request $request, les données de la nouvelle réponse
     * @param ReponseRepository $reponseRepository, le repository CRUD des réponses
     * @param UtilisateurRepository $utilisateurRepository, le repository CRUD des utilisateurs
     * @param OffreRepository $offreRepository, le repository CRUD des offres
     * @param EtatReponseRepository $etatReponseRepository, le repository CRUD des états de réponse
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reponse/create', name: 'create_reponse', methods: ['POST'])]
    public function createReponse(
        Request $request,
        ReponseRepository $reponseRepository,
        UtilisateurRepository $utilisateurRepository,
        OffreRepository $offreRepository,
        EtatReponseRepository $etatReponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ReponseService::createReponse(
            $reponseRepository,
            $utilisateurRepository,
            $offreRepository,
            $etatReponseRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour une réponse existante.
     *
     * @param int $id, l'identifiant de la réponse à mettre à jour
     * @param Request $request, les nouvelles données de la réponse
     * @param ReponseRepository $reponseRepository, le repository CRUD des réponses
     * @param EtatReponseRepository $etatReponseRepository, le repository CRUD des états de réponse
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reponse/update/{id}', name: 'update_reponse', methods: ['PATCH'])]
    public function updateReponse(
        int $id,
        Request $request,
        ReponseRepository $reponseRepository,
        EtatReponseRepository $etatReponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ReponseService::updateReponse(
            $id,
            $reponseRepository,
            $etatReponseRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime une réponse.
     *
     * @param int $id, l'identifiant de la réponse à supprimer
     * @param ReponseRepository $reponseRepository, le repository CRUD des réponses
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reponse/delete/{id}', name: 'delete_reponse', methods: ['DELETE'])]
    public function deleteReponse(
        int $id,
        ReponseRepository $reponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return ReponseService::deleteReponse(
            $id,
            $reponseRepository,
            $serializer
        );
    }
}
