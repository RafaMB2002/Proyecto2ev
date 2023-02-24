<?php

namespace App\Entity;

use App\Repository\EventoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventoRepository::class)]
class Evento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Fecha_hora = null;

    #[ORM\Column(length: 255)]
    private ?string $Editorial = null;

    #[ORM\Column]
    private ?int $NumSocios = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Juego $juego = null;

    #[ORM\OneToMany(mappedBy: 'evento', targetEntity: Invitacion::class, orphanRemoval: true)]
    private Collection $invitacions;

    public function __construct()
    {
        $this->invitacions = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaHora(): ?\DateTimeInterface
    {
        return $this->Fecha_hora;
    }

    public function setFechaHora(\DateTimeInterface $Fecha_hora): self
    {
        $this->Fecha_hora = $Fecha_hora;

        return $this;
    }

    public function getEditorial(): ?string
    {
        return $this->Editorial;
    }

    public function setEditorial(string $Editorial): self
    {
        $this->Editorial = $Editorial;

        return $this;
    }

    public function getNumSocios(): ?int
    {
        return $this->NumSocios;
    }

    public function setNumSocios(int $NumSocios): self
    {
        $this->NumSocios = $NumSocios;

        return $this;
    }

    public function getJuego(): ?Juego
    {
        return $this->juego;
    }

    public function setJuego(Juego $juego): self
    {
        $this->juego = $juego;

        return $this;
    }

    /**
     * @return Collection<int, Invitacion>
     */
    public function getInvitacions(): Collection
    {
        return $this->invitacions;
    }

    public function addInvitacion(Invitacion $invitacion): self
    {
        if (!$this->invitacions->contains($invitacion)) {
            $this->invitacions->add($invitacion);
            $invitacion->setEvento($this);
        }

        return $this;
    }

    public function removeInvitacion(Invitacion $invitacion): self
    {
        if ($this->invitacions->removeElement($invitacion)) {
            // set the owning side to null (unless already changed)
            if ($invitacion->getEvento() === $this) {
                $invitacion->setEvento(null);
            }
        }

        return $this;
    }

    

    

    
}
