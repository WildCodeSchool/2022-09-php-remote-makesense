<?php

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendEmail(
        string $emailTo = 'admin@makesense.com',
        string $subject = 'This is the Mail subject !',
        string $content = '',
        string $text = ''
    ): void {
        $email = (new Email())
            ->from('mailer@makesense.com')
            ->to($emailTo)
            ->subject($subject)
            ->text($text)
            ->html($content);
        $this->mailer->send($email);
    }
}
