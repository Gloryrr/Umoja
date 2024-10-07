<?php

namespace App\Entity;

use App\Repository\LierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LierRepository::class)]
class Lier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'estLierAuxGenres')]
    #[ORM\JoinColumn(name: 'id_reseau', referencedColumnName: 'id_reseau', nullable: false)]
    private ?Reseau $idReseau = null;

    #[ORM\ManyToOne(inversedBy: 'estAimePar')]
    #[ORM\JoinColumn(name: 'id_genre_musical', referencedColumnName: 'id_genre_musical', nullable: false)]
    private ?GenreMusical $idGenreMusical = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdReseau(): ?Reseau
    {
        return $this->idReseau;
    }

    public function setIdReseau(?Reseau $idReseau): static
    {
        $this->idReseau = $idReseau;

        return $this;
    }

    public function getIdGenreMusical(): ?GenreMusical
    {
        return $this->idGenreMusical;
    }

    public function setIdGenreMusical(?GenreMusical $idGenreMusical): static
    {
        $this->idGenreMusical = $idGenreMusical;

        return $this;
    }
}
