<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Entity\User;
use App\Repository\EventoRepository;
use App\Repository\InvitacionRepository;
use App\Repository\JuegoRepository;
use App\Repository\UserRepository;
use App\Service\MailGenerator;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Choice;

class InvitacionFormBuilderController extends AbstractController
{

    private $invitacionRepository;
    private $eventoRepository;
    private $userRepository;
    private $mailGenerator;
    private $juegoRepository;

    public function __construct(InvitacionRepository $invitacionRepository, EventoRepository $eventoRepository, UserRepository $userRepository, JuegoRepository $juegoRepository, MailGenerator $mailGenerator)
    {
        $this->invitacionRepository = $invitacionRepository;
        $this->eventoRepository = $eventoRepository;
        $this->userRepository = $userRepository;
        $this->mailGenerator = $mailGenerator;
        $this->juegoRepository = $juegoRepository;
    }
    #[Route('/invitacion/form/builder', name: 'app_invitacion_form_builder')]
    public function newFormInvitacion(Request $request): Response
    {

        $form = $this->createFormBuilder()
            ->add('Presentado', CheckboxType::class)
            ->add('Evento', EntityType::class, [
                'class' => Evento::class,
                'choice_label' => 'editorial'
            ])
            ->add('usuario', ChoiceType::class, [
                /* 'entry_type' => EmailType::class,
                'entry_options' => [
                    'attr' => ['class' => 'email-box']
                ] */
                //'class' => User::class,
                //'choice_label' => 'nombre',
                //'choice_value' => 'id',
                'multiple' => true,
                'label' => 'Usuarios',
                'choices' => $this->userRepository->findAll(),
                'choice_label' => 'Nombre',
                /* 'constraints' => [
                    new Choice([
                        'max' => 2
                    ])
                ] */
            ])
            ->add('enviar', SubmitType::class, ['label' => 'Crear invitaciones'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $invitacion = $form->getData();
            //dd();
            for ($i = 0; $i < count($invitacion['usuario']); $i++) {
                $this->invitacionRepository->saveInvitacion($invitacion['Evento'], $invitacion['usuario'][$i], $invitacion['Presentado']);
                $this->mailGenerator->sendEmail($invitacion['usuario'][$i]->getEmail(), 'Estas invitado al evento de la editorial: ' . $invitacion['Evento']->getEditorial() . ' para presentar el nuevo juego de mesa: ' . $this->juegoRepository->findOneBy(['id' => $invitacion['Evento']->getJuego()->getId()])->getNombre(), 'Evento Juego de mesa');
            }

            return $this->redirectToRoute('landing_page');
        }

        return $this->render('invitacion_form/index.html.twig', [
            'form' => $form,
        ]);
    }
}
