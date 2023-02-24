<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Form\EventoType;
use App\Repository\EventoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventoFormController extends AbstractController
{
    private $eventoRepository;

    public function __construct(EventoRepository $eventoRepository)
    {
        $this->eventoRepository = $eventoRepository;
    }

    #[Route('/eventoForm/new', name: 'app_form_new_evento')]
    public function metodoNewMesa(Request $request): Response
    {
        $evento = new Evento();

        $form = $this->createForm(EventoType::class, $evento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evento = $form->getData();
            $this->eventoRepository->saveEvento($evento);
            return $this->redirectToRoute('landing_page');
        }
        return $this->render('evento_form/index.html.twig', [
            'form' => $form,
        ]);
    }
}
