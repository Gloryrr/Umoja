<?php

namespace App\Entity;

use App\Repository\ConditionsFinancieresRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Classe représentant les conditions financières d'une salle ou d'un contrat.
 *
 * @ORM\Entity(repositoryClass=ConditionsFinancieresRepository::class)
 */
#[ORM\Entity(repositoryClass: ConditionsFinancieresRepository::class)]
class ConditionsFinancieres
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['conditions_financieres:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['conditions_financieres:read', 'conditions_financieres:write'])]
    private ?int $minimunGaranti = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['conditions_financieres:read', 'conditions_financieres:write'])]
    private ?string $conditionsPaiement = null;

    #[ORM\Column]
    #[Groups(['conditions_financieres:read', 'conditions_financieres:write'])]
    private ?float $pourcentageRecette = null;

    #[ORM\OneToMany(
        targetEntity: Offre::class,
        mappedBy: "conditionsFinancieres",
        orphanRemoval: true,
        cascade: ["remove"]
    )]
    #[Groups(['conditions_financieres:read'])]
    private Collection $offres;


    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant unique des conditions financières.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère le montant minimum garanti.
     *
     * @return int|null
     */
    public function getMinimunGaranti(): ?int
    {
        return $this->minimunGaranti;
    }

    /**
     * Définit le montant minimum garanti.
     *
     * @param int $minimunGaranti
     * @return static
     */
    public function setMinimunGaranti(int $minimunGaranti): static
    {
        $this->minimunGaranti = $minimunGaranti;

        return $this;
    }

    /**
     * Récupère les conditions de paiement.
     *
     * @return string|null
     */
    public function getConditionsPaiement(): ?string
    {
        return $this->conditionsPaiement;
    }

    /**
     * Définit les conditions de paiement.
     *
     * @param string $conditionsPaiement
     * @return static
     */
    public function setConditionsPaiement(string $conditionsPaiement): static
    {
        $this->conditionsPaiement = $conditionsPaiement;

        return $this;
    }

    /**
     * Récupère le pourcentage de recette.
     *
     * @return float|null
     */
    public function getPourcentageRecette(): ?float
    {
        return $this->pourcentageRecette;
    }

    /**
     * Définit le pourcentage de recette.
     *
     * @param float $pourcentageRecette
     * @return static
     */
    public function setPourcentageRecette(float $pourcentageRecette): static
    {
        $this->pourcentageRecette = $pourcentageRecette;

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
            $offre->setConditionsFinancieres($this);
        }
        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            if ($offre->getConditionsFinancieres() === $this) {
                $offre->setConditionsFinancieres(null);
            }
        }
        return $this;
    }
}
