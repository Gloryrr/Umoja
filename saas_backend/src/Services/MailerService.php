<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use App\Repository\UtilisateurRepository;

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
     * Envoi un email à la destination voulue, avec l'objet du mail voulu et le contenu
     * @param string $to La destination du mail
     * @param string $subject L'objet du mail
     * @param string $htmlContent Le contenu du mail
     * @return void
     */
    public function sendEmail(string $to, string $subject, string $content): JsonResponse
    {
        try {
            $email = (new Email())
                ->from(new Address($this->umodjaEmail, $this->umodjaName))
                ->to($to)
                ->subject($subject)
                ->html($content);

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
