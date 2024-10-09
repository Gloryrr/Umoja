<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nomArtisteConcerne = null;

    #[ORM\Column(length: 255)]
    private ?string $descrTournee = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateMinProposee = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateMaxProposee = null;

    #[ORM\Column(length: 50)]
    private ?string $villeVisee = null;

    #[ORM\Column(length: 50)]
    private ?string $regionVisee = null;

    #[ORM\Column]
    private ?int $placeMin = null;

    #[ORM\Column]
    private ?int $placeMax = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateLimiteReponse = null;

    #[ORM\Column]
    private ?bool $isValid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomArtisteConcerne(): ?string
    {
        return $this->nomArtisteConcerne;
    }

    public function setNomArtisteConcerne(string $nomArtisteConcerne): static
    {
        $this->nomArtisteConcerne = $nomArtisteConcerne;

        return $this;
    }

    public function getDescrTournee(): ?string
    {
        return $this->descrTournee;
    }

    public function setDescrTournee(string $descrTournee): static
    {
        $this->descrTournee = $descrTournee;

        return $this;
    }

    public function getDateMinProposee(): ?\DateTimeInterface
    {
        return $this->dateMinProposee;
    }

    public function setDateMinProposee(\DateTimeInterface $dateMinProposee): static
    {
        $this->dateMinProposee = $dateMinProposee;

        return $this;
    }

    public function getDateMaxProposee(): ?\DateTimeInterface
    {
        return $this->dateMaxProposee;
    }

    public function setDateMaxProposee(\DateTimeInterface $dateMaxProposee): static
    {
        $this->dateMaxProposee = $dateMaxProposee;

        return $this;
    }

    public function getVilleVisee(): ?string
    {
        return $this->villeVisee;
    }

    public function setVilleVisee(string $villeVisee): static
    {
        $this->villeVisee = $villeVisee;

        return $this;
    }

    public function getRegionVisee(): ?string
    {
        return $this->regionVisee;
    }

    public function setRegionVisee(string $regionVisee): static
    {
        $this->regionVisee = $regionVisee;

        return $this;
    }

    public function getPlaceMin(): ?int
    {
        return $this->placeMin;
    }

    public function setPlaceMin(int $placeMin): static
    {
        $this->placeMin = $placeMin;

        return $this;
    }

    public function getPlaceMax(): ?int
    {
        return $this->placeMax;
    }

    public function setPlaceMax(int $placeMax): static
    {
        $this->placeMax = $placeMax;

        return $this;
    }

    public function getDateLimiteReponse(): ?\DateTimeInterface
    {
        return $this->dateLimiteReponse;
    }

    public function setDateLimiteReponse(\DateTimeInterface $dateLimiteReponse): static
    {
        $this->dateLimiteReponse = $dateLimiteReponse;

        return $this;
    }

    public function isValid(): ?bool
    {
        return $this->isValid;
    }

    public function setValid(bool $isValid): static
    {
        $this->isValid = $isValid;

        return $this;
    }
}
