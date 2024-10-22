<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UtilisateurRepository;
use App\Services\RegisterService;

class RegisterController extends AbstractController
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
    #[Route('/api/v1/register', name: 'register_user', methods: ['POST'])]
    public function register(
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
        Request $request
    ): JsonResponse {
        // récupéaration des données de la requête
        $data_register = json_decode($request->getContent(), true);
        return RegisterService::register(
            $utilisateurRepository,
            $serializer,
            $data_register
        );
    }
}
