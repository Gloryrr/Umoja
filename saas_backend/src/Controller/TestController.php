<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

use App\Repository\TestRepository;

class TestController extends AbstractController
{
    #[Route('/api/test_message', name: 'saas_test', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TestController.php',
        ]);
    }

    #[Route('/api/tests', name: 'get_tests', methods: ['GET'])]
    public function getTestsList(TestRepository $testRepository, SerializerInterface $serializer): JsonResponse // Utilisation d'un serializer pour aider PHP à lire les données et les mettre en JSON
    {
        $tests = $testRepository->findAll();
        $testsJSON = $serializer->serialize($tests, 'json');
        return new JsonResponse([
            'tests' => $testsJSON,
            'query_response' => Response::HTTP_OK, 
            'headers' => [], 
            'serialized' => true
        ]);
    }
}
