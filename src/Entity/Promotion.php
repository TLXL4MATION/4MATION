<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
class Promotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'promotion', targetEntity: GroupePromotion::class)]
    private Collection $groupePromotions;

    public function __construct()
    {
        $this->groupePromotions = new ArrayCollection();
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

    /**
     * @return Collection<int, GroupePromotion>
     */
    public function getGroupePromotions(): Collection
    {
        return $this->groupePromotions;
    }

    public function addGroupePromotion(GroupePromotion $groupePromotion): self
    {
        if (!$this->groupePromotions->contains($groupePromotion)) {
            $this->groupePromotions->add($groupePromotion);
            $groupePromotion->setPromotion($this);
        }

        return $this;
    }

    public function removeGroupePromotion(GroupePromotion $groupePromotion): self
    {
        if ($this->groupePromotions->removeElement($groupePromotion)) {
            // set the owning side to null (unless already changed)
            if ($groupePromotion->getPromotion() === $this) {
                $groupePromotion->setPromotion(null);
            }
        }

        return $this;
    }
}
