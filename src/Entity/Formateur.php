<?php

namespace App\Entity;

use App\Repository\FormateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormateurRepository::class)]
class Formateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: "/[0-9]/",
        message: "Le nom ne doit pas comporter de chiffres",
        match: false
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: "/[0-9]/",
        message: "Le prénom ne doit pas comporter de chiffres",
        match: false
    )]
    private ?string $prenom = null;

    #[ORM\ManyToMany(targetEntity: ModuleFormation::class, inversedBy: 'formateurs')]
    private Collection $formationsPossibles;

    #[ORM\OneToMany(mappedBy: 'formateur', targetEntity: Creneau::class, cascade: ['persist', 'remove'])]
    private Collection $creneaux;

    #[ORM\OneToOne(inversedBy: 'formateur', cascade: ['persist', 'remove'])]
    private ?User $utilisateur = null;

    #[ORM\OneToOne(inversedBy: 'formateur', cascade: ['persist', 'remove'])]
    private ?Adresse $adresse = null;

    #[ORM\Column]
    private ?bool $actif = false;

    #[ORM\Column]
    private ?bool $mdpInitialise = false;

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

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNom() . " " . $this->prenom;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function isMdpInitialise(): ?bool
    {
        return $this->mdpInitialise;
    }

    public function setMdpInitialise(bool $mdpInitialise): self
    {
        $this->mdpInitialise = $mdpInitialise;

        return $this;
    }

    /**
     * @return string
     */
    public function getMdpInitialiseText(): string
    {
        return $this->mdpInitialise ? "Changé" : "Non Changé";
    }

    /**
     * @return string
     */
    public function getNombreDemande(): int
    {
        return count(array_filter($this->getCreneaux()->toArray(), function($creneau) {
            return $creneau->isEnvoye();
        }));
    }

}
