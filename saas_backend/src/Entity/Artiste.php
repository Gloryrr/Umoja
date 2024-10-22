<?php

namespace App\Entity;

use App\Repository\ArtisteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArtisteRepository::class)]
class Artiste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nomArtiste = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $descrArtiste = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomArtiste(): ?string
    {
        return $this->nomArtiste;
    }

    public function setNomArtiste(string $nomArtiste): static
    {
        $this->nomArtiste = $nomArtiste;

        return $this;
    }

    public function getDescrArtiste(): ?string
    {
        return $this->descrArtiste;
    }

    public function setDescrArtiste(?string $descrArtiste): static
    {
        $this->descrArtiste = $descrArtiste;

        return $this;
    }
}
