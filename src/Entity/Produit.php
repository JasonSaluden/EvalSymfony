<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_produit = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_ajout = null;

    #[ORM\Column]
    private ?bool $supprime = null;

    #[ORM\ManyToOne(inversedBy: 'id_produit')]
    private ?Categorie $id_categorie = null;

    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'id_produit')]
    private Collection $id_image;

    public function __construct()
    {
        $this->id_image = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProduit(): ?string
    {
        return $this->nom_produit;
    }

    public function setNomProduit(string $nom_produit): static
    {
        $this->nom_produit = $nom_produit;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->date_ajout;
    }

    public function setDateAjout(\DateTimeInterface $date_ajout): static
    {
        $this->date_ajout = $date_ajout;

        return $this;
    }

    public function isSupprime(): ?bool
    {
        return $this->supprime;
    }

    public function setSupprime(bool $supprime): static
    {
        $this->supprime = $supprime;

        return $this;
    }

    public function getIdCategorie(): ?Categorie
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?Categorie $id_categorie): static
    {
        $this->id_categorie = $id_categorie;

        return $this;
    }

    public function getIdImage(): Collection
    {
        return $this->id_image;
    }

    public function addIdImage(Image $idImage): static
    {
        if (!$this->id_image->contains($idImage)) {
            $this->id_image->add($idImage);
            $idImage->setIdProduit($this);
        }

        return $this;
    }

    public function removeIdImage(Image $idImage): static
    {
        if ($this->id_image->removeElement($idImage)) {
            // set the owning side to null (unless already changed)
            if ($idImage->getIdProduit() === $this) {
                $idImage->setIdProduit(null);
            }
        }

        return $this;
    }

    // Affiche la première image du produit
    public function getFirstImage(): ?string
    {
        if (!$this->id_image->isEmpty()) {
            $firstImage = $this->id_image->first();
            return $firstImage->getUrl();
        }

        return null; 
    }
}
