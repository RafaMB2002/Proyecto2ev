<?php

namespace App\Entity;

use App\Repository\InvitacionRepository;
use App\Service\MailGenerator;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Contracts\EventDispatcher\Event;

#[ORM\Entity(repositoryClass: InvitacionRepository::class)]
class Invitacion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Presentado = null;

    #[ORM\ManyToOne(inversedBy: 'invitacions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evento $evento = null;

    #[ORM\ManyToOne(inversedBy: 'invitacions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isPresentado(): ?bool
    {
        return $this->Presentado;
    }

    public function setPresentado(?bool $Presentado): self
    {
        $this->Presentado = $Presentado;

        return $this;
    }

    public function getEvento(): ?Evento
    {
        return $this->evento;
    }

    public function setEvento(?Evento $evento): self
    {
        $this->evento = $evento;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }
    
    /* #[ORM\PostPersist]
    public function invitacionCreated(MailGenerator $mailGenerator){
        $mailGenerator->sendEmail('','Hola','Invitacion a evento de Juego de mesa');
    } */
}
