<?php

namespace App\Controller;

use App\Repository\JuegoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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

    #[Route('/reservar-mesa', name: 'reservar_mesa')]
    public function reservarMesa(UserInterface $user, RedirectController $redirectController, Request $request)
    {

        if ($user->getRoles() == ['ROLE_USER'] || $user->getRoles() == ['ROLE_ADMIN']) {
            return $this->render('gestionReservas/index.html.twig');
        } else {
            return $redirectController->redirectAction($request, 'app_login');
        }
    }
}
