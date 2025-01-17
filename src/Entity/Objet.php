<?php

namespace App\Entity;

use App\Repository\ObjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObjetRepository::class)]
class Objet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $caracteristique = null;

    #[ORM\Column]
    private ?float $valeurEstimee = null;

    // #[ORM\Column(length: 255, nullable: true)]
    // private ?string $imageName = null;

    #[ORM\ManyToOne(inversedBy: 'objets')]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'objets')]
    private ?User $user = null;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'objet')]
    private Collection $auteur;

    /**
     * @var Collection<int, Commentaire>
     */
    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'objet')]
    private Collection $commentaires;

    public function __construct()
    {
        $this->auteur = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCaracteristique(): ?string
    {
        return $this->caracteristique;
    }

    public function setCaracteristique(string $caracteristique): self
    {
        $this->caracteristique = $caracteristique;

        return $this;
    }

    public function getValeurEstimee(): ?float
    {
        return $this->valeurEstimee;
    }

    public function setValeurEstimee(float $valeurEstimee): self
    {
        $this->valeurEstimee = $valeurEstimee;

        return $this;
    }

    // public function getImageName(): ?string
    // {
    //     return $this->imageName;
    // }

    // public function setImageName(?string $imageName): static
    // {
    //     $this->imageName = $imageName;

    //     return $this;
    // }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getAuteur(): Collection
    {
        return $this->auteur;
    }

    public function addAuteur(Commentaire $auteur): static
    {
        if (!$this->auteur->contains($auteur)) {
            $this->auteur->add($auteur);
            $auteur->setObjet($this);
        }

        return $this;
    }

    public function removeAuteur(Commentaire $auteur): static
    {
        if ($this->auteur->removeElement($auteur)) {
            // set the owning side to null (unless already changed)
            if ($auteur->getObjet() === $this) {
                $auteur->setObjet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setObjet($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getObjet() === $this) {
                $commentaire->setObjet(null);
            }
        }

        return $this;
    }
}
