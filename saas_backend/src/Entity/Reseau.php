<?php

namespace App\Entity;

use App\Repository\ReseauRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * Classe représentant un Réseau.
 *
 * @ORM\Entity(repositoryClass=ReseauRepository::class)
 */
#[ORM\Entity(repositoryClass: ReseauRepository::class)]
class Reseau
{
    /**
     * L'identifiant unique du réseau.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['reseau:read'])]
    private ?int $id = null;

    /**
     * Le nom du réseau.
     * Doit avoir une longueur maximale de 100 caractères.
     *
     * @var string|null
     */
    #[ORM\Column(length: 100)]
    #[Groups([
        'reseau:read',
        'reseau:write',
        'utilisateur:read',
        'offre:read',
        'genre_musical:read',
    ])]
    private ?string $nomReseau = null;

    /**
     * Les utilisateurs associés au réseau.
     *
     * @var Collection<int, Utilisateur>
     */
    #[ORM\ManyToMany(targetEntity: Utilisateur::class, mappedBy: "reseaux", cascade: ["persist"])]
    #[Groups(['reseau:read'])]
    #[MaxDepth(1)]
    private Collection $utilisateurs;

    /**
     * Les genres musicaux associés au réseau.
     *
     * @var Collection<int, GenreMusical>
     */
    #[ORM\ManyToMany(targetEntity: GenreMusical::class, inversedBy: "reseaux", cascade: ["persist"])]
    #[ORM\JoinTable(name: "lier")]
    #[ORM\JoinColumn(name: "reseau_id", onDelete: "CASCADE")]
    #[ORM\InverseJoinColumn(name: "genre_musical_id", onDelete: "CASCADE")]
    #[Groups(['reseau:read', 'reseau:write'])]
    #[MaxDepth(1)]
    private Collection $genresMusicaux;

    /**
     * Les offres publiées sur le réseau.
     *
     * @var Collection<int, Offre>
     */
    #[ORM\ManyToMany(targetEntity: Offre::class, inversedBy: "reseaux", cascade: ["persist"])]
    #[ORM\JoinTable(name: "poster")]
    #[ORM\JoinColumn(name: "reseau_id", onDelete: "CASCADE")]
    #[ORM\InverseJoinColumn(name: "offre_id", onDelete: "CASCADE")]
    #[Groups(['reseau:read', 'reseau:write'])]
    #[MaxDepth(1)]
    private Collection $offres;

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
        $this->genresMusicaux = new ArrayCollection();
        $this->offres = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant du réseau.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère le nom du réseau.
     *
     * @return string|null
     */
    public function getNomReseau(): ?string
    {
        return $this->nomReseau;
    }

    /**
     * Définit le nom du réseau.
     *
     * @param string $nomReseau Le nom à assigner au réseau.
     * @return static
     */
    public function setNomReseau(string $nomReseau): static
    {
        $this->nomReseau = $nomReseau;

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
            $utilisateur->addReseau($this);
        }
        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            $utilisateur->removeReseau($this);
        }
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
            $genreMusical->addReseau($this);
        }
        return $this;
    }

    public function removeGenreMusical(GenreMusical $genreMusical): self
    {
        if ($this->genresMusicaux->removeElement($genreMusical)) {
            $genreMusical->removeReseau($this);
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
            $offre->addReseau($this);
        }
        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            $offre->removeReseau($this);
        }
        return $this;
    }
}
