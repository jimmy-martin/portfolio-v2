<?php

namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class EmailSender
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Send and check if email is correctly send
     *
     * @param string $emailToSend
     * @return boolean
     */
    private function send(RawMessage $emailToSend): bool
    {
        try {
            $this->mailer->send($emailToSend);
        } catch (TransportExceptionInterface $e) {
            return false;
        }

        return true;
    }

    /**
     * Send standard email with text
     *
     * @param string $senderMail
     * @param string $receiverMail
     * @param string $mailText
     * @param string $mailSubject
     * @return boolean
     */
    public function sendStandard(string $senderMail, string $receiverMail, string $mailText, string $mailSubject = ''): bool
    {
        $email = (new Email())
            ->from($senderMail)
            ->to($receiverMail)
            ->subject($mailSubject)
            ->text($mailText);

        return $this->send($email);
    }

    /**
     * Send templated email
     *
     * @param string $senderMail
     * @param string $receiverMail
     * @param array $templateVars
     * @param string $mailSubject
     * @return boolean
     */
    public function sendTemplatedEmail(string $senderMail, string $receiverMail, array $templateVars = [], string $mailSubject = ''): bool
    {
        $email = (new TemplatedEmail())
            ->from($senderMail)
            ->to($receiverMail)
            ->subject($mailSubject)
            ->htmlTemplate('emails/confirmation.html.twig')
            ->context($templateVars);

        return $this->send($email);
    }
}
