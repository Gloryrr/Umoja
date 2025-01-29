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
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\Column]
    #[Groups([
        'reponse:read',
        'utilisateur:read',
        'offre:read',
        'etat_reponse:read',
    ])]
    private int $id;

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
     * Le montant du prix de participation à l'offre.
     *
     * @var float
     */
    #[ORM\Column]
    #[Groups(['reponse:read', 'reponse:write'])]
    private float $prixParticipation;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private ?string $nomSalleFestival = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private ?string $nomSalleConcert = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private ?string $datesPossible = null;

    #[ORM\Column(nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private ?int $capacite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private ?\DateTimeInterface $deadline = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private ?string $dureeShow = null;

    #[ORM\Column(nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private ?int $montantCachet = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private ?string $deviseCachet = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private ?string $extras = null;

    #[ORM\Column(nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private ?int $coutExtras = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private ?string $ordrePassage = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['reponse:read', 'reponse:write'])]
    private ?string $conditionsGenerales = null;

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
     * Définit l'id de l'instance
     *
     * @param int
     */
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
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

    public function getNomSalleFestival(): ?string
    {
        return $this->nomSalleFestival;
    }

    public function setNomSalleFestival(string $nomSalleFestival): static
    {
        $this->nomSalleFestival = $nomSalleFestival;

        return $this;
    }

    public function getNomSalleConcert(): ?string
    {
        return $this->nomSalleConcert;
    }

    public function setNomSalleConcert(string $nomSalleConcert): static
    {
        $this->nomSalleConcert = $nomSalleConcert;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDatesPossible(): ?string
    {
        return $this->datesPossible;
    }

    public function setDatesPossible(string $datesPossible): static
    {
        $this->datesPossible = $datesPossible;

        return $this;
    }

    public function getCapacite(): ?int
    {
        return $this->capacite;
    }

    public function setCapacite(int $capacite): static
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getDeadline(): ?\DateTimeInterface
    {
        return $this->deadline;
    }

    public function setDeadline(\DateTimeInterface $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getDureeShow(): ?string
    {
        return $this->dureeShow;
    }

    public function setDureeShow(string $dureeShow): static
    {
        $this->dureeShow = $dureeShow;

        return $this;
    }

    public function getMontantCachet(): ?int
    {
        return $this->montantCachet;
    }

    public function setMontantCachet(int $montantCachet): static
    {
        $this->montantCachet = $montantCachet;

        return $this;
    }

    public function getDeviseCachet(): ?string
    {
        return $this->deviseCachet;
    }

    public function setDeviseCachet(string $deviseCachet): static
    {
        $this->deviseCachet = $deviseCachet;

        return $this;
    }

    public function getExtras(): ?string
    {
        return $this->extras;
    }

    public function setExtras(string $extras): static
    {
        $this->extras = $extras;

        return $this;
    }

    public function getCoutExtras(): ?int
    {
        return $this->coutExtras;
    }

    public function setCoutExtras(int $coutExtras): static
    {
        $this->coutExtras = $coutExtras;

        return $this;
    }

    public function getOrdrePassage(): ?string
    {
        return $this->ordrePassage;
    }

    public function setOrdrePassage(string $ordrePassage): static
    {
        $this->ordrePassage = $ordrePassage;

        return $this;
    }

    public function getConditionsGenerales(): ?string
    {
        return $this->conditionsGenerales;
    }

    public function setConditionsGenerales(string $conditionsGenerales): static
    {
        $this->conditionsGenerales = $conditionsGenerales;

        return $this;
    }
}
