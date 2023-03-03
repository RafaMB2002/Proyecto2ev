<?php

namespace App\Form;

use App\Entity\Evento;
use App\Entity\Invitacion;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class InvitacionType extends AbstractType
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Presentado')
            ->add('evento', EntityType::class, [
                'class' => Evento::class,
                'choice_label' => 'Editorial'
            ])
            ->add('usuario', EntityType::class, [
                /* 'entry_type' => EmailType::class,
                'entry_options' => [
                    'attr' => ['class' => 'email-box']
                ] */
                'class' => User::class,
                'choice_label' => 'nombre',
                'multiple' => true,
                'constraints' => [
                    new Choice([
                        'max' => 4
                    ])
                ]
            ])
            ->add('enviar', SubmitType::class, [
                'label' => 'Crear Invitacion'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Invitacion::class,
        ]);
    }
}
