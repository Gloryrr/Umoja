<?php

namespace App\Controller;

use App\Repository\ArtisteRepository;
use App\Repository\ConcernerRepository;
use App\Repository\CreerRepository;
use App\Repository\GenreMusicalRepository;
use App\Repository\PosterRepository;
use App\Repository\RattacherRepository;
use App\Repository\ReseauRepository;
use App\Repository\UtilisateurRepository;
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
    #[Route('/api/v1/Offres', name: 'get_Offres', methods: ['GET'])]
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
        CreerRepository $creerRepository,
        ReseauRepository $reseauRepository,
        PosterRepository $posterRepository,
        RattacherRepository $rattacherRepository,
        GenreMusicalRepository $genreMusicalRepository,
        ArtisteRepository $artisteRepository,
        ConcernerRepository $concernerRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::createOffre(
            $offreRepository,
            $utilisateurRepository,
            $creerRepository,
            $reseauRepository,
            $posterRepository,
            $rattacherRepository,
            $genreMusicalRepository,
            $artisteRepository,
            $concernerRepository,
            $serializer,
            $data
        );
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
    #[Route('/api/v1/offre/update/{id}', name: 'update_offre', methods: ['PATCH'])]
    public function updateOffre(
        int $id,
        Request $request,
        OffreRepository $offreRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::updateOffre(
            $id,
            $offreRepository,
            $serializer,
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
     * @param ConcernerRepository $concernerRepository, CRUD des artistes qui sont concernés par des offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/add-artiste', name: 'add_artiste_offre', methods: ['POST'])]
    public function ajouteArtisteOffre(
        Request $request,
        OffreRepository $offreRepository,
        ArtisteRepository $artisteRepository,
        ConcernerRepository $concernerRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::ajouteArtisteOffre(
            $data,
            $offreRepository,
            $artisteRepository,
            $concernerRepository,
            $serializer
        );
    }

    /**
     * Supprime un artiste de l'offre
     *
     * @param Request $request, la requête avec les données de suppression
     * @param OffreRepository $offreRepository, la classe CRUD des offres
     * @param ArtisteRepository $artisteRepository, la classe CRUD des artistes
     * @param ConcernerRepository $concernerRepository, CRUD des artistes qui sont concernés par des offres
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/delete-artiste', name: 'delete_artiste_offre', methods: ['DELETE'])]
    public function supprimeMembreReseau(
        Request $request,
        OffreRepository $offreRepository,
        ArtisteRepository $artisteRepository,
        ConcernerRepository $concernerRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::retireArtisteOffre(
            $data,
            $offreRepository,
            $artisteRepository,
            $concernerRepository,
            $serializer
        );
    }

    /**
     * Ajoute un genre musical préféré à une offre
     *
     * @param Request $requete, la requête avec les données d'jaout
     * @param OffreRepository $offreRepository, la classe CRUD des offrex
     * @param GenreMusicalRepository $genreMusicalRepository, la classe CRUD des genres musicaux
     * @param RattacherRepository $rattacherRepository, la classe CRUD des utilisateurs qui appartiennent à des offrex
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/add-genre-musical', name: 'add_genre_musical_offre', methods: ['POST'])]
    public function ajouteGenreMusicalReseau(
        Request $request,
        OffreRepository $offreRepository,
        GenreMusicalRepository $genreMusicalRepository,
        RattacherRepository $rattacherRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::ajouteGenreMusicalReseau(
            $data,
            $offreRepository,
            $genreMusicalRepository,
            $rattacherRepository,
            $serializer
        );
    }

    /**
     * Retire un genre musical préféré du réseau
     *
     * @param Request $requete, la requête avec les données d'jaout
     * @param OffreRepository $offreRepository, la classe CRUD des réseaux
     * @param GenreMusicalRepository $genreMusicalRepository, la classe CRUD des genres musicaux
     * @param RattacherRepository $rattacherRepository, la classe CRUD des utilisateurs qui appartiennent à des réseaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/offre/delete-genre-musical', name: 'delete_genre_musical_offre', methods: ['DELETE'])]
    public function retireGenreMusicalReseau(
        Request $request,
        OffreRepository $offreRepository,
        GenreMusicalRepository $genreMusicalRepository,
        RattacherRepository $rattacherRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return OffreService::retireGenreMusicalReseau(
            $data,
            $offreRepository,
            $genreMusicalRepository,
            $rattacherRepository,
            $serializer
        );
    }
}
