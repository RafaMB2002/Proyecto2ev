<?php

namespace App\Entity;

use App\Repository\JuegoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JuegoRepository::class)]
class Juego
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?int $ancho = null;

    #[ORM\Column]
    private ?int $alto = null;

    #[ORM\Column]
    private ?int $num_min_players = null;

    #[ORM\Column]
    private ?int $num_max_players = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getAncho(): ?int
    {
        return $this->ancho;
    }

    public function setAncho(int $ancho): self
    {
        $this->ancho = $ancho;

        return $this;
    }

    public function getAlto(): ?int
    {
        return $this->alto;
    }

    public function setAlto(int $alto): self
    {
        $this->alto = $alto;

        return $this;
    }

    public function getNumMinPlayers(): ?int
    {
        return $this->num_min_players;
    }

    public function setNumMinPlayers(int $num_min_players): self
    {
        $this->num_min_players = $num_min_players;

        return $this;
    }

    public function getNumMaxPlayers(): ?int
    {
        return $this->num_max_players;
    }

    public function setNumMaxPlayers(int $num_max_players): self
    {
        $this->num_max_players = $num_max_players;

        return $this;
    }
}
