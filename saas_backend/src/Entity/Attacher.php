<?php

namespace App\Entity;

use App\Repository\AttacherRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Attacher
 * Représente la relation entre un artiste et un genre musical.
 *
 * @ORM\Entity(repositoryClass=AttacherRepository::class)
 */
#[ORM\Entity(repositoryClass: AttacherRepository::class)]
class Attacher
{
    /**
     * Identifiant unique de l'entité.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    /**
     * L'artiste associé à cette relation.
     */
    #[ORM\ManyToOne(targetEntity: Artiste::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artiste $idArtiste = null;

    /**
     * Le genre musical associé à cette relation.
     */
    #[ORM\ManyToOne(targetEntity: GenreMusical::class)]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: "id_genre_musical")]
    private ?GenreMusical $genresAttaches = null;

    /**
     * Obtient l'identifiant unique de l'entité.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtient l'artiste associé à cette relation.
     *
     * @return Artiste|null
     */
    public function getIdArtiste(): ?Artiste
    {
        return $this->idArtiste;
    }

    /**
     * Définit l'artiste associé à cette relation.
     *
     * @param Artiste|null $idArtiste
     * @return static
     */
    public function setIdArtiste(?Artiste $idArtiste): static
    {
        $this->idArtiste = $idArtiste;
        return $this;
    }

    /**
     * Obtient le genre musical associé à cette relation.
     *
     * @return GenreMusical|null
     */
    public function getGenresAttaches(): ?GenreMusical
    {
        return $this->genresAttaches;
    }

    /**
     * Définit le genre musical associé à cette relation.
     *
     * @param GenreMusical|null $genresAttaches
     * @return static
     */
    public function setGenresAttaches(?GenreMusical $genresAttaches): static
    {
        $this->genresAttaches = $genresAttaches;
        return $this;
    }
}
