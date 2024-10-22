<?php

namespace App\Entity;

use App\Repository\CreerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Représente la relation de création entre un utilisateur et une offre.
 *
 * Cette classe modélise la relation entre un utilisateur qui crée une offre.
 * Elle contient des informations sur l'utilisateur créateur, l'offre créée,
 * ainsi qu'un champ de contact.
 */
#[ORM\Entity(repositoryClass: CreerRepository::class)]
class Creer
{
    /**
     * Identifiant unique de la relation de création.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Utilisateur ayant créé l'offre.
     *
     * @var Utilisateur|null
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $idUtilisateur = null;

    /**
     * Offre créée par l'utilisateur.
     *
     * @var Offre|null
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $idOffre = null;

    /**
     * Information de contact de l'utilisateur.
     *
     * @var string|null
     */
    #[ORM\Column(length: 50)]
    private ?string $contact = null;

    /**
     * Récupère l'identifiant de la relation de création.
     *
     * @return int|null L'identifiant de la relation ou null s'il n'est pas défini.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère l'utilisateur ayant créé l'offre.
     *
     * @return Utilisateur|null L'utilisateur créateur ou null s'il n'est pas défini.
     */
    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    /**
     * Définit l'utilisateur ayant créé l'offre.
     *
     * @param Utilisateur|null $idUtilisateur L'utilisateur créateur de l'offre.
     * @return self Retourne l'instance de la classe pour un chaînage fluide.
     */
    public function setIdUtilisateur(?Utilisateur $idUtilisateur): static
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    /**
     * Récupère l'offre créée par l'utilisateur.
     *
     * @return Offre|null L'offre créée ou null si elle n'est pas définie.
     */
    public function getIdOffre(): ?Offre
    {
        return $this->idOffre;
    }

    /**
     * Définit l'offre créée par l'utilisateur.
     *
     * @param Offre|null $idOffre L'offre à associer à l'utilisateur.
     * @return self Retourne l'instance de la classe pour un chaînage fluide.
     */
    public function setIdOffre(?Offre $idOffre): static
    {
        $this->idOffre = $idOffre;

        return $this;
    }

    /**
     * Récupère le contact de l'utilisateur.
     *
     * @return string|null Le contact de l'utilisateur ou null s'il n'est pas défini.
     */
    public function getContact(): ?string
    {
        return $this->contact;
    }

    /**
     * Définit le contact de l'utilisateur.
     *
     * @param string $contact Le contact de l'utilisateur.
     * @return self Retourne l'instance de la classe pour un chaînage fluide.
     */
    public function setContact(string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }
}
