<?php

namespace App\Entity;

use App\Repository\CreneauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreneauRepository::class)]
class Creneau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\ManyToOne(inversedBy: 'creneaux')]
    private ?Formateur $formateur = null;

    #[ORM\ManyToOne(inversedBy: 'creneaux')]
    private ?GroupePromotion $groupePromotion = null;

    #[ORM\ManyToOne(inversedBy: 'creneaux')]
    private ?ModuleFormation $moduleFormation = null;

    #[ORM\ManyToOne(inversedBy: 'creneaux')]
    private ?Salle $sallePrincipale = null;

    #[ORM\ManyToMany(targetEntity: Salle::class, inversedBy: 'creneaux')]
    private Collection $sallesSecondaires;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $commentaire = null;

    public function __construct()
    {
        $this->sallesSecondaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

        return $this;
    }

    public function getGroupePromotion(): ?GroupePromotion
    {
        return $this->groupePromotion;
    }

    public function setGroupePromotion(?GroupePromotion $groupePromotion): self
    {
        $this->groupePromotion = $groupePromotion;

        return $this;
    }

    public function getModuleFormation(): ?ModuleFormation
    {
        return $this->moduleFormation;
    }

    public function setModuleFormation(?ModuleFormation $moduleFormation): self
    {
        $this->moduleFormation = $moduleFormation;

        return $this;
    }

    public function getSallePrincipale(): ?Salle
    {
        return $this->sallePrincipale;
    }

    public function setSallePrincipale(?Salle $sallePrincipale): self
    {
        $this->sallePrincipale = $sallePrincipale;

        return $this;
    }

    /**
     * @return Collection<int, Salle>
     */
    public function getSallesSecondaires(): Collection
    {
        return $this->sallesSecondaires;
    }

    public function addSallesSecondaire(Salle $sallesSecondaire): self
    {
        if (!$this->sallesSecondaires->contains($sallesSecondaire)) {
            $this->sallesSecondaires->add($sallesSecondaire);
        }

        return $this;
    }

    public function removeSallesSecondaire(Salle $sallesSecondaire): self
    {
        $this->sallesSecondaires->removeElement($sallesSecondaire);

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getModuleFormation()->getNom() . "\n<b>" . $this->getGroupePromotion()->getNom()."</b>";
    }


}
