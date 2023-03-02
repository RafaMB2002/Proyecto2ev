<?php

namespace App\Controller;

use App\Entity\Invitacion;
use App\Form\InvitacionType;
use App\Repository\InvitacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InvitacionFormController extends AbstractController
{

    private $invitacionRepository;

    public function __construct(InvitacionRepository $invitacionRepository)
    {
        $this->invitacionRepository = $invitacionRepository;
    }

    #[Route('/invitacionForm/new', name: 'app_form_new_evento')]
    public function metodoNewInvitacion(Request $request): Response
    {
        $invitacion = new Invitacion();

        $form = $this->createForm(InvitacionType::class, $invitacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invitacion = $form->getData();
            $this->invitacionRepository->saveInvitacion($invitacion);
            return $this->redirectToRoute('landing_page');
        }
        return $this->render('invitacion_form/index.html.twig', [
            'form' => $form,
        ]);
    }
}
