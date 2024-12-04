<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UtilisateurRepository;
use App\Services\LoginService;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class LoginController extends AbstractController
{
    /**
     * Vérifie et accepte la connexion des utilisateurs pour leur compte.
     *
     * @param Request $request
     * @param JWTTokenManagerInterface $JWTManager, le service de gestion des tokens JWT
     * @param UserPasswordHasherInterface $passwordHasher, le service de hashage des mots de passe
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     *
     * @return JsonResponse
     */
    #[Route('/api/v1/login', name: 'login_user', methods: ['POST'])]
    public function login(
        JWTTokenManagerInterface $JWTManager,
        UtilisateurRepository $utilisateurRepository,
        UserPasswordHasherInterface $passwordHasher,
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse {
        // récupération des données de la requête pour la connexion
        $data_login = json_decode($request->getContent(), true);
        return LoginService::login(
            $JWTManager,
            $utilisateurRepository,
            $passwordHasher,
            $serializer,
            $data_login
        );
    }
}
