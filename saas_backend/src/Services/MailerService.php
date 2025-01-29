<?php

namespace App\Services;

use App\Repository\ReponseRepository;
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
    private string $umojaEmail;
    private string $umojaName;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->umojaEmail = "%env(MAIL_UMOJA)%";
        $this->umojaName = "Umoja";
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

            $subject = "Création d'un nouveau projet sur Umoja";

            // Préparation de l'envoi de l'email à tous les utilisateurs concernés
            $offre = $offreRepository->find($data['offreId']);
            if (!$offre) {
                return new JsonResponse(['error' => 'Offre non trouvée'], Response::HTTP_NOT_FOUND);
            }

            $reseaux_list = $offre->getReseaux();

            foreach ($reseaux_list as $reseau) {
                $utilisateurs = $reseau->getUtilisateurs();
                foreach ($utilisateurs as $utilisateur) {
                    if ($utilisateur->getPreferenceNotification()->isEmailNouvelleOffre()) {
                        if ($utilisateur->getEmailUtilisateur() != null) {
                            $htmlMessage = str_replace(
                                [
                                    '{{projectName}}',
                                    '{{projectDescription}}',
                                    '{{userName}}',
                                    '{{currentYear}}',
                                    '{{emailUmoja}}',
                                    '{{networkName}}'
                                ],
                                [
                                    $data['projectName'],
                                    $data['projectDescription'],
                                    $data['username'],
                                    date('Y'),
                                    $this->umojaEmail,
                                    $reseau->getNomReseau()
                                ],
                                $htmlTemplate
                            );
                            $email = (new Email())
                                ->from(new Address($this->umojaEmail, $this->umojaName))
                                ->to($utilisateur->getEmailUtilisateur())
                                ->subject($subject)
                                ->html($htmlMessage);

                            $this->mailer->send($email);
                        }
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

            $subject = "Modification d'un projet sur Umoja";

            // Préparation de l'envoi de l'email à tous les utilisateurs concernés
            $offre = $offreRepository->find($data['offreId']);

            if (!$offre) {
                return new JsonResponse(['error' => 'Offre non trouvée'], Response::HTTP_NOT_FOUND);
            }

            $reseaux_list = $offre->getReseaux();

            foreach ($reseaux_list as $reseau) {
                $utilisateurs = $reseau->getUtilisateurs();
                foreach ($utilisateurs as $utilisateur) {
                    if ($utilisateur->getPreferenceNotification()->isEmailUpdateOffre()) {
                        if ($utilisateur->getEmailUtilisateur() != null) {
                            $htmlMessage = str_replace(
                                [
                                    '{{projectName}}',
                                    '{{projectDescription}}',
                                    '{{userName}}',
                                    '{{currentYear}}',
                                    '{{emailUmoja}}',
                                    '{{networkName}}'
                                ],
                                [
                                    $data['projectName'],
                                    $data['projectDescription'],
                                    $data['username'],
                                    date('Y'),
                                    $this->umojaEmail,
                                    $reseau->getNomReseau()
                                ],
                                $htmlTemplate
                            );
                            $email = (new Email())
                                ->from(new Address($this->umojaEmail, $this->umojaName))
                                ->to($utilisateur->getEmailUtilisateur())
                                ->subject($subject)
                                ->html($htmlMessage);

                            $this->mailer->send($email);
                        }
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
     * Envoi un email à umoja afin de permettre à n'importe quel utilisateur de nous contacter
     * @param string $contenu Le contenu du mail
     * @return void
     */
    public function sendMessageToUmoja(
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
            $subject = "Message de {$fromName} - Service contact d'Umoja";

            // Charger le fichier HTML
            $templatePath = __DIR__ . '/../../templates/emails/contact_umoja.html.twig';
            $htmlTemplate = file_get_contents($templatePath);

            // Remplacer les variables dynamiques dans le template
            $htmlMessage = str_replace(
                ['{{fromName}}', '{{fromEmail}}', '{{subject}}', '{{messageContent}}', '{{currentYear}}'],
                [$fromName, $fromEmail, $subject, $messageContent, date('Y')],
                $htmlTemplate
            );

            $email = (new Email())
                ->from(new Address($fromEmail, $fromName))
                ->to($this->umojaEmail)
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

    /**
     * Notifie un utilisateur que son compte vient d'être créer dans l'application
     */
    public function sendEmailNewUser(
        mixed $data
    ): JsonResponse {
        try {
            $subject = "Création de votre compte Umoja";

            // Charger le fichier HTML
            $templatePath = __DIR__ . '/../../templates/emails/notification_creation_compte.html.twig';
            $htmlTemplate = file_get_contents($templatePath);

            // Remplacer les variables dynamiques dans le template
            $htmlMessage = str_replace(
                ['{{userName}}', '{{userEmail}}', '{{mdpUtilisateur}}', '{{currentYear}}', '{{emailUmoja}}'],
                [$data['username'], $data['emailUtilisateur'], $data['username'] ,date('Y'), $this->umojaEmail],
                $htmlTemplate
            );

            $email = (new Email())
                ->from(new Address($this->umojaEmail, $this->umojaName))
                ->to($data['emailUtilisateur'])
                ->subject($subject)
                ->html($htmlMessage);

            $this->mailer->send($email);

            return new JsonResponse([
                'mail' => 'succès',
                'message' => 'E-mail envoyé avec succès.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new \RuntimeException('' . $e->getMessage());
        }
    }

    public function sendEmailValidationPropositionContribution(
        ReponseRepository $reponseRepository,
        Security $security,
        UtilisateurRepository $utilisateurRepository,
        mixed $data,
    ): JsonResponse {
        try {
            // récupération de l'utilisateur
            $user = $security->getUser();

            if (!$user) {
                return new JsonResponse(['error' => 'Utilisateur non authentifié'], 401);
            }

            $username = $user->getUserIdentifier();
            $userArray = $utilisateurRepository->trouveUtilisateurByUsername($username);

            // Préparation de la template HTML
            $templatePath =
                __DIR__ .
                '/../../templates/emails/notification_validation_proposition_contribution.html.twig';

            $htmlTemplate = file_get_contents($templatePath);

            $subject = "Validation de votre proposition de contribution - Umoja";

            // Préparation de l'envoi de l'email à tous les utilisateurs concernés
            $reponse = $reponseRepository->find($data['idProposition']);
            if (!$reponse) {
                return new JsonResponse(['error' => 'Réponse non trouvée'], Response::HTTP_NOT_FOUND);
            }

            $offreTitre = $reponse->getOffre()->getTitleOffre();
            $offreId = $reponse->getOffre()->getId();

            // Remplacer les variables dynamiques dans le template
            $htmlMessage = str_replace(
                ['{{userName}}', '{{projectName}}', '{{idOffre}}', '{{currentYear}}', '{{emailUmoja}}'],
                [$username, $offreTitre, $offreId, date('Y'), $this->umojaEmail],
                $htmlTemplate
            );

            $email = (new Email())
                ->from(new Address($this->umojaEmail, $this->umojaName))
                ->to($userArray[0]->getEmailUtilisateur())
                ->subject($subject)
                ->html($htmlMessage);

            $this->mailer->send($email);

            return new JsonResponse([
                'mail' => 'succès',
                'message' => 'E-mail envoyé avec succès.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new \RuntimeException('' . $e->getMessage());
        }
    }

    public function sendEmailRefusPropositionContribution(
        ReponseRepository $reponseRepository,
        Security $security,
        UtilisateurRepository $utilisateurRepository,
        mixed $data,
    ): JsonResponse {
        try {
            // récupération de l'utilisateur
            $user = $security->getUser();

            if (!$user) {
                return new JsonResponse(['error' => 'Utilisateur non authentifié'], 401);
            }

            $username = $user->getUserIdentifier();
            $userArray = $utilisateurRepository->trouveUtilisateurByUsername($username);

            // Préparation de la template HTML
            $templatePath = __DIR__ . '/../../templates/emails/notification_refus_proposition_contribution.html.twig';
            $htmlTemplate = file_get_contents($templatePath);

            $subject = "Refus de votre proposition de contribution - Umoja";

            // Préparation de l'envoi de l'email à tous les utilisateurs concernés
            $reponse = $reponseRepository->find($data['idProposition']);
            if (!$reponse) {
                return new JsonResponse(['error' => 'Réponse non trouvée'], Response::HTTP_NOT_FOUND);
            }

            $offreTitre = $reponse->getOffre()->getTitleOffre();

            // Remplacer les variables dynamiques dans le template
            $htmlMessage = str_replace(
                ['{{userName}}', '{{projectName}}', '{{messageRefus}}', '{{currentYear}}', '{{emailUmoja}}'],
                [$username, $offreTitre, $data['messageRefus'], date('Y'), $this->umojaEmail],
                $htmlTemplate
            );

            $email = (new Email())
                ->from(new Address($this->umojaEmail, $this->umojaName))
                ->to($userArray[0]->getEmailUtilisateur())
                ->subject($subject)
                ->html($htmlMessage);

            $this->mailer->send($email);

            return new JsonResponse([
                'mail' => 'succès',
                'message' => 'E-mail envoyé avec succès.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new \RuntimeException('' . $e->getMessage());
        }
    }

    /**
     * Notifie un utilisateur que son compte vient d'être créer dans l'application
     */
    public function sendEmailNewContribution(
        OffreRepository $offreRepository,
        mixed $data
    ): JsonResponse {
        try {
            $offre = $offreRepository->find($data['idOffre']);
            $subject = "Nouvelle contribution sur votre projet Umoja";

            // Charger le fichier HTML
            $templatePath = __DIR__ . '/../../templates/emails/notification_nouvelle_contribution.html.twig';
            $htmlTemplate = file_get_contents($templatePath);

            // Remplacer les variables dynamiques dans le template
            $htmlMessage = str_replace(
                ['{{userName}}', '{{projectName}}', '{{idOffre}}', '{{currentYear}}', '{{emailUmoja}}'],
                [$data['username'], $offre->getTitleOffre(), $data['idOffre'], date('Y'), $this->umojaEmail],
                $htmlTemplate
            );

            $email = (new Email())
                ->from(new Address($this->umojaEmail, $this->umojaName))
                ->to($offre->getUtilisateur()->getEmailUtilisateur())
                ->subject($subject)
                ->html($htmlMessage);

            $this->mailer->send($email);

            return new JsonResponse([
                'mail' => 'succès',
                'message' => 'E-mail envoyé avec succès.'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            throw new \RuntimeException('' . $e->getMessage());
        }
    }
}
