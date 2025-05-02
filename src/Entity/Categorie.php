<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: 'id_categorie')]
    private Collection $id_produit;

    public function __construct()
    {
        $this->id_produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getIdProduit(): Collection
    {
        return $this->id_produit;
    }

    public function addIdProduit(Produit $idProduit): static
    {
        if (!$this->id_produit->contains($idProduit)) {
            $this->id_produit->add($idProduit);
            $idProduit->setIdCategorie($this);
        }

        return $this;
    }

    public function removeIdProduit(Produit $idProduit): static
    {
        if ($this->id_produit->removeElement($idProduit)) {
            if ($idProduit->getIdCategorie() === $this) {
                $idProduit->setIdCategorie(null);
            }
        }

        return $this;
    }
}
