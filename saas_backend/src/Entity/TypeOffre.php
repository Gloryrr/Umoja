<?php

namespace App\Entity;

use App\Repository\TypeOffreRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: TypeOffreRepository::class)]
class TypeOffre
{
/**
     * Identifiant unique du type d'offre.
     *
     * @var int
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['type_offre:read'])]
    private int $id = 0;

    /**
     * Nom du type d'offre.
     * Doit avoir une longueur maximale de 255 caractères.
     *
     * @var string
     */
    #[ORM\Column(length: 255)]
    #[Groups(['type_offre:read', 'type_offre:write', 'offre:read'])]
    private string $nomTypeOffre;

    /**
     * Les offres associées à ce type d'offre.
     *
     * @var Collection<int, Offre>
     */
    #[ORM\OneToMany(targetEntity: Offre::class, mappedBy: "typeOffre", orphanRemoval: true, cascade: ["remove"])]
    #[Groups(['type_offre:read'])]
    #[MaxDepth(1)]
    private Collection $offres;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNomTypeOffre(): string
    {
        return $this->nomTypeOffre;
    }

    public function setNomTypeOffre(string $nomTypeOffre): static
    {
        $this->nomTypeOffre = $nomTypeOffre;

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
            $offre->setTypeOffre($this);
        }
        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            if ($offre->getTypeOffre() === $this) {
                $offre->setTypeOffre(null);
            }
        }
        return $this;
    }
}
