<?php

namespace App\Entity;

use App\Repository\PreferencerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferencerRepository::class)]
class Preferencer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: "id_utilisateur")]
    private ?Utilisateur $idUtilisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: "id_genre_musical")]
    private ?GenreMusical $idGenreMusical = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): static
    {
        $this->idUtilisateur = $idUtilisateur;

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
