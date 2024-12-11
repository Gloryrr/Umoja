<?php

namespace App\Services;

use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * Class LoginService
 * Est le gestionnaire des connexions utilisateurs à leur compte (gestion de la logique métier)
 */
class LoginService
{
    public static function login(
        JWTTokenManagerInterface $JWTManager,
        UtilisateurRepository $utilisateurRepository,
        UserPasswordHasherInterface $passwordHasher,
        SerializerInterface $serializer,
        mixed $data_login
    ): JsonResponse {
        try {
            // on cherche l'utilisateur par son username
            $authentification_valide = false;
            if (isset($data_login['username']) && isset($data_login['mdpUtilisateur'])) {
                $user = $utilisateurRepository->trouveUtilisateurByUsername($data_login['username']);
                if (empty($user)) {
                    return new JsonResponse([
                        'utilisateur' => null,
                        'message' => 'Utilisateur non trouvé, merci de fournir un identifiant correct',
                        'headers' => [],
                        'serialized' => true
                    ], Response::HTTP_NOT_FOUND);
                }
                if ($passwordHasher->isPasswordValid($user[0], $data_login['mdpUtilisateur'])) {
                    $authentification_valide = true;
                    $token = $JWTManager->create($user[0]);
                }
            }

            // vérification du mode de connexion (par mail ou username)
            // si utilisateur trouvé, alors on renvoie les infos utilisateurs
            if ($authentification_valide) {
                $utilisateurJSON = $serializer->serialize(
                    $user,
                    'json',
                    ['groups' => ['utilisateur:read']]
                );
                return new JsonResponse([
                    'utilisateur' => $utilisateurJSON,
                    'token' => $token,
                    'message' => 'Utilisateur connecté',
                    'headers' => [],
                    'serialized' => true
                ], Response::HTTP_OK);
            }
            // sinon, on renvoie un JSON d'erreur
            return new JsonResponse([
                'utilisateur' => null,
                'message' => 'Données manquantes, merci de spécifier le username et mdpUtilisateur',
                'headers' => [],
                'serialized' => false
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            throw new \Exception("Erreur lors de la connexion", $e->getCode());
        }
    }
}
