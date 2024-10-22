<?php

namespace App\Entity;

use App\Repository\PosterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Poster.
 *
 * Représente une entité associant une offre à un réseau via un poster.
 * Un poster relie une instance d'offre à une instance de réseau.
 *
 * @ORM\Entity(repositoryClass=PosterRepository::class)
 */
#[ORM\Entity(repositoryClass: PosterRepository::class)]
class Poster
{
    /**
     * Identifiant unique de l'entité Poster.
     *
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Réseau associé au poster.
     *
     * @var Reseau|null
     *
     * @ORM\ManyToOne
     * @ORM\JoinColumn(nullable=false)
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reseau $idReseau = null;

    /**
     * Offre associée au poster.
     *
     * @var Offre|null
     *
     * @ORM\ManyToOne
     * @ORM\JoinColumn(nullable=false)
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $idOffre = null;

    /**
     * Récupère l'identifiant du poster.
     *
     * @return int|null L'identifiant unique du poster, ou null s'il n'est pas encore défini.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère le réseau associé au poster.
     *
     * @return Reseau|null Le réseau lié à cette instance de poster.
     */
    public function getIdReseau(): ?Reseau
    {
        return $this->idReseau;
    }

    /**
     * Définit le réseau associé au poster.
     *
     * @param Reseau|null $idReseau Le réseau à lier à cette instance de poster.
     * @return static Retourne l'instance courante pour permettre l'enchaînement des appels.
     */
    public function setIdReseau(?Reseau $idReseau): static
    {
        $this->idReseau = $idReseau;

        return $this;
    }

    /**
     * Récupère l'offre associée au poster.
     *
     * @return Offre|null L'offre liée à cette instance de poster.
     */
    public function getIdOffre(): ?Offre
    {
        return $this->idOffre;
    }

    /**
     * Définit l'offre associée au poster.
     *
     * @param Offre|null $idOffre L'offre à lier à cette instance de poster.
     * @return static Retourne l'instance courante pour permettre l'enchaînement des appels.
     */
    public function setIdOffre(?Offre $idOffre): static
    {
        $this->idOffre = $idOffre;

        return $this;
    }
}
