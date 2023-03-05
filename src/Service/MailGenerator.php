<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailGenerator
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    public function sendEmail($destinatario, $mensaje, $asunto = ''):bool
    {
        $email = (new Email())
            ->from('correossymfuent@gmail.com')
            ->to($destinatario)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($asunto)
            //->text('Sending emails is fun again!')
            ->html($mensaje);

        $this->mailer->send($email);
        return true;
    }
}
