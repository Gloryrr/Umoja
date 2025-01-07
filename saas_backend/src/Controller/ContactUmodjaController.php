<?php

namespace App\Controller;

use App\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateurRepository;

class ContactUmodjaController extends AbstractController
{
    #[Route('/api/v1/envoi-message-to-umodja', name: 'envoi_email_a_umodja', methods: ['POST'])]
    public function sendMessageToUmodja(
        UtilisateurRepository $utilisateurRepository,
        Security $security,
        MailerService $mailerService,
        Request $request
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return $mailerService->sendMessageToUmodja(
            $utilisateurRepository,
            $security,
            $data
        );
    }
}
