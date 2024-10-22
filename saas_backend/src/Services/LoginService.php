<?php

namespace App\Services;

use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginService
 * Est le gestionnaire des connexions utilisateurs à leur compte (gestion de la logique métier)
 */
class LoginService
{
    public static function login(
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
        mixed $data_login
    ): JsonResponse {
        try {
            // si l'utilisateur se connecte ne utilisant son email
            if (!isset($data_login['username'])) {
                $user = $utilisateurRepository->trouveUtilisateurByMailAndMDP(
                    $data_login['emailUtilisateur'],
                    $data_login['mdpUtilisateur']
                );
            } else {
                $user = $utilisateurRepository->trouveUtilisateurByUsernameAndMDP(
                    $data_login['username'],
                    $data_login['mdpUtilisateur']
                );
            }

            // vérification du mode de connexion (par mail ou username)
            // si utilisateur trouvé, alors on renvoie les infos utilisateurs
            if ($user != null) {
                $utilisateurJSON = $serializer->serialize($user, 'json');
                return new JsonResponse([
                    'utilisateur' => $utilisateurJSON,
                    'reponse' => Response::HTTP_OK,
                    'headers' => [],
                    'serialized' => true
                ]);
            }
            // sinon, on renvoie un JSON d'erreur
            return new JsonResponse([
                'utilisateur' => null,
                'reponse' => Response::HTTP_NOT_FOUND,
                'headers' => [],
                'serialized' => false
            ]);
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la connexion", $e->getCode());
        }
    }
}
