<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditProfileType;
use App\Repository\JuegoRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class MainController extends AbstractController
{
    #[Route('/', name: 'landing_page')]
    public function landing(JuegoRepository $juegoRepository): Response
    {
        //phpinfo();
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

        $roles = $user->getRoles();

        if (in_array('ROLE_ADMIN', $roles) || in_array('ROLE_USER', $roles)) {
            return $this->render('gestionReservas/index.html.twig');
        } else {
            return $redirectController->redirectAction($request, 'app_login');
        }
    }

    #[Route('/edit-profile', name: 'edit_profile')]
    public function editProfile(UserInterface $user, RedirectController $redirectController, Request $request, UserRepository $userRepository, AuthenticationUtils $authenticationUtils)
    {
        

        $correo = $authenticationUtils->getLastUsername();
        $userNoModificado = $userRepository->findOneBy(['email' => $correo]);
        //dd($userNoModificado);

        $form = $this->createForm(EditProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $cambios = $form->getData();

            empty($cambios->getNombre()) ? false : $userNoModificado->setNombre($cambios->getNombre());
            empty($cambios->getApellidos()) ? false : $userNoModificado->setApellidos($cambios->getApellidos());
            empty($cambios->getPassword()) ? false : $userNoModificado->setPassword($cambios->getPassword());
            //dd($userNoModificado);
            $userRepository->updateUser($user);
            return $this->redirectToRoute('landing_page');
        }
        return $this->render('editProfile/index.html.twig', [
            'form' => $form,
            'user' => $userNoModificado
        ]);
    }
}
