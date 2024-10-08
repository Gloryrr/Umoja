<?php

namespace App\Entity;

use App\Repository\EtatOffreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe représentant un État d'Offre.
 *
 * @ORM\Entity(repositoryClass=EtatOffreRepository::class)
 */
#[ORM\Entity(repositoryClass: EtatOffreRepository::class)]
class EtatOffre
{
    /**
     * @var int|null L'identifiant unique de l'état d'offre.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idEtatOffre = null;

    /**
     * @var string|null Le nom de l'état de l'offre.
     * Doit avoir une longueur maximale de 50 caractères.
     */
    #[ORM\Column(length: 50)]
    private ?string $nomEtat = null;

    /**
     * Récupère l'identifiant de l'état d'offre.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->idEtatOffre;
    }

    /**
     * Récupère le nom de l'état de l'offre.
     *
     * @return string|null
     */
    public function getNomEtat(): ?string
    {
        return $this->nomEtat;
    }

    /**
     * Définit le nom de l'état de l'offre.
     *
     * @param string $nomEtat Le nom à assigner à l'état de l'offre.
     * @return static
     */
    public function setNomEtat(string $nomEtat): static
    {
        $this->nomEtat = $nomEtat;

        return $this;
    }
}
