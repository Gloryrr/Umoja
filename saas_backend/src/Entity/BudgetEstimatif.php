<?php

namespace App\Entity;

use App\Repository\BudgetEstimatifRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BudgetEstimatifRepository::class)]
class BudgetEstimatif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['budget_estimatif:read'])]
    private ?int $id = null;
    
    #[ORM\Column]
    #[Groups(['budget_estimatif:read', 'budget_estimatif:write'])]
    private ?int $cachetArtiste = null;
    
    #[ORM\Column]
    #[Groups(['budget_estimatif:read', 'budget_estimatif:write'])]
    private ?int $fraisDeplacement = null;
    
    #[ORM\Column]
    #[Groups(['budget_estimatif:read', 'budget_estimatif:write'])]
    private ?int $fraisHebergement = null;
    
    #[ORM\Column]
    #[Groups(['budget_estimatif:read', 'budget_estimatif:write'])]
    private ?int $fraisRestauration = null;
    
    #[ORM\OneToMany(targetEntity: Offre::class, mappedBy: "budgetEstimatif", orphanRemoval: true, cascade: ["remove"])]
    #[Groups(['budget_estimatif:read'])]
    private Collection $offres;
    

    public function __construct() {
        $this->offres = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant du budget estimatif.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * insert l'identifiant du budget estimatif.
     *
     * @return int|null
     */
    public function setId(int $id): ?int
    {
        return $this->id = $id;
    }

    /**
     * Récupère le montant du cachet de l'artiste.
     *
     * @return int|null
     */
    public function getCachetArtiste(): ?int
    {
        return $this->cachetArtiste;
    }

    /**
     * Définit le montant du cachet de l'artiste.
     *
     * @param int $cachetArtiste Montant du cachet à définir.
     * @return static
     */
    public function setCachetArtiste(int $cachetArtiste): static
    {
        $this->cachetArtiste = $cachetArtiste;

        return $this;
    }

    /**
     * Récupère le montant des frais de déplacement.
     *
     * @return int|null
     */
    public function getFraisDeplacement(): ?int
    {
        return $this->fraisDeplacement;
    }

    /**
     * Définit le montant des frais de déplacement.
     *
     * @param int $fraisDeplacement Montant des frais de déplacement à définir.
     * @return static
     */
    public function setFraisDeplacement(int $fraisDeplacement): static
    {
        $this->fraisDeplacement = $fraisDeplacement;

        return $this;
    }

    /**
     * Récupère le montant des frais d'hébergement.
     *
     * @return int|null
     */
    public function getFraisHebergement(): ?int
    {
        return $this->fraisHebergement;
    }

    /**
     * Définit le montant des frais d'hébergement.
     *
     * @param int $fraisHebergement Montant des frais d'hébergement à définir.
     * @return static
     */
    public function setFraisHebergement(int $fraisHebergement): static
    {
        $this->fraisHebergement = $fraisHebergement;

        return $this;
    }

    /**
     * Récupère le montant des frais de restauration.
     *
     * @return int|null
     */
    public function getFraisRestauration(): ?int
    {
        return $this->fraisRestauration;
    }

    /**
     * Définit le montant des frais de restauration.
     *
     * @param int $fraisRestauration Montant des frais de restauration à définir.
     * @return static
     */
    public function setFraisRestauration(int $fraisRestauration): static
    {
        $this->fraisRestauration = $fraisRestauration;

        return $this;
    }

    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres[] = $offre;
            $offre->setBudgetEstimatif($this);
        }
        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            if ($offre->getBudgetEstimatif() === $this) {
                $offre->setBudgetEstimatif(null);
            }
        }
        return $this;
    }
}
