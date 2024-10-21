<?php

namespace App\Entity;

use App\Repository\ConcernerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Concerner
 *
 * @ORM\Entity(repositoryClass=ConcernerRepository::class)
 */
#[ORM\Entity(repositoryClass: ConcernerRepository::class)]
class Concerner
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
    private ?int $idC = null;

    /**
     * @var Artiste|null
     *
     * @ORM\ManyToOne(targetEntity=Artiste::class)
     * @ORM\JoinColumn(nullable=false)
     */
    #[ORM\ManyToOne(targetEntity: Artiste::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Artiste $idArtiste = null;

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
     * Obtient l'identifiant de Concerner
     *
     * @return int|null
     */
    public function getIdC(): ?int
    {
        return $this->idC;
    }

    /**
     * Obtient l'artiste associé
     *
     * @return Artiste|null
     */
    public function getIdArtiste(): ?Artiste
    {
        return $this->idArtiste;
    }

    /**
     * Définit l'artiste associé
     *
     * @param Artiste|null $idArtiste
     * @return self
     */
    public function setIdArtiste(?Artiste $idArtiste): self
    {
        $this->idArtiste = $idArtiste;
        return $this;
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
}
