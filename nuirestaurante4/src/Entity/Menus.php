<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenusRepository")
 */
class Menus
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=48)
     */
    private $entrante;

    /**
     * @ORM\Column(type="string", length=48)
     */
    private $primer_plato;

    /**
     * @ORM\Column(type="string", length=48)
     */
    private $segundo_plato;

    /**
     * @ORM\Column(type="string", length=48)
     */
    private $postre;

    /**
     * @ORM\Column(type="float")
     */
    private $coste;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntrante(): ?string
    {
        return $this->entrante;
    }

    public function setEntrante(string $entrante): self
    {
        $this->entrante = $entrante;

        return $this;
    }

    public function getPrimerPlato(): ?string
    {
        return $this->primer_plato;
    }

    public function setPrimerPlato(string $primer_plato): self
    {
        $this->primer_plato = $primer_plato;

        return $this;
    }

    public function getSegundoPlato(): ?string
    {
        return $this->segundo_plato;
    }

    public function setSegundoPlato(string $segundo_plato): self
    {
        $this->segundo_plato = $segundo_plato;

        return $this;
    }

    public function getPostre(): ?string
    {
        return $this->postre;
    }

    public function setPostre(string $postre): self
    {
        $this->postre = $postre;

        return $this;
    }

    public function getCoste(): ?float
    {
        return $this->coste;
    }

    public function setCoste(float $coste): self
    {
        $this->coste = $coste;

        return $this;
    }
    
    public function __toString() {
        return $this->primer_plato;
    }
}
