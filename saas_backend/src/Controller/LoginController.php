<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UtilisateurRepository;
use App\Services\LoginService;

class LoginController extends AbstractController
{
    /**
     * Vérifie et accepte la connexion des utilisateurs pour leur compte.
     *
     * @param Request $request
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     *
     * @return JsonResponse
     */
    #[Route('/api/v1/login', name: 'login_user', methods: ['GET'])]
    public function login(
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse {
        // récupération des données de la requête pour la connexion
        $data_login = json_decode($request->getContent(), true);
        return LoginService::login(
            $utilisateurRepository, 
            $serializer,
            $data_login
        );
    }
}
