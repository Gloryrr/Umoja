<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\PersonneRepository;

class PersonneController extends AbstractController
{
    #[Route('/api/personnes', name: 'get_personnes', methods: ['GET'])]
    public function getPersonnes(PersonneRepository $personneRepository, SerializerInterface $serializer): JsonResponse // Utilisation d'un serializer pour aider PHP à lire les données et les mettre en JSON
    {
        $personnes = $personneRepository->findAll();
        $personnesJSON = $serializer->serialize($personnes, 'json');
        return new JsonResponse([
            'personnes' => $personnesJSON,
            'query_response' => Response::HTTP_OK, 
            'headers' => [], 
            'serialized' => true
        ]);
    }
}
