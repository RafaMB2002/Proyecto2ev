<?php

namespace App\Form;

use App\Entity\Evento;
use App\Entity\Invitacion;
use App\Entity\Juego;
use App\Repository\JuegoRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EventoType extends AbstractType
{

    private $juegoRepository;

    public function __construct(JuegoRepository $juegoRepository)
    {
        $this->juegoRepository = $juegoRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Fecha_hora')
            ->add('Editorial')
            ->add('NumSocios')
            ->add('juego', EntityType::class, [
                'class' => Juego::class,
                'choice_label' => 'nombre'
            ])
            ->add('Crear', SubmitType::class, [
                'label' => 'Crear evento'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}
