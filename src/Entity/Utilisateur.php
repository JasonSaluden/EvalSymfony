<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Password\PasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;


#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_inscription = null;

    /**
     * @var Collection<int, MessageContact>
     */
    #[ORM\OneToMany(targetEntity: MessageContact::class, mappedBy: 'id_utilisateur')]
    private Collection $id_messageContacts;

    public function __construct()
    {
        $this->roles = [self::ROLE_USER];
        $this->id_messageContacts = new ArrayCollection();
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

    public function getUserIdentifier(): string
    {
        return (string) $this->email; 
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): static
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    /**
     * @return Collection<int, MessageContact>
     */
    public function getIdMessageContacts(): Collection
    {
        return $this->id_messageContacts;
    }

    public function addIdMessageContact(MessageContact $idMessageContact): static
    {
        if (!$this->id_messageContacts->contains($idMessageContact)) {
            $this->id_messageContacts->add($idMessageContact);
            $idMessageContact->setIdUtilisateur($this);
        }

        return $this;
    }

    public function removeIdMessageContact(MessageContact $idMessageContact): static
    {
        if ($this->id_messageContacts->removeElement($idMessageContact)) {
            // set the owning side to null (unless already changed)
            if ($idMessageContact->getIdUtilisateur() === $this) {
                $idMessageContact->setIdUtilisateur(null);
            }
        }

        return $this;
    }

    public function getRoles(): array
    {
        return [$this->role];
    }

    public function eraseCredentials(): void
    {
    }
}
