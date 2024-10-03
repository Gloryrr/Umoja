<?php

namespace App\Services;

use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RegisterService
 * Est le gestionnaire des inscriptions utilisateurs (gestion de la logique métier)
 */
class RegisterService
{
    public static function register(
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer,
        mixed $data_register
    ): JsonResponse {
        return UtilisateurService::createUtilisateur(
            $utilisateurRepository,
            $serializer,
            $data_register
        );
    }
}
