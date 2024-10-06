<?php

namespace App\Entity;

use App\Repository\ReseauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe représentant un Réseau.
 *
 * @ORM\Entity(repositoryClass=ReseauRepository::class)
 */
#[ORM\Entity(repositoryClass: ReseauRepository::class)]
class Reseau
{
    /**
     * @var int|null L'identifiant unique du réseau.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idReseau = null;

    /**
     * @var string|null Le nom du réseau.
     * Doit avoir une longueur maximale de 100 caractères.
     */
    #[ORM\Column(length: 100)]
    private ?string $nomReseau = null;

    /**
     * @var Collection<int, Appartenir>
     */
    #[ORM\OneToMany(targetEntity: Appartenir::class, mappedBy: 'idReseau', orphanRemoval: true)]
    private Collection $estMembreDe;

    /**
     * @var Collection<int, Lier>
     */
    #[ORM\OneToMany(targetEntity: Lier::class, mappedBy: 'idReseau', orphanRemoval: true)]
    private Collection $estLierAuxGenres;

    public function __construct()
    {
        $this->genresLies = new ArrayCollection();
        $this->estMembreDe = new ArrayCollection();
        $this->estLierAuxGenres = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant du réseau.
     *
     * @return int|null
     */
    public function getIdReseau(): ?int
    {
        return $this->idReseau;
    }

    /**
     * Récupère le nom du réseau.
     *
     * @return string|null
     */
    public function getNomReseau(): ?string
    {
        return $this->nomReseau;
    }

    /**
     * Définit le nom du réseau.
     *
     * @param string $nomReseau Le nom à assigner au réseau.
     * @return static
     */
    public function setNomReseau(string $nomReseau): static
    {
        $this->nomReseau = $nomReseau;

        return $this;
    }

    public function addEstMembreDe(Appartenir $estMembreDe): static
    {
        if (!$this->estMembreDe->contains($estMembreDe)) {
            $this->estMembreDe->add($estMembreDe);
            $estMembreDe->setIdReseau($this);
        }

        return $this;
    }

    public function removeEstMembreDe(Appartenir $estMembreDe): static
    {
        if ($this->estMembreDe->removeElement($estMembreDe)) {
            // set the owning side to null (unless already changed)
            if ($estMembreDe->getIdReseau() === $this) {
                $estMembreDe->setIdReseau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Lier>
     */
    public function getEstLierAuxGenres(): Collection
    {
        return $this->estLierAuxGenres;
    }

    public function addEstLierAuxGenre(Lier $estLierAuxGenre): static
    {
        if (!$this->estLierAuxGenres->contains($estLierAuxGenre)) {
            $this->estLierAuxGenres->add($estLierAuxGenre);
            $estLierAuxGenre->setIdReseau($this);
        }

        return $this;
    }

    public function removeEstLierAuxGenre(Lier $estLierAuxGenre): static
    {
        if ($this->estLierAuxGenres->removeElement($estLierAuxGenre)) {
            // set the owning side to null (unless already changed)
            if ($estLierAuxGenre->getIdReseau() === $this) {
                $estLierAuxGenre->setIdReseau(null);
            }
        }

        return $this;
    }
}
