<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UtilisateurRepository;

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
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data_register = json_decode($request->getContent(), true); // récupéaration des données de la requête

        $utilisateur = $utilisateurRepository->inscritUtilisateur($data_register);

        print_r($utilisateur);

        if ($utilisateur) {
            $utilisateurJSON = $serializer->serialize($utilisateur, 'json');

            return new JsonResponse([
                'utilisateur' => $utilisateurJSON,
                'reponse' => Response::HTTP_CREATED,
                'headers' => [],
                'serialized' => true
            ]);
        }
        return new JsonResponse([
            'utilisateur' => null,
            'reponse' => Response::HTTP_BAD_REQUEST,
            'headers' => [],
            'serialized' => false
        ]);
    }
}
