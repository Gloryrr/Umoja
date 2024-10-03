<?php

namespace App\Entity;

use App\Repository\GenreMusicalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
    private ?int $idGenreMusical = null;

    /**
     * @var string|null Le nom du genre musical.
     * Doit avoir une longueur maximale de 50 caractères.
     */
    #[ORM\Column(length: 50)]
    private ?string $nomGenreMusical = null;

    /**
     * @var Collection<int, Reseau>
     */
    #[ORM\ManyToMany(targetEntity: Reseau::class, mappedBy: 'genresLies')]
    private Collection $reseauxLies;

    public function __construct()
    {
        $this->reseauxLies = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant du genre musical.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->idGenreMusical;
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

    /**
     * @return Collection<int, Reseau>
     */
    public function getReseauxLies(): Collection
    {
        return $this->reseauxLies;
    }

    public function addReseauxLy(Reseau $reseauxLy): static
    {
        if (!$this->reseauxLies->contains($reseauxLy)) {
            $this->reseauxLies->add($reseauxLy);
            $reseauxLy->addGenresLy($this);
        }

        return $this;
    }

    public function removeReseauxLy(Reseau $reseauxLy): static
    {
        if ($this->reseauxLies->removeElement($reseauxLy)) {
            $reseauxLy->removeGenresLy($this);
        }

        return $this;
    }
}
