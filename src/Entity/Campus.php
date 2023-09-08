<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampusRepository::class)]
class Campus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToOne(inversedBy: 'campus', cascade: ['persist', 'remove'])]
    private ?Adresse $adresse = null;

    #[ORM\OneToMany(mappedBy: 'campusPrincipal', targetEntity: Formateur::class)]
    private Collection $formateurs;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Salle::class)]
    private Collection $salles;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'campus')]
    private Collection $users;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heureMin = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $heureMax = null;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Promotion::class, orphanRemoval: true)]
    private Collection $promotions;

    public function __construct()
    {
        $this->formateurs = new ArrayCollection();
        $this->salles = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->promotions = new ArrayCollection();
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

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Formateur>
     */
    public function getFormateurs(): Collection
    {
        return $this->formateurs;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateurs->contains($formateur)) {
            $this->formateurs->add($formateur);
            $formateur->setCampusPrincipal($this);
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        if ($this->formateurs->removeElement($formateur)) {
            // set the owning side to null (unless already changed)
            if ($formateur->getCampusPrincipal() === $this) {
                $formateur->setCampusPrincipal(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Salle>
     */
    public function getSalles(): Collection
    {
        return $this->salles;
    }

    public function addSalle(Salle $salle): self
    {
        if (!$this->salles->contains($salle)) {
            $this->salles->add($salle);
            $salle->setCampus($this);
        }

        return $this;
    }

    public function removeSalle(Salle $salle): self
    {
        if ($this->salles->removeElement($salle)) {
            // set the owning side to null (unless already changed)
            if ($salle->getCampus() === $this) {
                $salle->setCampus(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return ($this->nom);
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addCampus($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeCampus($this);
        }

        return $this;
    }

    public function getHeureMin(): ?\DateTimeInterface
    {
        return $this->heureMin;
    }

    public function setHeureMin(?\DateTimeInterface $heureMin): self
    {
        $this->heureMin = $heureMin;

        return $this;
    }

    public function getHeureMax(): ?\DateTimeInterface
    {
        return $this->heureMax;
    }

    public function setHeureMax(?\DateTimeInterface $heureMax): self
    {
        $this->heureMax = $heureMax;

        return $this;
    }

    /**
     * @return Collection<int, Promotion>
     */
    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function addPromotion(Promotion $promotion): self
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions->add($promotion);
            $promotion->setCampus($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): self
    {
        if ($this->promotions->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getCampus() === $this) {
                $promotion->setCampus(null);
            }
        }

        return $this;
    }


}
