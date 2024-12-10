<?php

namespace App\Services;

use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * Class RegisterService
 * Est le gestionnaire des inscriptions utilisateurs (gestion de la logique métier)
 */
class RegisterService
{
    public static function register(
        JWTTokenManagerInterface $JWTManager,
        UtilisateurRepository $utilisateurRepository,
        UserPasswordHasherInterface $passwordHasher,
        SerializerInterface $serializer,
        mixed $data_register
    ): JsonResponse {
        return UtilisateurService::createUtilisateur(
            $JWTManager,
            $utilisateurRepository,
            $passwordHasher,
            $serializer,
            $data_register
        );
    }
}
