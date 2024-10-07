<?php

namespace App\Entity;

use App\Repository\GenreMusicalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
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
     * @var Collection<int, Lier>
     */
    #[ORM\OneToMany(targetEntity: Lier::class, mappedBy: 'idGenreMusical', orphanRemoval: true)]
    #[Groups(['genre_musical_detail'])]
    private Collection $estAimePar;

    public function __construct()
    {
        $this->reseauxLies = new ArrayCollection();
        $this->estAimePar = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant du genre musical.
     *
     * @return int|null
     */
    #[Groups(['genre_musical_detail'])]
    public function getIdGenreMusical(): ?int
    {
        return $this->idGenreMusical;
    }

    /**
     * Récupère le nom du genre musical.
     *
     * @return string|null
     */
    #[Groups(['genre_musical_detail'])]
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
     * @return Collection<int, Lier>
     */
    #[Groups(['genre_musical_detail'])]
    public function getEstAimePar(): Collection
    {
        return $this->estAimePar;
    }

    public function addEstAimePar(Lier $estAimePar): static
    {
        if (!$this->estAimePar->contains($estAimePar)) {
            $this->estAimePar->add($estAimePar);
            $estAimePar->setIdGenreMusical($this);
        }

        return $this;
    }

    public function removeEstAimePar(Lier $estAimePar): static
    {
        if ($this->estAimePar->removeElement($estAimePar)) {
            if ($estAimePar->getIdGenreMusical() === $this) {
                $estAimePar->setIdGenreMusical(null);
            }
        }

        return $this;
    }
}
