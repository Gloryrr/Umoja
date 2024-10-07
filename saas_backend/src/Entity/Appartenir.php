<?php

namespace App\Entity;

use App\Repository\AppartenirRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppartenirRepository::class)]
class Appartenir
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'estMembreDe')]
    #[ORM\JoinColumn(name: 'id_reseau', referencedColumnName: 'id_reseau', nullable: false)]
    private ?Reseau $idReseau = null;

    #[ORM\ManyToOne(inversedBy: 'appartientA')]
    #[ORM\JoinColumn(name: 'id_utilisateur', referencedColumnName: 'id_utilisateur', nullable: false)]
    private ?Utilisateur $idUtilisateur = null;

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

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): static
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }
}
