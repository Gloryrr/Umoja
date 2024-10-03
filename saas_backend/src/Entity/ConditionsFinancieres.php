<?php

namespace App\Entity;

use App\Repository\ConditionsFinancieresRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe représentant les conditions financières d'une salle ou d'un contrat.
 *
 * @ORM\Entity(repositoryClass=ConditionsFinancieresRepository::class)
 */
#[ORM\Entity(repositoryClass: ConditionsFinancieresRepository::class)]
class ConditionsFinancieres
{
    /**
     * @var int|null L'identifiant unique des conditions financières.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var int|null Le montant minimum garanti pour une transaction ou un contrat.
     */
    #[ORM\Column]
    private ?int $minimunGaranti = null;

    /**
     * @var string|null Les conditions de paiement associées.
     * Peut contenir des détails sur les délais de paiement, les modalités, etc.
     */
    #[ORM\Column(type: Types::TEXT)]
    private ?string $conditionsPaiement = null;

    /**
     * @var float|null Le pourcentage de recette appliqué sur les transactions.
     */
    #[ORM\Column]
    private ?float $pourcentageRecette = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $offre = null;

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

    /**
     * Récupère l'offre associée aux conditions financières.
     *
     * @return Offre|null L'offre actuelle, ou null si aucune n'a été définie.
     */
    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    /**
     * Définit l'offre associée aux conditions financières.
     *
     * @param Offre $offre L'offre à associer.
     * @return static Retourne l'instance actuelle pour permettre le chaînage de méthodes.
     */
    public function setOffre(Offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }
}
