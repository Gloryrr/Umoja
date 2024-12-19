<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ReseauRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\GenreMusicalRepository;
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
     * Récupère les informations d'un réseau par rapport à son nom.
     *
     * @param ReseauRepository $ReseauRepository, la classe CRUD des réseaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reseau', name: 'get_reseau_by_name', methods: ['POST'])]
    public function getReseauByName(
        Request $request,
        ReseauRepository $ReseauRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ReseauService::getReseauByName(
            $data['nomReseau'],
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
     * @param int $id, l'id du réseau à mettre à jour
     * @param Request $request, la requête avec les données de mises à jour
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
     * @param int $id, l'id du réseau à supprimer
     * @param ReseauRepository $ReseauRepository, la classe CRUD des réseaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
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

    /**
     * Ajoute un utilisateur au réseau
     *
     * @param Request $requete, la requête avec les données d'jaout
     * @param ReseauRepository $reseauRepository, la classe CRUD des réseaux
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reseau/add-membre', name: 'add_membre', methods: ['POST'])]
    public function ajouteMembreReseau(
        Request $request,
        ReseauRepository $reseauRepository,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ReseauService::ajouteMembreReseau(
            $data,
            $reseauRepository,
            $utilisateurRepository,
            $serializer
        );
    }

    /**
     * Supprime un utilisateur au réseau
     *
     * @param Request $request, la requête avec les données de suppression
     * @param ReseauRepository $reseauRepository, la classe CRUD des réseaux
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reseau/delete-membre', name: 'delete_membre', methods: ['DELETE'])]
    public function supprimeMembreReseau(
        Request $request,
        ReseauRepository $reseauRepository,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ReseauService::retireMembreReseau(
            $data,
            $reseauRepository,
            $utilisateurRepository,
            $serializer
        );
    }

    /**
     * Ajoute un genre musical préféré au réseau
     *
     * @param Request $requete, la requête avec les données d'jaout
     * @param ReseauRepository $reseauRepository, la classe CRUD des réseaux
     * @param GenreMusicalRepository $genreMusicalRepository, la classe CRUD des genres musicaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reseau/add-genre-musical', name: 'add_genre_musical', methods: ['POST'])]
    public function ajouteGenreMusicalReseau(
        Request $request,
        ReseauRepository $reseauRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ReseauService::ajouteGenreMusicalReseau(
            $data,
            $reseauRepository,
            $genreMusicalRepository,
            $serializer
        );
    }

    /**
     * Retire un genre musical préféré du réseau
     *
     * @param Request $requete, la requête avec les données d'jaout
     * @param ReseauRepository $reseauRepository, la classe CRUD des réseaux
     * @param GenreMusicalRepository $genreMusicalRepository, la classe CRUD des genres musicaux
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/reseau/delete-genre-musical', name: 'delete_genre_musical_reseau', methods: ['DELETE'])]
    public function retireGenreMusicalReseau(
        Request $request,
        ReseauRepository $reseauRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return ReseauService::retireGenreMusicalReseau(
            $data,
            $reseauRepository,
            $genreMusicalRepository,
            $serializer
        );
    }
}
