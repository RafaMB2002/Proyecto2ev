<?php

namespace App\Controller;

use App\Repository\JuegoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'landing_page')]
    public function landing(JuegoRepository $juegoRepository): Response
    {
        return $this->render('landing/landingPage.html.twig', [
            'juegos' => $juegoRepository->findAll(),
        ]);
    }

    #[Route('/gestionMesas', name: 'gestion_mesas')]
    public function gestionMesas(): Response
    {
        return $this->render('gestionMesas/gestionMesas.html.twig');
    }

    #[Route('/listado-juegos', name: 'listado_juegos')]
    public function listadoJuegos(JuegoRepository $juegoRepository): Response
    {
        return $this->render('listadoJuegos/index.html.twig', [
            'juegos' => $juegoRepository->findAll(),
        ]);
    }
}
