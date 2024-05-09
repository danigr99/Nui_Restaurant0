<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductosRepository")
 */
class Productos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorias")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_categoria;

    /**
     * @ORM\Column(type="string", length=24)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $alergenos;

    /**
     * @ORM\Column(type="string", length=80, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;
    
    /*
     * @ORM\Column(type="string", length=255)
     */
    private $imagen;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCategoria(): ?categorias
    {
        return $this->id_categoria;
    }

    public function setIdCategoria(?categorias $id_categoria): self
    {
        $this->id_categoria = $id_categoria;

        return $this;
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

    public function getAlergenos(): ?string
    {
        return $this->alergenos;
    }

    public function setAlergenos(?string $alergenos): self
    {
        $this->alergenos = $alergenos;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }
    
    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

        return $this;
    }
    
}
