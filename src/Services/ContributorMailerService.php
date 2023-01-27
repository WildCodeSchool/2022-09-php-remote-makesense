<?php

namespace App\Services;

use App\Entity\Contributor;
use App\Entity\Decision;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContributorMailerService extends AbstractController
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendEmail(
        string $emailTo,
        Contributor $contributor,
        Decision $decision
    ): void {
        $email = (new Email())
            ->from('mailer@makesense.com')
            ->to($emailTo)
            ->subject('Makesense : vous avez été ajouté comme contributeur pour participer à une décision !')
            ->html($this->renderView('contributor/contributor_notification_email.html.twig', [
                'contributor' => $contributor,
                'decision' => $decision,
                ]));
        $this->mailer->send($email);
    }
}
