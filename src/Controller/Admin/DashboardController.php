<?php

namespace App\Controller\Admin;

use App\Entity\Juego;
use App\Entity\Mesa;
use App\Entity\Reserva;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
         return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ProyectoJuegosMesa')
            ->setFaviconPath('public\img\favicon\mesa-circular.svg')
            ->disableDarkMode()
            ->setLocales(['es', 'en']);
    }

    public function configureMenuItems(): iterable
    {
       //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('Inicio', 'fa fa-home', 'landing_page');
        yield MenuItem::linkToCrud('Usuario', 'fa-sharp fa-solid fa-users', User::class);
        yield MenuItem::linkToCrud('Mesa', 'fa-solid fa-circle', Mesa::class);
        yield MenuItem::linkToCrud('Juego', 'fa-solid fa-chess-knight', Juego::class);
        yield MenuItem::linkToCrud('Reserva', 'fas fa-sticky-note', Reserva::class);
        
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            ->setName($user->getFullName())
            // use this method if you don't want to display the name of the user
           // ->displayUserName(false)

            // you can return an URL with the avatar image
            //->setAvatarUrl('https://github.com/RafaMB2002/Proyecto2ev/blob/master/public/img/avatar/perfil.png')
            ->setAvatarUrl("/img/avatar/".$user->getAvatar())
            // use this method if you don't want to display the user image
           // ->displayUserAvatar(false)
            // you can also pass an email address to use gravatar's service
            //->setGravatarEmail($user->getEmail())

            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToRoute('My Profile', 'fa fa-id-card', '...', ['...' => '...']),
                MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
                MenuItem::section(),
                MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }
}
