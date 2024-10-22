<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Représente un commentaire associé à une offre et un utilisateur.
 *
 * Chaque commentaire est associé à un utilisateur et à une offre, et
 * contient un texte décrivant le commentaire.
 */
#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    /**
     * Identifiant unique du commentaire.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idCommentaire = null;

    /**
     * Contenu du commentaire, limité à 500 caractères.
     *
     * @var string|null
     */
    #[ORM\Column(length: 500)]
    private ?string $commentaire = null;

    /**
     * Utilisateur ayant écrit le commentaire.
     *
     * @var Utilisateur|null
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $idUtilisateur = null;

    /**
     * Offre sur laquelle le commentaire est posté.
     *
     * @var Offre|null
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $idOffre = null;

    /**
     * Récupère l'identifiant du commentaire.
     *
     * @return int|null L'identifiant du commentaire ou null si non défini.
     */
    public function getIdCommentaire(): ?int
    {
        return $this->idCommentaire;
    }

    /**
     * Récupère le contenu du commentaire.
     *
     * @return string|null Le texte du commentaire ou null s'il n'est pas défini.
     */
    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    /**
     * Définit le contenu du commentaire.
     *
     * @param string $commentaire Le texte du commentaire.
     * @return self Retourne l'instance de la classe Commentaire pour un chaînage fluide.
     */
    public function setCommentaire(string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Récupère l'utilisateur associé à ce commentaire.
     *
     * @return Utilisateur|null L'utilisateur ayant posté le commentaire.
     */
    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    /**
     * Définit l'utilisateur associé à ce commentaire.
     *
     * @param Utilisateur|null $idUtilisateur L'utilisateur qui a posté le commentaire.
     * @return self Retourne l'instance de la classe Commentaire pour un chaînage fluide.
     */
    public function setIdUtilisateur(?Utilisateur $idUtilisateur): static
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    /**
     * Récupère l'offre sur laquelle ce commentaire est posté.
     *
     * @return Offre|null L'offre associée à ce commentaire.
     */
    public function getIdOffre(): ?Offre
    {
        return $this->idOffre;
    }

    /**
     * Définit l'offre associée à ce commentaire.
     *
     * @param Offre|null $idOffre L'offre sur laquelle le commentaire est posté.
     * @return self Retourne l'instance de la classe Commentaire pour un chaînage fluide.
     */
    public function setIdOffre(?Offre $idOffre): static
    {
        $this->idOffre = $idOffre;

        return $this;
    }
}
