<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe représentant une offre.
 *
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    /**
     * @var int|null L'identifiant unique de l'offre.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null La description de la tournée.
     * Doit être une chaîne de caractères d'une longueur maximale de 255.
     */
    #[ORM\Column(length: 255)]
    private ?string $descrTournee = null;

    /**
     * @var \DateTimeInterface|null La date minimale proposée pour l'offre.
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateMinProposee = null;

    /**
     * @var \DateTimeInterface|null La date maximale proposée pour l'offre.
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateMaxProposee = null;

    /**
     * @var string|null La ville ciblée par l'offre.
     * Doit être une chaîne de caractères d'une longueur maximale de 70.
     */
    #[ORM\Column(length: 70)]
    private ?string $villeVisee = null;

    /**
     * @var string|null La région ciblée par l'offre.
     * Doit être une chaîne de caractères d'une longueur maximale de 80.
     */
    #[ORM\Column(length: 80)]
    private ?string $regionVisee = null;

    /**
     * @var int|null Le nombre minimum de places proposées.
     */
    #[ORM\Column]
    private ?int $placeMin = null;

    /**
     * @var int|null Le nombre maximum de places proposées.
     */
    #[ORM\Column]
    private ?int $placeMax = null;

    /**
     * @var \DateTimeInterface|null La date limite pour répondre à l'offre.
     */
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateLimiteReponse = null;

    /**
     * @var bool|null Indique si l'offre est validée.
     */
    #[ORM\Column]
    private ?bool $validee = null;

    /**
     * @var Utilisateur|null L'artiste concerné par l'offre.
     * Cette relation est obligatoire.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $ArtisteConcerne = null;

    /**
     * Récupère l'identifiant de l'offre.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère la description de la tournée.
     *
     * @return string|null
     */
    public function getDescrTournee(): ?string
    {
        return $this->descrTournee;
    }

    /**
     * Définit la description de la tournée.
     *
     * @param string $descrTournee La description de la tournée.
     * @return static
     */
    public function setDescrTournee(string $descrTournee): static
    {
        $this->descrTournee = $descrTournee;
        return $this;
    }

    /**
     * Récupère la date minimale proposée.
     *
     * @return \DateTimeInterface|null
     */
    public function getDateMinProposee(): ?\DateTimeInterface
    {
        return $this->dateMinProposee;
    }

    /**
     * Définit la date minimale proposée.
     *
     * @param \DateTimeInterface $dateMinProposee La date minimale.
     * @return static
     */
    public function setDateMinProposee(\DateTimeInterface $dateMinProposee): static
    {
        $this->dateMinProposee = $dateMinProposee;
        return $this;
    }

    /**
     * Récupère la date maximale proposée.
     *
     * @return \DateTimeInterface|null
     */
    public function getDateMaxProposee(): ?\DateTimeInterface
    {
        return $this->dateMaxProposee;
    }

    /**
     * Définit la date maximale proposée.
     *
     * @param \DateTimeInterface $dateMaxProposee La date maximale.
     * @return static
     */
    public function setDateMaxProposee(\DateTimeInterface $dateMaxProposee): static
    {
        $this->dateMaxProposee = $dateMaxProposee;
        return $this;
    }

    /**
     * Récupère la ville visée.
     *
     * @return string|null
     */
    public function getVilleVisee(): ?string
    {
        return $this->villeVisee;
    }

    /**
     * Définit la ville visée.
     *
     * @param string $villeVisee La ville visée.
     * @return static
     */
    public function setVilleVisee(string $villeVisee): static
    {
        $this->villeVisee = $villeVisee;
        return $this;
    }

    /**
     * Récupère la région visée.
     *
     * @return string|null
     */
    public function getRegionVisee(): ?string
    {
        return $this->regionVisee;
    }

    /**
     * Définit la région visée.
     *
     * @param string $regionVisee La région visée.
     * @return static
     */
    public function setRegionVisee(string $regionVisee): static
    {
        $this->regionVisee = $regionVisee;
        return $this;
    }

    /**
     * Récupère le nombre minimum de places.
     *
     * @return int|null
     */
    public function getPlaceMin(): ?int
    {
        return $this->placeMin;
    }

    /**
     * Définit le nombre minimum de places.
     *
     * @param int $placeMin Le nombre minimum de places.
     * @return static
     */
    public function setPlaceMin(int $placeMin): static
    {
        $this->placeMin = $placeMin;
        return $this;
    }

    /**
     * Récupère le nombre maximum de places.
     *
     * @return int|null
     */
    public function getPlaceMax(): ?int
    {
        return $this->placeMax;
    }

    /**
     * Définit le nombre maximum de places.
     *
     * @param int $placeMax Le nombre maximum de places.
     * @return static
     */
    public function setPlaceMax(int $placeMax): static
    {
        $this->placeMax = $placeMax;
        return $this;
    }

    /**
     * Récupère la date limite de réponse.
     *
     * @return \DateTimeInterface|null
     */
    public function getDateLimiteReponse(): ?\DateTimeInterface
    {
        return $this->dateLimiteReponse;
    }

    /**
     * Définit la date limite de réponse.
     *
     * @param \DateTimeInterface $dateLimiteReponse La date limite.
     * @return static
     */
    public function setDateLimiteReponse(\DateTimeInterface $dateLimiteReponse): static
    {
        $this->dateLimiteReponse = $dateLimiteReponse;
        return $this;
    }

    /**
     * Indique si l'offre est validée.
     *
     * @return bool|null
     */
    public function isValidee(): ?bool
    {
        return $this->validee;
    }

    /**
     * Définit si l'offre est validée.
     *
     * @param bool $validee Indique si l'offre est validée.
     * @return static
     */
    public function setValidee(bool $validee): static
    {
        $this->validee = $validee;
        return $this;
    }

    /**
     * Récupère l'artiste concerné par l'offre.
     *
     * @return Utilisateur|null
     */
    public function getArtisteConcerne(): ?Utilisateur
    {
        return $this->ArtisteConcerne;
    }

    /**
     * Définit l'artiste concerné par l'offre.
     *
     * @param Utilisateur|null $idArtisteConcerne L'artiste concerné.
     * @return static
     */
    public function setArtisteConcerne(?Utilisateur $ArtisteConcerne): static
    {
        $this->ArtisteConcerne = $ArtisteConcerne;
        return $this;
    }
}
