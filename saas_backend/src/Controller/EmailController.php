<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use App\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    #[Route('/api/v1/envoi-email-new-projet', name: 'envoi_email_nouveau_projet', methods: ['POST'])]
    public function sendEmailNewProjet(
        OffreRepository $offreRepository,
        Request $request,
        MailerService $mailerService,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return $mailerService->sendEmailNewProjet(
            $offreRepository,
            $data,
        );
    }

    #[Route('/api/v1/envoi-email-update-projet', name: 'envoi_email_update_projet', methods: ['POST'])]
    public function sendEmailUpdateProjet(
        OffreRepository $offreRepository,
        Request $request,
        MailerService $mailerService,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return $mailerService->sendEmailUpdateProjet(
            $offreRepository,
            $data,
        );
    }

    #[Route('/api/v1/envoi-email-new-contribution', name: 'envoi_email_nouvelle_contribution', methods: ['POST'])]
    public function sendEmailNewContribution(
        OffreRepository $offreRepository,
        Request $request,
        MailerService $mailerService,
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return $mailerService->sendEmailNewContribution(
            $offreRepository,
            $data,
        );
    }
}
