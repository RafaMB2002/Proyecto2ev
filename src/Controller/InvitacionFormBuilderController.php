<?php

namespace App\Controller;

use App\Entity\Evento;
use App\Entity\User;
use App\Repository\EventoRepository;
use App\Repository\InvitacionRepository;
use App\Repository\UserRepository;
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

    public function __construct(InvitacionRepository $invitacionRepository, EventoRepository $eventoRepository, UserRepository $userRepository)
    {
        $this->invitacionRepository = $invitacionRepository;
        $this->eventoRepository = $eventoRepository;
        $this->userRepository = $userRepository;
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
            //dd($invitacion['usuario']);
            for ($i=0; $i < count($invitacion['usuario']); $i++) { 
                $this->invitacionRepository->saveInvitacion($invitacion['Evento'], $invitacion['usuario'][$i], $invitacion['Presentado']);
            }
            
            return $this->redirectToRoute('landing_page');
        }

        return $this->render('invitacion_form/index.html.twig', [
            'form' => $form,
        ]);
    }
}
