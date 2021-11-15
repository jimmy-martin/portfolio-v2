<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class EmailSender
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendStandard($senderMail, $receiverMail, $mailSubject, $mailText)
    {
        $email = (new Email())
            ->from($senderMail)
            ->to($receiverMail)
            ->subject($mailSubject)
            ->text($mailText);

        $this->mailer->send($email);
    }
}
