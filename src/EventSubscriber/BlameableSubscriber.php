<?php

namespace App\EventSubscriber;

use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class BlameableSubscriber implements EventSubscriberInterface
{

    private $userRepository;
    private $security;

    public function __construct(UserRepository $userRepository, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    public function onLoginSuccessEvent(LoginSuccessEvent $event): void
    {
        $user = $event->getUser();
        $user->setLastSession(new DateTime());
        $user = $this->userRepository->updateSession($user);
    }

    public function onLogoutEvent(LogoutEvent $event): void
    {
        $user = $this->security->getUser();
        $actual = new DateTime();
        $timeSession = $user->getLastSession()->diff($actual);
        dd($timeSession);
        $user->setTimeLastSession($timeSession);

    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccessEvent',
            LogoutEvent::class => 'onLogoutEvent'
        ];
    }
}
