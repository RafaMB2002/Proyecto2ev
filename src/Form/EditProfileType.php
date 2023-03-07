<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditProfileType extends AbstractType
{
    private $authenticationsUtils;
    private $userRepository;

    public function __construct(AuthenticationUtils $authenticationsUtils, UserRepository $userRepository)
    {
        $this->authenticationsUtils = $authenticationsUtils;
        $this->userRepository = $userRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->userRepository->findOneBy(['email' => $this->authenticationsUtils->getLastUsername()]);
        $builder
            ->add('Nombre', TextType::class,[
                'empty_data' => $user->getNombre()
            ])
            ->add('Apellidos', TextType::class,[
                'empty_data' => $user->getApellidos()
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Las dos contraseñas deben ser iguales',
                'first_options' => ['label' => 'Contraseña'],
                'second_options' => ['label' => 'Repita la contraseña'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Porfavor, introduzca una contraseña',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Tu contrasela debe tener mas de {{ limit }} caracteres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('Guardar', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
