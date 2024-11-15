<?php

namespace App\Controller;

use App\Repository\ArtisteRepository;
use App\Repository\GenreMusicalRepository;
use App\Repository\ReseauRepository;
use App\Repository\UtilisateurRepository;
use App\Services\MailerService;
use App\Services\OffreService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\OffreRepository;

class OffreController extends AbstractController
{
    /**
     * Récupère tous les Offres.
     *
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offres', name: 'get_Offres', methods: ['GET'])]
    public function getOffres(
        OffreRepository $offreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return OffreService::getOffres(
            $offreRepository,
            $serializer
        );
    }

    /**
     * Récupère une offre en particulière en fonction de son id.
     *
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre', name: 'get_offre', methods: ['POST'])]
    public function getOffre(
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::getOffre(
            $offreRepository,
            $serializer,
            $data
        );
    }

    /**
     * Récupère toutes les offres qui sont liés à un utilisateur en particulier.
     *
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/utilisateur/{id}', name: 'get_offre_by_utilisateur', methods: ['GET'])]
    public function getOffreByUtilisateur(
        int $id,
        OffreRepository $offreRepository,
        SerializerInterface $serializer,
    ): JsonResponse {
        return OffreService::getOffreByUtilisateur(
            $offreRepository,
            $serializer,
            $id
        );
    }

    /**
     * Crée une nouvelle Offre.
     *
     * @param Request $request
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/create', name: 'create_offre', methods: ['POST'])]
    public function createOffre(
        Request $request,
        OffreRepository $offreRepository,
        UtilisateurRepository $utilisateurRepository,
        ReseauRepository $reseauRepository,
        GenreMusicalRepository $genreMusicalRepository,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer,
        MailerService $mailerService
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::createOffre(
            $offreRepository,
            $utilisateurRepository,
            $reseauRepository,
            $genreMusicalRepository,
            $artisteRepository,
            $serializer,
            $mailerService,
            $data
        );
    }


    /**
     * Met à jour une Offre existante.
     *
     * @param int $id
     * @param Request $request
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @param MailerService $mailerService, le service d'envoi de mail
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/update/{id}', name: 'update_offre', methods: ['PATCH'])]
    public function updateOffre(
        int $id,
        Request $request,
        OffreRepository $offreRepository,
        MailerService $mailerService,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::updateOffre(
            $id,
            $offreRepository,
            $serializer,
            $mailerService,
            $data
        );
    }

    /**
     * Supprime une Offre.
     *
     * @param int $id
     * @param OffreRepository $offreRepository, la classe CRUD des Offres
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/delete/{id}', name: 'delete_offre', methods: ['DELETE'])]
    public function deleteOffre(
        int $id,
        OffreRepository $offreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return OffreService::deleteOffre(
            $id,
            $offreRepository,
            $serializer
        );
    }

    /**
     * Ajoute un artiste à l'offre
     *
     * @param Request $requete, la requête avec les données d'ajout
     * @param OffreRepository $offreRepository, la classe CRUD des offres
     * @param ArtisteRepository $artisteRepository, la classe CRUD des artistes
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/add-artiste', name: 'add_artiste_offre', methods: ['POST'])]
    public function ajouteArtisteOffre(
        Request $request,
        OffreRepository $offreRepository,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::ajouteArtisteOffre(
            $data,
            $offreRepository,
            $artisteRepository,
            $serializer
        );
    }

    /**
     * Supprime un artiste de l'offre
     *
     * @param Request $request, la requête avec les données de suppression
     * @param OffreRepository $offreRepository, la classe CRUD des offres
     * @param ArtisteRepository $artisteRepository, la classe CRUD des artistes
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/delete-artiste', name: 'delete_artiste_offre', methods: ['DELETE'])]
    public function supprimeMembreReseau(
        Request $request,
        OffreRepository $offreRepository,
        ArtisteRepository $artisteRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::retireArtisteOffre(
            $data,
            $offreRepository,
            $artisteRepository,
            $serializer
        );
    }

    /**
     * Ajoute un genre musical préféré à une offre
     *
     * @param Request $requete, la requête avec les données d'jaout
     * @param OffreRepository $offreRepository, la classe CRUD des offrex
     * @param GenreMusicalRepository $genreMusicalRepository, la classe CRUD des genres musicaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/add-genre-musical', name: 'add_genre_musical_offre', methods: ['POST'])]
    public function ajouteGenreMusicalReseau(
        Request $request,
        OffreRepository $offreRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::ajouteGenreMusicalReseau(
            $data,
            $offreRepository,
            $genreMusicalRepository,
            $serializer
        );
    }

    /**
     * Retire un genre musical préféré du réseau
     *
     * @param Request $requete, la requête avec les données d'jaout
     * @param OffreRepository $offreRepository, la classe CRUD des réseaux
     * @param GenreMusicalRepository $genreMusicalRepository, la classe CRUD des genres musicaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/delete-genre-musical', name: 'delete_genre_musical_offre', methods: ['DELETE'])]
    public function retireGenreMusicalReseau(
        Request $request,
        OffreRepository $offreRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::retireGenreMusicalReseau(
            $data,
            $offreRepository,
            $genreMusicalRepository,
            $serializer
        );
    }
}
