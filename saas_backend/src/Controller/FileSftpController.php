<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\SftpService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class FileSftpController extends AbstractController
{
    #[Route('api/v1/upload-sftp-fichier', name: 'upload_fichier_sftp', methods: ['POST'])]
    public function uploadFichierSFTP(
        Request $request,
        SftpService $sftpService,
        Security $security
    ): JsonResponse {
        return $sftpService->uploadFichier(
            $request, 
            $security
        );
    }
}
