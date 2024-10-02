<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UtilisateurRepository;

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
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data_login = json_decode($request->getContent(), true); // récupéaration des données de la requête

        if (empty($data_login['username'])) {
            $user = $utilisateurRepository->trouveUtilisateurByMail($data_login['email'], $data_login['password']);
        } else {
            $user = $utilisateurRepository->trouveUtilisateurByUsername(
                $data_login['username'],
                $data_login['password']
            );
        }
        print_r($user);

        if ($user) {
            $utilisateurJSON = $serializer->serialize($user, 'json');
            return new JsonResponse([
                'utilisateur' => $utilisateurJSON,
                'reponse' => Response::HTTP_OK,
                'headers' => [],
                'serialized' => true
            ]);
        }
        return new JsonResponse([
            'utilisateur' => null,
            'reponse' => Response::HTTP_NOT_FOUND,
            'headers' => [],
            'serialized' => false
        ]);
    }
}
