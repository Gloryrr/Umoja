<?php

namespace App\Entity;

use App\Repository\GenreMusicalRepository;
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
     * Récupère l'identifiant du genre musical.
     *
     * @return int|null
     */
    public function getIdGenreMusical(): ?int
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
}
