<?php

namespace App\Entity;

use App\Repository\ReponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
     * L'identifiant unique de la réponse.
     *
     * @var int
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'reponse:read',
        'utilisateur:read',
        'offre:read',
        'etat_reponse:read',
    ])]
    private int $id = 0;

    /**
     * L'état de la réponse.
     *
     * @var EtatReponse
     */
    #[ORM\ManyToOne(targetEntity: EtatReponse::class, inversedBy: "reponses", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private EtatReponse $etatReponse;

    /**
     * L'offre associée à la réponse.
     *
     * @var Offre
     */
    #[ORM\ManyToOne(targetEntity: Offre::class, inversedBy: "reponses", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private Offre $offre;

    /**
     * L'utilisateur qui a fait la réponse.
     *
     * @var Utilisateur
     */
    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "reponses", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    #[Groups(['reponse:read', 'reponse:write', 'utilisateur:read'])]
    private Utilisateur $utilisateur;

    /**
     * La date de début de la participation à l'offre.
     *
     * @var \DateTimeInterface
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private \DateTimeInterface $dateDebut;

    /**
     * La date de fin de la participation à l'offre.
     *
     * @var \DateTimeInterface
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private \DateTimeInterface $dateFin;

    /**
     * Le montant du prix de participation à l'offre.
     *
     * @var float
     */
    #[ORM\Column]
    #[Groups(['reponse:read', 'reponse:write'])]
    private float $prixParticipation;

    /**
     * Retourne l'identifiant de la réponse.
     *
     * @return int
     * L'identifiant unique de la réponse.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Retourne l'état de la réponse.
     *
     * @return EtatReponse
     * L'état associé à cette réponse.
     */
    public function getEtatReponse(): EtatReponse
    {
        return $this->etatReponse;
    }

    /**
     * Définit l'état de la réponse.
     *
     * @param EtatReponse $idEtatReponse
     * L'état associé à cette réponse.
     *
     * @return static
     */
    public function setEtatReponse(?EtatReponse $etatReponse): static
    {
        $this->etatReponse = $etatReponse;

        return $this;
    }

    /**
     * Retourne l'offre associée à cette réponse.
     *
     * @return Offre
     * L'offre à laquelle cette réponse est liée.
     */
    public function getOffre(): Offre
    {
        return $this->offre;
    }

    /**
     * Définit l'offre associée à cette réponse.
     *
     * @param Offre $idOffre
     * L'offre à laquelle cette réponse sera liée.
     *
     * @return static
     */
    public function setOffre(?Offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }

    /**
     * Retourne l'offre associée à cette réponse.
     *
     * @return Utilisateur
     * L'offre à laquelle cette réponse est liée.
     */
    public function getUtilisateur(): Utilisateur
    {
        return $this->utilisateur;
    }

    /**
     * Définit l'offre associée à cette réponse.
     *
     * @param Utilisateur $idOffre
     * L'offre à laquelle cette réponse sera liée.
     *
     * @return static
     */
    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Retourne la date de début de la participation à l'offre.
     *
     * @return \DateTimeInterface
     * La date de début de la participation.
     */
    public function getDateDebut(): \DateTimeInterface
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
     * @return \DateTimeInterface
     * La date de fin de la participation.
     */
    public function getDateFin(): \DateTimeInterface
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
     * @return float
     * Le montant du prix de participation.
     */
    public function getPrixParticipation(): float
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
