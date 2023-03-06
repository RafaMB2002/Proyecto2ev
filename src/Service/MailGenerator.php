<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Part\File;

class MailGenerator
{
    private $mailer;
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    public function sendEmail($destinatario, $mensaje, $asunto = '', $archivo = ''):bool
    {
        $email = (new Email())
            ->from('correossymfuent@gmail.com')
            ->to($destinatario)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->addPart(new DataPart(new File($archivo)))
            ->subject($asunto)
            //->text('Sending emails is fun again!')
            ->html($mensaje);

        $this->mailer->send($email);
        return true;
    }
}
