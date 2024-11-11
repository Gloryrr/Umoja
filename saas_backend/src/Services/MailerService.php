<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Component\HttpFoundation\Response;

class MailerService
{
    private MailerInterface $mailer;
    private string $fromEmail;
    private string $fromName;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->fromEmail = "marmionsteven8@gmail.com"; // à changer lors de la mise en route de l'application
        $this->fromName = "UMODJA";
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
                ->from(new Address($this->fromEmail, $this->fromName))
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
}
