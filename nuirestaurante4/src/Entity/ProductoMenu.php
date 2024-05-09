<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductoMenuRepository")
 */
class ProductoMenu
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Productos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Producto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Menus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Menu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProducto(): ?Productos
    {
        return $this->Producto;
    }

    public function setProducto(?Productos $Producto): self
    {
        $this->Producto = $Producto;

        return $this;
    }

    public function getMenu(): ?Menus
    {
        return $this->Menu;
    }

    public function setMenu(?Menus $Menu): self
    {
        $this->Menu = $Menu;

        return $this;
    }
}
