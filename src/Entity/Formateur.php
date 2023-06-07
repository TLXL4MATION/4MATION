<?php

namespace App\Entity;

use App\Repository\FormateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormateurRepository::class)]
class Formateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\ManyToOne(inversedBy: 'formateurs')]
    private ?Campus $campusPrincipal = null;

    #[ORM\ManyToMany(targetEntity: ModuleFormation::class, inversedBy: 'formateurs')]
    private Collection $formationsPossibles;

    #[ORM\OneToMany(mappedBy: 'formateur', targetEntity: Creneau::class)]
    private Collection $creneaux;

    #[ORM\OneToOne(inversedBy: 'formateur', cascade: ['persist', 'remove'])]
    private ?User $utilisateur = null;

    public function __construct()
    {
        $this->formationsPossibles = new ArrayCollection();
        $this->creneaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCampusPrincipal(): ?Campus
    {
        return $this->campusPrincipal;
    }

    public function setCampusPrincipal(?Campus $campusPrincipal): self
    {
        $this->campusPrincipal = $campusPrincipal;

        return $this;
    }

    /**
     * @return Collection<int, ModuleFormation>
     */
    public function getFormationsPossibles(): Collection
    {
        return $this->formationsPossibles;
    }

    public function addFormationsPossible(ModuleFormation $formationsPossible): self
    {
        if (!$this->formationsPossibles->contains($formationsPossible)) {
            $this->formationsPossibles->add($formationsPossible);
        }

        return $this;
    }

    public function removeFormationsPossible(ModuleFormation $formationsPossible): self
    {
        $this->formationsPossibles->removeElement($formationsPossible);

        return $this;
    }

    /**
     * @return Collection<int, Creneau>
     */
    public function getCreneaux(): Collection
    {
        return $this->creneaux;
    }

    public function addCreneaux(Creneau $creneaux): self
    {
        if (!$this->creneaux->contains($creneaux)) {
            $this->creneaux->add($creneaux);
            $creneaux->setFormateur($this);
        }

        return $this;
    }

    public function removeCreneaux(Creneau $creneaux): self
    {
        if ($this->creneaux->removeElement($creneaux)) {
            // set the owning side to null (unless already changed)
            if ($creneaux->getFormateur() === $this) {
                $creneaux->setFormateur(null);
            }
        }

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?User $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
