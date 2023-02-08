<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'landing_page')]
    public function landing():Response
    {
        return $this->render('landing/landingPage.html.twig');
    }

    #[Route('/gestionMesas', name: 'gestion_mesas')]
    public function gestionMesas():Response
    {
        return $this->render('gestionMesas/gestionMesas.html.twig');
    }
}
