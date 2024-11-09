<?php

namespace App\Entity;

use App\Repository\ArtisteRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArtisteRepository::class)]
class Artiste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['artiste:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['artiste:read', 'artiste:write'])]
    private ?string $nomArtiste = null;

    #[ORM\Column(length: 500, nullable: true)]
    #[Groups(['artiste:read', 'artiste:write'])]
    private ?string $descrArtiste = null;

    #[ORM\ManyToMany(targetEntity: GenreMusical::class, inversedBy: "artistes")]
    #[ORM\JoinTable(name: "attacher")]
    #[ORM\JoinColumn(name: "artiste_id", onDelete: "CASCADE")]
    #[ORM\InverseJoinColumn(name: "genre_musical_id", onDelete: "CASCADE")]
    #[Groups(['artiste:read'])]
    private Collection $genresMusicaux;

    #[ORM\ManyToMany(targetEntity: Offre::class, inversedBy: "artistes")]
    #[ORM\JoinTable(name: "concerner")]
    #[ORM\JoinColumn(name: "artiste_id", onDelete: "CASCADE")]
    #[ORM\InverseJoinColumn(name: "offre_id", onDelete: "CASCADE")]
    #[Groups(['artiste:read'])]
    private Collection $offres;

    public function __construct()
    {
        $this->genresMusicaux = new ArrayCollection();
        $this->offres = new ArrayCollection();
    }

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

    public function getGenresMusicaux(): Collection
    {
        return $this->genresMusicaux;
    }

    public function addGenreMusical(GenreMusical $genreMusical): self
    {
        if (!$this->genresMusicaux->contains($genreMusical)) {
            $this->genresMusicaux->add($genreMusical);
            $genreMusical->addArtiste($this);
        }
        return $this;
    }

    public function removeGenreMusical(GenreMusical $genreMusical): self
    {
        if ($this->genresMusicaux->removeElement($genreMusical)) {
            $genreMusical->removeArtiste($this);
        }
        return $this;
    }

    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
            $offre->addArtiste($this);
        }
        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            $offre->removeArtiste($this);
        }
        return $this;
    }
}
