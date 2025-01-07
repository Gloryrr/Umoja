<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use App\Repository\UtilisateurRepository;
use App\Repository\OffreRepository;

class MailerService
{
    private MailerInterface $mailer;
    private string $umodjaEmail;
    private string $umodjaName;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->umodjaEmail = "marmionsteven8@gmail.com"; // à changer lors de la mise en route de l'application
        $this->umodjaName = "UMODJA";
    }

    /**
     * Envoi un email pour notifier de la création d'un projet, avec l'objet du mail voulu et le contenu
     * @param string $to La destination du mail
     * @param string $subject L'objet du mail
     * @param string $htmlContent Le contenu du mail
     * @return void
     */
    public function sendEmailNewProjet(
        OffreRepository $offreRepository,
        mixed $data,
    ): JsonResponse {
        try {
            // Préparation de la template HTML
            $templatePath = __DIR__ . '/../../templates/emails/notification_creation_projet.html.twig';
            $htmlTemplate = file_get_contents($templatePath);

            $subject = "Création d'un nouveau projet sur Umodja";

            // Préparation de l'envoi de l'email à tous les utilisateurs concernés
            $offre = $offreRepository->find($data['offreId']);
            if (!$offre) {
                return new JsonResponse(['error' => 'Offre non trouvée'], Response::HTTP_NOT_FOUND);
            }

            $reseaux_list = $offre->getReseaux();

            foreach ($reseaux_list as $reseau) {
                $utilisateurs = $reseau->getUtilisateurs();
                foreach ($utilisateurs as $utilisateur) {
                    if ($utilisateur->getEmailUtilisateur() != null) {
                        $htmlMessage = str_replace(
                            [
                                '{{projectName}}',
                                '{{projectDescription}}',
                                '{{userName}}',
                                '{{currentYear}}',
                                '{{emailUmodja}}',
                                '{{networkName}}'
                            ],
                            [
                                $data['projectName'],
                                $data['projectDescription'],
                                $data['username'],
                                date('Y'),
                                $this->umodjaEmail,
                                $reseau->getNomReseau()
                            ],
                            $htmlTemplate
                        );
                        $email = (new Email())
                            ->from(new Address($this->umodjaEmail, $this->umodjaName))
                            ->to($utilisateur->getEmailUtilisateur())
                            ->subject($subject)
                            ->html($htmlMessage);

                        $this->mailer->send($email);
                    }
                }
            }

            return new JsonResponse([
                'mail' => 'succès',
                'message' => 'E-mail envoyé avec succès.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new \RuntimeException('' . $e->getMessage());
        }
    }

    /**
     * Envoi un email pour notifier des modifications d'un projet, avec l'objet du mail voulu et le contenu
     * @param string $to La destination du mail
     * @param string $subject L'objet du mail
     * @param string $htmlContent Le contenu du mail
     * @return void
     */
    public function sendEmailUpdateProjet(
        OffreRepository $offreRepository,
        mixed $data,
    ): JsonResponse {
        try {
            // Préparation de la template HTML
            $templatePath = __DIR__ . '/../../templates/emails/notification_modification_projet.html.twig';
            $htmlTemplate = file_get_contents($templatePath);

            $subject = "Modification d'un projet sur Umodja";

            // Préparation de l'envoi de l'email à tous les utilisateurs concernés
            $offre = $offreRepository->find($data['offreId']);

            if (!$offre) {
                return new JsonResponse(['error' => 'Offre non trouvée'], Response::HTTP_NOT_FOUND);
            }

            $reseaux_list = $offre->getReseaux();

            foreach ($reseaux_list as $reseau) {
                $utilisateurs = $reseau->getUtilisateurs();
                foreach ($utilisateurs as $utilisateur) {
                    if ($utilisateur->getEmailUtilisateur() != null) {
                        $htmlMessage = str_replace(
                            [
                                '{{projectName}}',
                                '{{projectDescription}}',
                                '{{userName}}',
                                '{{currentYear}}',
                                '{{emailUmodja}}',
                                '{{networkName}}'
                            ],
                            [
                                $data['projectName'],
                                $data['projectDescription'],
                                $data['username'],
                                date('Y'),
                                $this->umodjaEmail,
                                $reseau->getNomReseau()
                            ],
                            $htmlTemplate
                        );
                        $email = (new Email())
                            ->from(new Address($this->umodjaEmail, $this->umodjaName))
                            ->to($utilisateur->getEmailUtilisateur())
                            ->subject($subject)
                            ->html($htmlMessage);

                        $this->mailer->send($email);
                    }
                }
            }

            return new JsonResponse([
                'mail' => 'succès',
                'message' => 'E-mail envoyé avec succès.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new \RuntimeException('' . $e->getMessage());
        }
    }

    /**
     * Envoi un email à umodja afin de permettre à n'importe quel utilisateur de nous contacter
     * @param string $contenu Le contenu du mail
     * @return void
     */
    public function sendMessageToUmodja(
        UtilisateurRepository $utilisateurRepository,
        Security $security,
        mixed $data
    ): JsonResponse {
        try {
            $user = $security->getUser();

            if (!$user) {
                return new JsonResponse(['error' => 'Utilisateur non authentifié'], 401);
            }

            $username = $user->getUserIdentifier();
            $userArray = $utilisateurRepository->trouveUtilisateurByUsername($username);

            $messageContent = htmlspecialchars($data['message'], ENT_QUOTES, 'UTF-8');
            $fromEmail = $userArray[0]->getEmailUtilisateur();
            $fromName = $username;
            $subject = "Message de {$fromName} - Service contact d'Umodja";

            // Charger le fichier HTML
            $templatePath = __DIR__ . '/../../templates/emails/contact_umodja.html.twig';
            $htmlTemplate = file_get_contents($templatePath);

            // Remplacer les variables dynamiques dans le template
            $htmlMessage = str_replace(
                ['{{fromName}}', '{{fromEmail}}', '{{subject}}', '{{messageContent}}', '{{currentYear}}'],
                [$fromName, $fromEmail, $subject, $messageContent, date('Y')],
                $htmlTemplate
            );

            $email = (new Email())
                ->from(new Address($fromEmail, $fromName))
                ->to($this->umodjaEmail)
                ->subject($subject)
                ->html($htmlMessage);

            $this->mailer->send($email);

            return new JsonResponse([
                'mail' => 'succès',
                'message' => 'Message envoyé avec succès.',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new \RuntimeException('' . $e->getMessage());
        }
    }
}
