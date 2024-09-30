<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idUtilisateur = null;

    #[ORM\Column(length: 128)]
    private ?string $emailUtilisateur = null;

    #[ORM\Column(length: 255)]
    private ?string $mdpUtilisateur = null;

    #[ORM\Column(length: 20)]
    private ?string $roleUtilisateur = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $numTelUtilisateur = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nomUtilisateur = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $prenomUtilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(int $idUtilisateur): static
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    public function getEmailUtilisateur(): ?string
    {
        return $this->emailUtilisateur;
    }

    public function setEmailUtilisateur(string $emailUtilisateur): static
    {
        $this->emailUtilisateur = $emailUtilisateur;

        return $this;
    }

    public function getMdpUtilisateur(): ?string
    {
        return $this->mdpUtilisateur;
    }

    public function setMdpUtilisateur(string $mdpUtilisateur): static
    {
        $this->mdpUtilisateur = $mdpUtilisateur;

        return $this;
    }

    public function getNumTelUtilisateur(): ?string
    {
        return $this->numTelUtilisateur;
    }

    public function setNumTelUtilisateur(?string $numTelUtilisateur): static
    {
        $this->numTelUtilisateur = $numTelUtilisateur;

        return $this;
    }

    public function getRoleUtilisateur(): ?string
    {
        return $this->roleUtilisateur;
    }

    public function setRoleUtilisateur(string $roleUtilisateur): static
    {
        $this->roleUtilisateur = $roleUtilisateur;

        return $this;
    }

    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): static
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    public function getPrenomUtilisateur(): ?string
    {
        return $this->prenomUtilisateur;
    }

    public function setPrenomUtilisateur(string $prenomUtilisateur): static
    {
        $this->prenomUtilisateur = $prenomUtilisateur;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }
}
