<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Représente un commentaire associé à une offre et un utilisateur.
 *
 * Chaque commentaire est associé à un utilisateur et à une offre, et
 * contient un texte décrivant le commentaire.
 */
#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['commentaire:read'])]
    private ?int $id = null;
    
    #[ORM\Column(length: 500)]
    #[Groups(['commentaire:read', 'commentaire:write'])]
    private ?string $commentaire = null;
    
    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "offresCommentees")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['commentaire:read'])]
    private ?Utilisateur $utilisateur = null;
    
    #[ORM\ManyToOne(targetEntity: Offre::class, inversedBy: "commenteesPar")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['commentaire:read'])]
    private ?Offre $offre = null;    

    /**
     * Récupère l'identifiant du commentaire.
     *
     * @return int|null L'identifiant du commentaire ou null si non défini.
     */
    public function getId(): ?int
    {
        return $this->id;
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
    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    /**
     * Définit l'utilisateur associé à ce commentaire.
     *
     * @param Utilisateur|null $idUtilisateur L'utilisateur qui a posté le commentaire.
     * @return self Retourne l'instance de la classe Commentaire pour un chaînage fluide.
     */
    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Récupère l'offre sur laquelle ce commentaire est posté.
     *
     * @return Offre|null L'offre associée à ce commentaire.
     */
    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    /**
     * Définit l'offre associée à ce commentaire.
     *
     * @param Offre|null $idOffre L'offre sur laquelle le commentaire est posté.
     * @return self Retourne l'instance de la classe Commentaire pour un chaînage fluide.
     */
    public function setOffre(?Offre $offre): static
    {
        $this->offre = $offre;

        return $this;
    }
}
