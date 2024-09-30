<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe représentant un Utilisateur.
 *
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    /**
     * @var int|null L'identifiant unique de l'utilisateur.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idUtilisateur = null;

    /**
     * @var string|null L'email de l'utilisateur.
     * Doit être unique et respecter un format valide.
     */
    #[ORM\Column(length: 128)]
    private ?string $emailUtilisateur = null;

    /**
     * @var string|null Le mot de passe de l'utilisateur.
     * Doit être stocké de manière sécurisée (hashé).
     */
    #[ORM\Column(length: 255)]
    private ?string $mdpUtilisateur = null;

    /**
     * @var string|null Le rôle de l'utilisateur.
     * Ex: USER, ADMIN.
     * Notes: Le rôle peut être concatené si le user à plusieurs rôles ("USER:ADMIN").
     */
    #[ORM\Column(length: 20)]
    private ?string $roleUtilisateur = null;

    /**
     * @var string|null Le nom d'utilisateur (username).
     * Utilisé pour l'authentification.
     */
    #[ORM\Column(length: 50)]
    private ?string $username = null;

    /**
     * @var string|null Le numéro de téléphone de l'utilisateur.
     * Peut être nul.
     */
    #[ORM\Column(length: 15, nullable: true)]
    private ?string $numTelUtilisateur = null;

    /**
     * @var string|null Le nom de l'utilisateur.
     * Peut être nul.
     */
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nomUtilisateur = null;

    /**
     * @var string|null Le prénom de l'utilisateur.
     * Peut être nul.
     */
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $prenomUtilisateur = null;

    /**
     * Récupère l'identifiant de l'utilisateur.
     *
     * @return int|null
     */
    public function getIdUtilisateur(): ?int
    {
        return $this->idUtilisateur;
    }

    /**
     * Définit l'identifiant de l'utilisateur.
     *
     * @param int $idUtilisateur
     * @return static
     */
    public function setIdUtilisateur(int $idUtilisateur): static
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    /**
     * Récupère l'email de l'utilisateur.
     *
     * @return string|null
     */
    public function getEmailUtilisateur(): ?string
    {
        return $this->emailUtilisateur;
    }

    /**
     * Définit l'email de l'utilisateur.
     *
     * @param string $emailUtilisateur
     * @return static
     */
    public function setEmailUtilisateur(string $emailUtilisateur): static
    {
        $this->emailUtilisateur = $emailUtilisateur;

        return $this;
    }

    /**
     * Récupère le mot de passe de l'utilisateur.
     *
     * @return string|null
     */
    public function getMdpUtilisateur(): ?string
    {
        return $this->mdpUtilisateur;
    }

    /**
     * Définit le mot de passe de l'utilisateur.
     *
     * @param string $mdpUtilisateur
     * @return static
     */
    public function setMdpUtilisateur(string $mdpUtilisateur): static
    {
        $this->mdpUtilisateur = $mdpUtilisateur;

        return $this;
    }

    /**
     * Récupère le numéro de téléphone de l'utilisateur.
     *
     * @return string|null
     */
    public function getNumTelUtilisateur(): ?string
    {
        return $this->numTelUtilisateur;
    }

    /**
     * Définit le numéro de téléphone de l'utilisateur.
     *
     * @param string|null $numTelUtilisateur
     * @return static
     */
    public function setNumTelUtilisateur(?string $numTelUtilisateur): static
    {
        $this->numTelUtilisateur = $numTelUtilisateur;

        return $this;
    }

    /**
     * Récupère le rôle de l'utilisateur.
     *
     * @return string|null
     */
    public function getRoleUtilisateur(): ?string
    {
        return $this->roleUtilisateur;
    }

    /**
     * Définit le rôle de l'utilisateur.
     *
     * @param string $roleUtilisateur
     * @return static
     */
    public function setRoleUtilisateur(string $roleUtilisateur): static
    {
        $this->roleUtilisateur = $roleUtilisateur;

        return $this;
    }

    /**
     * Récupère le nom de l'utilisateur.
     *
     * @return string|null
     */
    public function getNomUtilisateur(): ?string
    {
        return $this->nomUtilisateur;
    }

    /**
     * Définit le nom de l'utilisateur.
     *
     * @param string $nomUtilisateur
     * @return static
     */
    public function setNomUtilisateur(string $nomUtilisateur): static
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    /**
     * Récupère le prénom de l'utilisateur.
     *
     * @return string|null
     */
    public function getPrenomUtilisateur(): ?string
    {
        return $this->prenomUtilisateur;
    }

    /**
     * Définit le prénom de l'utilisateur.
     *
     * @param string $prenomUtilisateur
     * @return static
     */
    public function setPrenomUtilisateur(string $prenomUtilisateur): static
    {
        $this->prenomUtilisateur = $prenomUtilisateur;

        return $this;
    }

    /**
     * Récupère le nom d'utilisateur (username).
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Définit le nom d'utilisateur (username).
     *
     * @param string $username
     * @return static
     */
    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }
}
