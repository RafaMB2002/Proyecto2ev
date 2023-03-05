<?php

namespace App\Controller;

use App\Service\MailGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function sendCorreo(MailGenerator $mailGenerator):Response
    {
        

        if ($mailGenerator->sendEmail('rafaelmontoroberdonces441@gmail.com', 'eeeei', 'prueba')) {
            $this->addFlash('success', 'Correo enviado correctamente');
        }

        return new Response("enviado");
    }
}
