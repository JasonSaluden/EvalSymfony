<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private ?string $alt = null;

    #[ORM\ManyToOne(inversedBy: 'id_image')]
    private ?Produit $id_produit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): static
    {
        $this->alt = $alt;

        return $this;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->id_produit;
    }

    public function setIdProduit(?Produit $id_produit): static
    {
        $this->id_produit = $id_produit;

        return $this;
    }
}
