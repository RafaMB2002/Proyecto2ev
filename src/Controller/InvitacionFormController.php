<?php

namespace App\Controller;

use App\Entity\Invitacion;
use App\Form\InvitacionType;
use App\Repository\EventoRepository;
use App\Repository\InvitacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvitacionFormController extends AbstractController
{

    private $invitacionRepository;
    private $eventoRepository;

    public function __construct(InvitacionRepository $invitacionRepository, EventoRepository $eventoRepository)
    {
        $this->invitacionRepository = $invitacionRepository;
        $this->eventoRepository = $eventoRepository;
    }

    #[Route('/invitacionForm/new', name: 'app_form_new_invitacion')]
    public function metodoNewInvitacion(Request $request): Response
    {
        $invitacion = new Invitacion();

        $form = $this->createForm(InvitacionType::class, $invitacion);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $invitacion = $form->getData();
            /* $NumSociosEvento = $invitacion->getEvento()->getNumSocios();
            $NumInvitaciones = $this->invitacionRepository->findByExampleField($invitacion->getEvento()); */
            $this->invitacionRepository->saveInvitacion($invitacion);
                return $this->redirectToRoute('landing_page');
            /* if ($NumInvitaciones <= $NumSociosEvento) {
                
            } */

            //dd(var_dump($invitacion));

        }
        return $this->render('invitacion_form/index.html.twig', [
            'form' => $form,
        ]);
    }
}
