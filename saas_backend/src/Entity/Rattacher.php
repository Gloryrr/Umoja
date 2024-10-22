<?php

namespace App\Entity;

use App\Repository\RattacherRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Rattacher
 *
 * @ORM\Entity(repositoryClass=RattacherRepository::class)
 */
#[ORM\Entity(repositoryClass: RattacherRepository::class)]
class Rattacher
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $idA = null;

    /**
     * @var Offre|null
     *
     * @ORM\ManyToOne(targetEntity=Offre::class)
     * @ORM\JoinColumn(nullable=false)
     */
    #[ORM\ManyToOne(targetEntity: Offre::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $idOffre = null;

    /**
     * @var GenreMusical|null
     *
     * @ORM\ManyToOne(targetEntity=GenreMusical::class)
     * @ORM\JoinColumn(nullable=false)
     */
    #[ORM\ManyToOne(targetEntity: GenreMusical::class)]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: "id_genre_musical")]
    private ?GenreMusical $idGenreMusical = null;

    /**
     * Obtient l'identifiant de Rattacher
     *
     * @return int|null
     */
    public function getIdA(): ?int
    {
        return $this->idA;
    }

    /**
     * Obtient l'offre associée
     *
     * @return Offre|null
     */
    public function getIdOffre(): ?Offre
    {
        return $this->idOffre;
    }

    /**
     * Définit l'offre associée
     *
     * @param Offre|null $idOffre
     * @return self
     */
    public function setIdOffre(?Offre $idOffre): self
    {
        $this->idOffre = $idOffre;
        return $this;
    }

    /**
     * Obtient le genre musical associé
     *
     * @return GenreMusical|null
     */
    public function getIdGenreMusical(): ?GenreMusical
    {
        return $this->idGenreMusical;
    }

    /**
     * Définit le genre musical associé
     *
     * @param GenreMusical|null $idGenreMusical
     * @return self
     */
    public function setIdGenreMusical(?GenreMusical $idGenreMusical): self
    {
        $this->idGenreMusical = $idGenreMusical;
        return $this;
    }
}
