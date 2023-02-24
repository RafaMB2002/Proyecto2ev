<?php

namespace App\Entity;

use App\Repository\TramoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TramoRepository::class)]
class Tramo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $Inicio = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $Fin = null;

    #[ORM\OneToMany(mappedBy: 'tramo', targetEntity: Reserva::class, orphanRemoval: true)]
    private Collection $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInicio(): ?\DateTimeInterface
    {
        return $this->Inicio;
    }

    public function setInicio(\DateTimeInterface $Inicio): self
    {
        $this->Inicio = $Inicio;

        return $this;
    }

    public function getFin(): ?\DateTimeInterface
    {
        return $this->Fin;
    }

    public function setFin(\DateTimeInterface $Fin): self
    {
        $this->Fin = $Fin;

        return $this;
    }

    /**
     * @return Collection<int, Reserva>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Reserva $relation): self
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->setTramo($this);
        }

        return $this;
    }

    public function removeRelation(Reserva $relation): self
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getTramo() === $this) {
                $relation->setTramo(null);
            }
        }

        return $this;
    }
}
