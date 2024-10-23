<?php

namespace App\Controller;

use App\Repository\AppartenirRepository;
use App\Repository\GenreMusicalRepository;
use App\Repository\PreferencerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UtilisateurRepository;
use App\Services\UtilisateurService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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
        AppartenirRepository $appartenirRepository,
        PreferencerRepository $preferencerRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return UtilisateurService::getUtilisateurs(
            $utilisateurRepository,
            $appartenirRepository,
            $preferencerRepository,
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
        UserPasswordHasherInterface $passwordHasher,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return UtilisateurService::createUtilisateur(
            $utilisateurRepository,
            $passwordHasher,
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

    /**
     * Ajoute un genre musical préféré à l'utilisateur
     *
     * @param Request $requete, la requête avec les données d'ajout
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param PreferencerRepository $preferencerRepository, CRUD des utilisateurs qui ont des genres préférés
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/utilisateur/add-genre-musical', name: 'add_genre_musical', methods: ['POST'])]
    public function ajouteGenreMusicalUtilisateur(
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        PreferencerRepository $preferencerRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return UtilisateurService::ajouteGenreMusicalUtilisateur(
            $data,
            $utilisateurRepository,
            $preferencerRepository,
            $genreMusicalRepository,
            $serializer
        );
    }

    /**
     * Retire un genre musical préféré aux préférences de l'utilisateur
     *
     * @param Request $requete, la requête avec les données d'ajout
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param PreferencerRepository $preferencerRepository, CRUD des utilisateurs qui ont des genres préférés
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/utilisateur/delete-genre-musical', name: 'delete_genre_musical', methods: ['DELETE'])]
    public function retireGenreMusicalUtilisateur(
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        PreferencerRepository $preferencerRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return UtilisateurService::retireGenreMusicalUtilisateur(
            $data,
            $utilisateurRepository,
            $preferencerRepository,
            $genreMusicalRepository,
            $serializer
        );
    }
}
