<?php

namespace App\Services;

use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Class RegisterService
 * Est le gestionnaire des inscriptions utilisateurs (gestion de la logique métier)
 */
class RegisterService
{
    public static function register(
        UtilisateurRepository $utilisateurRepository,
        UserPasswordHasherInterface $passwordHasher,
        SerializerInterface $serializer,
        mixed $data_register
    ): JsonResponse {
        return UtilisateurService::createUtilisateur(
            $utilisateurRepository,
            $passwordHasher,
            $serializer,
            $data_register
        );
    }
}
