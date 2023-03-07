<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GestionReservasController extends AbstractController
{
    #[Route('/gestion/reservas', name: 'app_gestion_reservas')]
    public function index(): Response
    {
        return $this->render('gestion_reservas/index.html.twig', [
            'controller_name' => 'GestionReservasController',
        ]);
    }
}
