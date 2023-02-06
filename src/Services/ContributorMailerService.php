<?php

namespace App\Services;

use App\Entity\Contributor;
use App\Entity\Decision;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class ContributorMailerService
{
    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function sendEmail(
        string $emailTo,
        Contributor $contributor,
        Decision $decision
    ): void {
        $email = (new TemplatedEmail())
            ->from('mailer@makesense.com')
            ->to($emailTo)
            ->subject('Makesense : vous avez été ajouté comme contributeur pour participer à une décision !')
            ->htmlTemplate('contributor/contributor_notification_email.html.twig')
            ->context([
                'contributor' => $contributor,
                'decision' => $decision,
            ]);
        $this->mailer->send($email);
    }
}
