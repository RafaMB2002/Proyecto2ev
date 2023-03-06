<?php

namespace App\Form;

use App\Entity\Juego;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Negative;
use Symfony\Component\Validator\Constraints\Positive;

class Juego1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre')
            ->add('ancho', IntegerType::class, [
                'constraints' => [
                    new Positive()
                ]
            ])
            ->add('alto', IntegerType::class, [
                'constraints' => [
                    new Positive()
                ]
            ])
            ->add('num_min_players', IntegerType::class,[
                'constraints' => [
                    new Positive()
                ]
            ])
            ->add('num_max_players', IntegerType::class, [
                'constraints' => [
                    new Positive()
                ]
            ])
            ->add('descripcion')
            ->add('imagen')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Juego::class,
        ]);
    }
}
