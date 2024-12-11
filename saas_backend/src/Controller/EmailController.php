<?php

namespace App\Controller;

use App\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    #[Route('/api/v1/envoi-email', name: 'envoi_email', methods: ['POST'])]
    public function sendEmail(
        MailerService $mailerService,
    ): JsonResponse {
        // changer la destination dynamiquement en fonction de l'utilisateur
        $to = 'marmionsteven07@gmail.com';

        // changer le sujet dynamiquement en fonction de la notification de l'application
        $subject = "Test d'envoi d'e-mail avec Gmail";

        // changer le contenu en fonction de l'utilité du mail, voir si on peut utiliser des templates ???
        $content = "<h1>Ceci est un test</h1><p>L'e-mail a été envoyé avec succès via Gmail SMTP. TEST TEST TEST</p>";

        return $mailerService->sendEmail(
            $to,
            $subject,
            $content
        );
    }
}
