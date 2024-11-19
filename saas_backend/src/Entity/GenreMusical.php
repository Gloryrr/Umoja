<?php

namespace App\Entity;

use App\Repository\GenreMusicalRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * Classe représentant un Genre Musical.
 *
 * @ORM\Entity(repositoryClass=GenreMusicalRepository::class)
 */
#[ORM\Entity(repositoryClass: GenreMusicalRepository::class)]
class GenreMusical
{
    /**
     * @var int|null L'identifiant unique du genre musical.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['genre_musical:read'])]
    private ?int $id = null;

    /**
     * @var string|null Le nom du genre musical.
     * Doit avoir une longueur maximale de 50 caractères.
     */
    #[ORM\Column(length: 50)]
    #[Groups([
        'genre_musical:read',
        'genre_musical:write',
        'utilisateur:read',
        'artiste:read',
        'reseau:read',
        'offres:read',
    ])]
    private ?string $nomGenreMusical = null;

    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: "genresMusicaux", cascade: ["persist"])]
    #[Groups(['genre_musical:read'])]
    #[MaxDepth(1)]
    private Collection $utilisateurs;

    #[ORM\ManyToMany(targetEntity: Artiste::class, mappedBy: "genresMusicaux", cascade: ["persist"])]
    #[Groups(['genre_musical:read', 'artiste:read'])]
    #[MaxDepth(1)]
    private Collection $artistes;

    #[ORM\ManyToMany(targetEntity: Reseau::class, mappedBy: "genresMusicaux", cascade: ["persist"])]
    #[Groups(['genre_musical:read'])]
    #[MaxDepth(1)]
    private Collection $reseaux;

    #[ORM\ManyToMany(targetEntity: Offre::class, inversedBy: "genresMusicaux", cascade: ["persist"])]
    #[ORM\JoinTable(name: "rattacher")]
    #[ORM\JoinColumn(name: "genre_musical_id", onDelete: "CASCADE")]
    #[ORM\InverseJoinColumn(name: "offre_id", onDelete: "CASCADE")]
    #[Groups(['genre_musical:read'])]
    #[MaxDepth(1)]
    private Collection $offres;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->artistes = new ArrayCollection();
        $this->reseaux = new ArrayCollection();
        $this->offres = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant du genre musical.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère le nom du genre musical.
     *
     * @return string|null
     */
    public function getNomGenreMusical(): ?string
    {
        return $this->nomGenreMusical;
    }

    /**
     * Définit le nom du genre musical.
     *
     * @param string $nomGenreMusical Le nom à assigner au genre musical.
     * @return static
     */
    public function setNomGenreMusical(string $nomGenreMusical): static
    {
        $this->nomGenreMusical = $nomGenreMusical;

        return $this;
    }

    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->addGenreMusical($this);
        }
        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            $utilisateur->removeGenreMusical($this);
        }
        return $this;
    }

    public function getArtistes(): Collection
    {
        return $this->artistes;
    }

    public function addArtiste(Artiste $artiste): self
    {
        if (!$this->artistes->contains($artiste)) {
            $this->artistes->add($artiste);
            $artiste->addGenreMusical($this);
        }
        return $this;
    }

    public function removeArtiste(Artiste $artiste): self
    {
        if ($this->artistes->removeElement($artiste)) {
            $artiste->removeGenreMusical($this);
        }
        return $this;
    }

    public function getReseaux(): Collection
    {
        return $this->reseaux;
    }

    public function addReseau(Reseau $reseau): self
    {
        if (!$this->reseaux->contains($reseau)) {
            $this->reseaux->add($reseau);
            $reseau->addGenreMusical($this);
        }
        return $this;
    }

    public function removeReseau(Reseau $reseau): self
    {
        if ($this->reseaux->removeElement($reseau)) {
            $reseau->removeGenreMusical($this);
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
            $offre->addGenreMusical($this);
        }
        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            $offre->removeGenreMusical($this);
        }
        return $this;
    }
}
