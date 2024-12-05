<?php

namespace App\Controller;

use App\Repository\GenreMusicalRepository;
use App\Repository\PreferenceNotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UtilisateurRepository;
use App\Services\UtilisateurService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

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
     * Récupère un utilisateur par son nom.
     *
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/utilisateur', name: 'get_utilisateurs_by_name', methods: ['POST'])]
    public function getUtilisateur(
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return UtilisateurService::getUtilisateur(
            $utilisateurRepository,
            $data,
            $serializer
        );
    }

    /**
     * Crée un nouvel utilisateur.
     *
     * @param Request $request
     * @param JWTTokenManagerInterface $JWTManager, le service de gestion des tokens JWT
     * @param UserPasswordHasherInterface $passwordHasher, le service de hashage des mots de passe
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/utilisateurs/create', name: 'create_utilisateur', methods: ['POST'])]
    public function createUtilisateur(
        Request $request,
        JWTTokenManagerInterface $JWTManager,
        UtilisateurRepository $utilisateurRepository,
        UserPasswordHasherInterface $passwordHasher,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return UtilisateurService::createUtilisateur(
            $JWTManager,
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
     *  CRUD des utilisateurs qui ont des genres préférés
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/utilisateur/add-genre-musical', name: 'add_genre_musical', methods: ['POST'])]
    public function ajouteGenreMusicalUtilisateur(
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return UtilisateurService::ajouteGenreMusicalUtilisateur(
            $data,
            $utilisateurRepository,
            $genreMusicalRepository,
            $serializer
        );
    }

    /**
     * Retire un genre musical préféré aux préférences de l'utilisateur
     *
     * @param Request $requete, la requête avec les données d'ajout
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     *  CRUD des utilisateurs qui ont des genres préférés
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/utilisateur/delete-genre-musical', name: 'delete_genre_musical', methods: ['DELETE'])]
    public function retireGenreMusicalUtilisateur(
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        GenreMusicalRepository $genreMusicalRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return UtilisateurService::retireGenreMusicalUtilisateur(
            $data,
            $utilisateurRepository,
            $genreMusicalRepository,
            $serializer
        );
    }

    /**
     * Récupère les préférences de notification d'un utilisateur.
     *
     * @param string $username, le nom de l'utilisateur
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param PreferenceNotificationRepository $preferenceNotificationRepository, la classe CRUD des préférences.
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route(
        '/api/v1/utilisateur/preference-notification/{username}',
        name: 'get_preference_notification_utilisateur',
        methods: ['GET']
    )]
    public function getPreferenceNotificationUtilisateur(
        string $username,
        UtilisateurRepository $utilisateurRepository,
        PreferenceNotificationRepository $preferenceNotificationRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        return UtilisateurService::getPreferenceNotificationUtilisateur(
            $username,
            $utilisateurRepository,
            $preferenceNotificationRepository,
            $serializer
        );
    }

    /**
     * Mets à jour les préférences de notification d'un utilisateur.
     *
     * @param string $username, le nom de l'utilisateur
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param PreferenceNotificationRepository $preferenceNotificationRepository, la classe CRUD des préférences.
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route(
        '/api/v1/utilisateur/preference-notification/update/{username}',
        name: 'get_preference_update_notification_utilisateur',
        methods: ['PATCH']
    )]
    public function updatePreferenceNotificationUtilisateur(
        string $username,
        UtilisateurRepository $utilisateurRepository,
        PreferenceNotificationRepository $preferenceNotificationRepository,
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return UtilisateurService::updatePreferenceNotificationUtilisateur(
            $username,
            $utilisateurRepository,
            $preferenceNotificationRepository,
            $serializer,
            $data
        );
    }
}
