<?php

namespace App\Entity;

use App\Repository\CreneauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Validator\Constraints\CreneauValidation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


#[ORM\Entity(repositoryClass: CreneauRepository::class)]
#[CreneauValidation]
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

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column(nullable: true)]
    private ?bool $accepte = null;

    #[ORM\Column(nullable: true)]
    private ?bool $envoye = null;

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

    public function isAccepte(): ?bool
    {
        return $this->accepte;
    }

    public function setAccepte(?bool $accepte): self
    {
        $this->accepte = $accepte;

        return $this;
    }

    public function isEnvoye(): ?bool
    {
        return $this->envoye;
    }

    public function setEnvoye(?bool $envoye): self
    {
        $this->envoye = $envoye;

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context, $payload): void
    {
        $errors = $this->getValidation();
        if ($errors) {
            foreach ($errors as $error) {
                $context->buildViolation($error)
                    ->atPath('contact')
                    ->addViolation();
            }
        }

    }

    private function getValidation(): array
    {
        $errors = [];
        if (!$this->getModuleFormation()->isFormateurAllowed($this->getFormateur())) {
            $errors[] = "Ce formateur ne peux pas donner ce cours";
        }
        if ($this->getSallePrincipale()->isSameAsSecondary($this->getSallesSecondaires())) {
            $errors[] = "La salle principale ne peut pas être la même qu'une secondaire";
        }
        if (!$this->foramteurIsFree()) {
            $errors[] = "Le formateur a déjà une formation sur ce créneaux";
        }
        if (!$this->groupePromotionIsFree()) {
            $errors[] = "La promotion a déjà une formation sur ce créneaux";
        }
        return $errors;
    }

    private function foramteurIsFree(): bool
    {
        $creneauExistant = $this->getFormateur()->getCreneaux();
        foreach ($creneauExistant->toArray() as $creneau) {
            if ($this->dateDebut < $creneau->getDateFin() && $this->dateFin > $creneau->getDateDebut()) {
                return false;
            }
        }
        return true;
    }

    private function groupePromotionIsFree(): bool
    {
        $creneauExistant = $this->getGroupePromotion()->getCreneaux();
        foreach ($creneauExistant->toArray() as $creneau) {
            if ($this->dateDebut < $creneau->getDateFin() && $this->dateFin > $creneau->getDateDebut()) {
                return false;
            }
        }
        return true;
    }


}
