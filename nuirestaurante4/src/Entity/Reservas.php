<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservasRepository")
 */
class Reservas
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\menus")
     */
    private $menu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;
    
    /**
     * @ORM\Column(type="string", length=24)
     */
    private $nombre_usuario;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $fecha;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_personas;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMenu(): ?menus
    {
        return $this->menu;
    }

    public function setMenu(?menus $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getUsuario(): ?user
    {
        return $this->usuario;
    }

    public function setUsuario(?user $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }
    
    public function getNombreUsuario(): ?string
    {
        return $this->nombreUsuario;
    }

    public function setNombreUsuario(string $nombre_usuario): self
    {
        $this->nombre_usuario= $nombre_usuario;

        return $this;
    }

    public function getFecha(): ?string
    {
        return $this->fecha;
    }

    public function setFecha(string $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getNumPersonas(): ?int
    {
        return $this->num_personas;
    }

    public function setNumPersonas(int $num_personas): self
    {
        $this->num_personas = $num_personas;

        return $this;
    }
}
