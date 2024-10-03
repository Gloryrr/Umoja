<?php

namespace App\Entity;

use App\Repository\ReseauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe représentant un Réseau.
 *
 * @ORM\Entity(repositoryClass=ReseauRepository::class)
 */
#[ORM\Entity(repositoryClass: ReseauRepository::class)]
class Reseau
{
    /**
     * @var int|null L'identifiant unique du réseau.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idReseau = null;

    /**
     * @var string|null Le nom du réseau.
     * Doit avoir une longueur maximale de 100 caractères.
     */
    #[ORM\Column(length: 100)]
    private ?string $nomReseau = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\ManyToMany(targetEntity: Utilisateur::class, inversedBy: 'etreMembreDe')]
    #[ORM\JoinTable(
        name: "appartient",
        joinColumns: [new ORM\JoinColumn(name: "id_reseau", referencedColumnName: "id_reseau")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "id_utilisateur", referencedColumnName: "id_utilisateur")]
    )]
    private Collection $membres;

    /**
     * @var Collection<int, GenreMusical>
     */
    #[ORM\ManyToMany(targetEntity: GenreMusical::class, inversedBy: 'reseauxLies')]
    #[ORM\JoinTable(
        name: "lier",
        joinColumns: [new ORM\JoinColumn(name: "id_reseau", referencedColumnName: "id_reseau")],
        inverseJoinColumns: [new ORM\JoinColumn(name: "id_genre_musical", referencedColumnName: "id_genre_musical")]
    )]
    private Collection $genresLies;

    public function __construct()
    {
        $this->genresLies = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant du réseau.
     *
     * @return int|null
     */
    public function getIdReseau(): ?int
    {
        return $this->idReseau;
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

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Utilisateur $membre): static
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
        }

        return $this;
    }

    public function removeMembre(Utilisateur $membre): static
    {
        $this->membres->removeElement($membre);

        return $this;
    }

    /**
     * @return Collection<int, GenreMusical>
     */
    public function getGenresLies(): Collection
    {
        return $this->genresLies;
    }

    public function addGenresLy(GenreMusical $genresLy): static
    {
        if (!$this->genresLies->contains($genresLy)) {
            $this->genresLies->add($genresLy);
        }

        return $this;
    }

    public function removeGenresLy(GenreMusical $genresLy): static
    {
        $this->genresLies->removeElement($genresLy);

        return $this;
    }
}
