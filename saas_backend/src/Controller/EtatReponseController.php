<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\EtatReponseRepository;
use App\Services\EtatReponseService;

class EtatReponseController extends AbstractController
{
    /**
     * Récupère tous les états de réponse existants.
     *
     * @param EtatReponseRepository $etatReponseRepository, la classe CRUD des états de réponse
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/etats-reponse', name: 'get_etats_reponse', methods: ['GET'])]
    public function getEtatsReponse(
        EtatReponseRepository $etatReponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return EtatReponseService::getEtatsReponse(
            $etatReponseRepository,
            $serializer
        );
    }

    /**
     * Crée un nouvel état de réponse.
     *
     * @param Request $request
     * @param EtatReponseRepository $etatReponseRepository, la classe CRUD des états de réponse
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/etat-reponse/create', name: 'create_etat_reponse', methods: ['POST'])]
    public function createEtatReponse(
        Request $request,
        EtatReponseRepository $etatReponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return EtatReponseService::createEtatReponse(
            $etatReponseRepository,
            $serializer,
            $data
        );
    }

    /**
     * Met à jour un état de réponse existant.
     *
     * @param int $id
     * @param Request $request
     * @param EtatReponseRepository $etatReponseRepository, la classe CRUD des états de réponse
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/etat-reponse/update/{id}', name: 'update_etat_reponse', methods: ['PATCH'])]
    public function updateEtatReponse(
        int $id,
        Request $request,
        EtatReponseRepository $etatReponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return EtatReponseService::updateEtatReponse(
            $id,
            $etatReponseRepository,
            $serializer,
            $data
        );
    }

    /**
     * Supprime un état de réponse.
     *
     * @param int $id
     * @param EtatReponseRepository $etatReponseRepository, la classe CRUD des états de réponse
     * @return JsonResponse
     */
    #[Route('/api/v1/etat-reponse/delete/{id}', name: 'delete_etat_reponse', methods: ['DELETE'])]
    public function deleteEtatReponse(
        int $id,
        EtatReponseRepository $etatReponseRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return EtatReponseService::deleteEtatReponse(
            $id,
            $etatReponseRepository,
            $serializer
        );
    }
}