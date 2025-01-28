<?php

namespace App\Controller;

use App\Repository\OffreRepository;
use App\Repository\ReponseRepository;
use App\Repository\UtilisateurRepository;
use App\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

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

    #[Route(
        '/api/v1/envoi-email-validation-proposition-contribution',
        name: 'envoi_email_validation_proposition_contribution',
        methods: ['POST']
    )]
    public function sendEmailValidationPropositionContribution(
        ReponseRepository $reponseRepository,
        UtilisateurRepository $utilisateurRepository,
        Request $request,
        MailerService $mailerService,
        Security $security
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return $mailerService->sendEmailValidationPropositionContribution(
            $reponseRepository,
            $security,
            $utilisateurRepository,
            $data,
        );
    }

    #[Route(
        '/api/v1/envoi-email-refus-proposition-contribution',
        name: 'envoi_email_refus_proposition_contribution',
        methods: ['POST']
    )]
    public function sendEmailRefusPropositionContribution(
        ReponseRepository $reponseRepository,
        UtilisateurRepository $utilisateurRepository,
        Request $request,
        MailerService $mailerService,
        Security $security
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        return $mailerService->sendEmailRefusPropositionContribution(
            $reponseRepository,
            $security,
            $utilisateurRepository,
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
