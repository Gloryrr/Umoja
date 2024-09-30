<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UtilisateurRepository;

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
        $utilisateurs = $utilisateurRepository->findAll();
        $utilisateursJSON = $serializer->serialize($utilisateurs, 'json');
        return new JsonResponse([
            'utilisateurs' => $utilisateursJSON,
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Crée un nouvel utilisateur.
     *
     * @param Request $request
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @param SerializerInterface $serializer, le serializer JSON pour les réponses
     * @return JsonResponse
     */
    #[Route('/api/v1/utilisateurs', name: 'create_utilisateur', methods: ['POST'])]
    public function createUtilisateur(
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $utilisateur = new Utilisateur();
        $utilisateur->setEmailUtilisateur($data['emailUtilisateur']);
        $utilisateur->setMdpUtilisateur($data['mdpUtilisateur']);
        $utilisateur->setRoleUtilisateur($data['roleUtilisateur']);
        $utilisateur->setUsername($data['username']);
        $utilisateur->setNumTelUtilisateur($data['numTelUtilisateur'] ?? null);
        $utilisateur->setNomUtilisateur($data['nomUtilisateur'] ?? null);
        $utilisateur->setPrenomUtilisateur($data['prenomUtilisateur'] ?? null);

        $utilisateurRepository->save($utilisateur, true);
        $utilisateurJSON = $serializer->serialize($utilisateur, 'json');

        return new JsonResponse([
            'utilisateur' => $utilisateurJSON,
            'reponse' => Response::HTTP_CREATED,
            'headers' => [],
            'serialized' => true
        ]);
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
    #[Route('/api/v1/utilisateurs/{id}', name: 'update_utilisateur', methods: ['PATCH'])]
    public function updateUtilisateur(
        int $id,
        Request $request,
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer
    ): JsonResponse {
        $utilisateur = $utilisateurRepository->find($id);

        if (!$utilisateur) {
            return new JsonResponse([
                'message' => 'Utilisateur non trouvé, merci de donner un identifiant valide !',
                'reponse' => Response::HTTP_NOT_FOUND
            ]);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['emailUtilisateur'])) {
            $utilisateur->setEmailUtilisateur($data['emailUtilisateur']);
        }
        if (isset($data['mdpUtilisateur'])) {
            $utilisateur->setMdpUtilisateur($data['mdpUtilisateur']);
        }
        if (isset($data['roleUtilisateur'])) {
            $utilisateur->setRoleUtilisateur($data['roleUtilisateur']);
        }
        if (isset($data['username'])) {
            $utilisateur->setUsername($data['username']);
        }
        if (isset($data['numTelUtilisateur'])) {
            $utilisateur->setNumTelUtilisateur($data['numTelUtilisateur']);
        }
        if (isset($data['nomUtilisateur'])) {
            $utilisateur->setNomUtilisateur($data['nomUtilisateur']);
        }
        if (isset($data['prenomUtilisateur'])) {
            $utilisateur->setPrenomUtilisateur($data['prenomUtilisateur']);
        }

        $utilisateurRepository->save($utilisateur, true);
        $utilisateurJSON = $serializer->serialize($utilisateur, 'json');

        return new JsonResponse([
            'utilisateur' => $utilisateurJSON,
            'reponse' => Response::HTTP_OK,
            'headers' => [],
            'serialized' => true
        ]);
    }

    /**
     * Supprime un utilisateur.
     *
     * @param int $id
     * @param UtilisateurRepository $utilisateurRepository, la classe CRUD des utilisateurs
     * @return JsonResponse
     */
    #[Route('/api/v1/utilisateurs/{id}', name: 'delete_utilisateur', methods: ['DELETE'])]
    public function deleteUtilisateur(int $id, UtilisateurRepository $utilisateurRepository): JsonResponse
    {
        $utilisateur = $utilisateurRepository->find($id);

        if (!$utilisateur) {
            return new JsonResponse([
                'message' => 'Utilisateur non trouvé, merci de fournir un identifiant valide',
                'reponse' => Response::HTTP_NOT_FOUND
            ]);
        }

        $utilisateurRepository->remove($utilisateur, true);

        return new JsonResponse([
            'message' => 'Utilisateur supprimé',
            'reponse' => Response::HTTP_NO_CONTENT
        ]);
    }
}
