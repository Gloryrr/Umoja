<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Reponse
 *
 * Représente une réponse à une offre dans le système.
 * Chaque réponse est associée à un état de réponse et à une offre,
 * et contient des informations comme la période de participation et le prix de participation.
 */
#[ORM\Entity(repositoryClass: ReponseRepository::class)]
class Reponse
{
    /**
     * @var int|null $idR
     * L'identifiant unique de la réponse.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idR = null;

    /**
     * @var EtatReponse|null $idEtatReponse
     * L'état actuel de la réponse.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?EtatReponse $idEtatReponse = null;

    /**
     * @var Offre|null $idOffre
     * L'offre à laquelle cette réponse est liée.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $idOffre = null;

    /**
     * @var \DateTimeInterface|null $dateDebut
     * La date de début de la participation à l'offre.
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    /**
     * @var \DateTimeInterface|null $dateFin
     * La date de fin de la participation à l'offre.
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    /**
     * @var float|null $prixParticipation
     * Le montant du prix de participation à l'offre.
     */
    #[ORM\Column]
    private ?float $prixParticipation = null;

    /**
     * Retourne l'identifiant de la réponse.
     *
     * @return int|null
     * L'identifiant unique de la réponse.
     */
    public function getIdR(): ?int
    {
        return $this->idR;
    }

    /**
     * Retourne l'état de la réponse.
     *
     * @return EtatReponse|null
     * L'état associé à cette réponse.
     */
    public function getIdEtatReponse(): ?EtatReponse
    {
        return $this->idEtatReponse;
    }

    /**
     * Définit l'état de la réponse.
     *
     * @param EtatReponse|null $idEtatReponse
     * L'état associé à cette réponse.
     *
     * @return static
     */
    public function setIdEtatReponse(?EtatReponse $idEtatReponse): static
    {
        $this->idEtatReponse = $idEtatReponse;

        return $this;
    }

    /**
     * Retourne l'offre associée à cette réponse.
     *
     * @return Offre|null
     * L'offre à laquelle cette réponse est liée.
     */
    public function getIdOffre(): ?Offre
    {
        return $this->idOffre;
    }

    /**
     * Définit l'offre associée à cette réponse.
     *
     * @param Offre|null $idOffre
     * L'offre à laquelle cette réponse sera liée.
     *
     * @return static
     */
    public function setIdOffre(?Offre $idOffre): static
    {
        $this->idOffre = $idOffre;

        return $this;
    }

    /**
     * Retourne la date de début de la participation à l'offre.
     *
     * @return \DateTimeInterface|null
     * La date de début de la participation.
     */
    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    /**
     * Définit la date de début de la participation à l'offre.
     *
     * @param \DateTimeInterface $dateDebut
     * La date de début de la participation.
     *
     * @return static
     */
    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Retourne la date de fin de la participation à l'offre.
     *
     * @return \DateTimeInterface|null
     * La date de fin de la participation.
     */
    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    /**
     * Définit la date de fin de la participation à l'offre.
     *
     * @param \DateTimeInterface $dateFin
     * La date de fin de la participation.
     *
     * @return static
     */
    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Retourne le montant du prix de participation à l'offre.
     *
     * @return float|null
     * Le montant du prix de participation.
     */
    public function getPrixParticipation(): ?float
    {
        return $this->prixParticipation;
    }

    /**
     * Définit le montant du prix de participation à l'offre.
     *
     * @param float $prixParticipation
     * Le montant du prix de participation.
     *
     * @return static
     */
    public function setPrixParticipation(?float $prixParticipation): static
    {
        $this->prixParticipation = $prixParticipation;

        return $this;
    }
}
