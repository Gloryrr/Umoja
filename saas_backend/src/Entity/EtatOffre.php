<?php

namespace App\Entity;

use App\Repository\EtatOffreRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * Classe représentant un État d'Offre.
 *
 * @ORM\Entity(repositoryClass=EtatOffreRepository::class)
 */
#[ORM\Entity(repositoryClass: EtatOffreRepository::class)]
class EtatOffre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['etat_offre:read', 'offre:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['etat_offre:read', 'etat_offre:write'])]
    private ?string $nomEtat = null;

    #[ORM\OneToMany(targetEntity: Offre::class, mappedBy: "etatOffre", orphanRemoval: true, cascade: ["remove"])]
    #[Groups(['etat_offre:read'])]
    #[MaxDepth(1)]
    private Collection $offres;


    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant de l'état d'offre.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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

    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres[] = $offre;
            $offre->setEtatOffre($this);
        }
        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            if ($offre->getEtatOffre() === $this) {
                $offre->setEtatOffre(null);
            }
        }
        return $this;
    }
}
