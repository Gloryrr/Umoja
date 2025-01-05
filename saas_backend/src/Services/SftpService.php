<?php

namespace App\Services;

use phpseclib3\Net\SFTP;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class SftpService
{
    private $host;
    private $port;
    private $username;
    private $password;
    private $remoteDir;

    public function __construct(string $host, int $port, string $username, string $password, string $remoteDir)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->remoteDir = $remoteDir;
    }

    public function uploadFichierSFTP(
        string $localFilePath,
        string $remoteFileName,
        UserInterface $userInterface,
        int $idProjet,
        string $typeFichier
    ): bool {
        try {
            $sftp = new SFTP($this->host, $this->port);

            if (!$sftp->login($this->username, $this->password)) {
                throw new \RuntimeException('Accès au serveur SFTP impossible');
            }
            $username = $userInterface->getUserIdentifier();

            if (!$sftp->chdir("{$this->remoteDir}/{$username}")) {
                $sftp->mkdir("{$this->remoteDir}/{$username}");
            }
            if (!$sftp->chdir("{$this->remoteDir}/{$username}/{$idProjet}")) {
                $sftp->mkdir("{$this->remoteDir}/{$username}/{$idProjet}");
            }
            if (!$sftp->chdir("{$this->remoteDir}/{$username}/{$idProjet}/{$typeFichier}")) {
                $sftp->mkdir("{$this->remoteDir}/{$username}/{$idProjet}/{$typeFichier}");
            }
            if ($sftp->file_exists("{$this->remoteDir}/{$username}/{$idProjet}/{$typeFichier}/{$remoteFileName}")) {
                throw new \RuntimeException(
                    'Un fichier avec ce nom existe déjà, merci de le renommer ou de supprimer le fichier déjà existant'
                );
            }

            $remoteFilePath = "{$this->remoteDir}/{$username}/{$idProjet}/{$typeFichier}/{$remoteFileName}";
            return $sftp->put(
                $remoteFilePath,
                file_get_contents($localFilePath)
            );
        } catch (\Throwable $th) {
            throw new \RuntimeException($th->getMessage());
        }
    }

    public function uploadFichier(
        Request $request,
        Security $security
    ): JsonResponse {
        $file = $request->files->get('file');
        $idProjet = intval($request->request->get('idProjet'));
        $typeFicher = $request->request->get('typeFichier');

        $user = $security->getUser();

        if (!$file || $file->getClientMimeType() !== 'application/pdf') {
            return new JsonResponse(
                ['error' => 'Type de fichier invalide, nous n\'acceptons que des PDF'],
                Response::HTTP_BAD_REQUEST
            );
        }

        try {
            $filename = $file->getClientOriginalName();
            $filePath = $file->getPathname();
            $fichierSauvegarde = $this->uploadFichierSFTP(
                $filePath,
                $filename,
                $user,
                $idProjet,
                $typeFicher
            );
            if (!$fichierSauvegarde) {
                return new JsonResponse(
                    [
                        'error' => 'Erreur lors du transfert du fichier'
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            } else {
                return new JsonResponse(
                    [
                        'message' => 'Fichier transféré avec succès'
                    ],
                    Response::HTTP_OK
                );
            }
        } catch (FileException $e) {
            return new JsonResponse(
                ['error' => $e->getMessage()],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
