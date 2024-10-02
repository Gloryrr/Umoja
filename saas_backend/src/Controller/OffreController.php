<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\OffreRepository;

class OffreController extends AbstractController
{
    /**
     * Récupère tous les Offres.
     *
     * @param OffreRepository $OffreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/Offres', name: 'get_Offres', methods: ['GET'])]
    public function getOffres(
        OffreRepository $OffreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $Offres = $OffreRepository->findAll();
        $OffresJSON = $serializer->serialize($Offres, 'json');
        return new JsonResponse([
            'Offres' => $OffresJSON,
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Crée une nouvelle Offre.
     *
     * @param Request $request
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/Offres', name: 'create_offre', methods: ['POST'])]
    public function createOffre(
        Request $request,
        OffreRepository $offreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $offre = new Offre();
        $offre->setDescrTournee($data['descrTournee']);
        $offre->setDateMinProposee(new \DateTime($data['dateMinProposee']));
        $offre->setDateMaxProposee(new \DateTime($data['dateMaxProposee']));
        $offre->setVilleVisee($data['villeVisee']);
        $offre->setRegionVisee($data['regionVisee']);
        $offre->setPlaceMin($data['placeMin']);
        $offre->setPlaceMax($data['placeMax']);
        $offre->setDateLimiteReponse(new \DateTime($data['dateLimiteReponse']));
        $offre->setValidee($data['validee']);

        // Supposons que 'ArtisteConcerne' est passé un d'artiste existant
        $artiste = $offreRepository->find($data['IdArtisteConcerne']);
        $offre->setArtisteConcerne($artiste);

        // Sauvegarde de l'offre dans la base de données

        $offreRepository->getEntityManager()->persist($offre);
        $offreRepository->getEntityManager()->flush();

        // Sérialisation de l'offre en JSON
        $offreJSON = $serializer->serialize($offre, 'json');

        return new JsonResponse([
            'offre' => $offreJSON,
            'reponse' => Response::HTTP_CREATED,
            'headers' => [],
            'serialized' => true
        ], Response::HTTP_CREATED);
    }


    /**
     * Met à jour une Offre existante.
     *
     * @param int $id
     * @param Request $request
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/Offres/{id}', name: 'update_offre', methods: ['PATCH'])]
    public function updateOffre(
        int $id,
        Request $request,
        OffreRepository $offreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $offre = $offreRepository->find($id);

        if (!$offre) {
            return new JsonResponse([
                'message' => 'Offre non trouvée, merci de donner un identifiant valide !',
                'reponse' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        // Mise à jour des champs de l'offre seulement si présents dans la requête
        if (isset($data['descrTournee'])) {
            $offre->setDescrTournee($data['descrTournee']);
        }
        if (isset($data['dateMinProposee'])) {
            $offre->setDateMinProposee(new \DateTime($data['dateMinProposee']));
        }
        if (isset($data['dateMaxProposee'])) {
            $offre->setDateMaxProposee(new \DateTime($data['dateMaxProposee']));
        }
        if (isset($data['villeVisee'])) {
            $offre->setVilleVisee($data['villeVisee']);
        }
        if (isset($data['regionVisee'])) {
            $offre->setRegionVisee($data['regionVisee']);
        }
        if (isset($data['placeMin'])) {
            $offre->setPlaceMin($data['placeMin']);
        }
        if (isset($data['placeMax'])) {
            $offre->setPlaceMax($data['placeMax']);
        }
        if (isset($data['dateLimiteReponse'])) {
            $offre->setDateLimiteReponse(new \DateTime($data['dateLimiteReponse']));
        }
        if (isset($data['validee'])) {
            $offre->setValidee($data['validee']);
        }

        // Persist et flush pour mettre à jour l'offre dans la base de données
        $offreRepository->getEntityManager()->persist($offre);
        $offreRepository->getEntityManager()->flush();

        // Sérialisation de l'offre mise à jour en JSON
        $offreJSON = $serializer->serialize($offre, 'json');

        return new JsonResponse([
            'offre' => $offreJSON,
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Supprime une Offre.
     *
     * @param int $id
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @return JsonResponse
     */
    #[Route('/api/v1/Offres/{id}', name: 'delete_offre', methods: ['DELETE'])]
    public function deleteOffre(int $id, OffreRepository $offreRepository): JsonResponse
    {
        $offre = $offreRepository->find($id);

        if (!$offre) {
            return new JsonResponse([
                'message' => 'Offre non trouvée, merci de fournir un identifiant valide.',
                'reponse' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }

        //supprimer l'offre
        $offreRepository->getEntityManager()->remove($offre);
        $offreRepository->getEntityManager()->flush();

        return new JsonResponse([
            'message' => 'Offre supprimée avec succès.',
            'reponse' => Response::HTTP_NO_CONTENT
        ], Response::HTTP_NO_CONTENT);
    }
}
