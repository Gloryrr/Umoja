<?php

namespace App\Services;

use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\DTO\UtilisateurDTO;

/**
 * Class LoginService
 * Est le gestionnaire des connexions utilisateurs à leur compte (gestion de la logique métier)
 */
class LoginService
{
    public static function login(
        UtilisateurRepository $utilisateurRepository,
        UserPasswordHasherInterface $passwordHasher,
        SerializerInterface $serializer,
        mixed $data_login
    ): JsonResponse {
        try {
            // on cherche l'utilisateur par son username
            $authentification_valide = false;
            if (isset($data_login['username']) && isset($data_login['mdpUtilisateur'])) {
                $user = $utilisateurRepository->trouveUtilisateurByUsername(
                    $data_login['username']
                );
                if ($passwordHasher->isPasswordValid($user[0], $data_login['mdpUtilisateur'])) {
                    $authentification_valide = true;
                }
            }

            $utilisateurDTO = new UtilisateurDTO(
                $user[0]->getIdUtilisateur(),
                $user[0]->getEmailUtilisateur(),
                $user[0]->getRoles(),
                $user[0]->getUsername(),
                $user[0]->getNomUtilisateur(),
                $user[0]->getPrenomUtilisateur()
            );

            // vérification du mode de connexion (par mail ou username)
            // si utilisateur trouvé, alors on renvoie les infos utilisateurs
            if ($authentification_valide) {
                $utilisateurJSON = $serializer->serialize($utilisateurDTO, 'json');
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
