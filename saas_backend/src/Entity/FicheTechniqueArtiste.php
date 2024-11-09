<?php

namespace App\Entity;

use App\Repository\FicheTechniqueArtisteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FicheTechniqueArtisteRepository::class)]
class FicheTechniqueArtiste
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['ficheTechniqueArtiste:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['ficheTechniqueArtiste:read', 'ficheTechniqueArtiste:write'])]
    private ?string $besoinSonorisation = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['ficheTechniqueArtiste:read', 'ficheTechniqueArtiste:write'])]
    private ?string $besoinEclairage = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['ficheTechniqueArtiste:read', 'ficheTechniqueArtiste:write'])]
    private ?string $besoinScene = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['ficheTechniqueArtiste:read', 'ficheTechniqueArtiste:write'])]
    private ?string $besoinBackline = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['ficheTechniqueArtiste:read', 'ficheTechniqueArtiste:write'])]
    private ?string $besoinEquipements = null;

    #[ORM\OneToMany(
        targetEntity: Offre::class,
        mappedBy: "ficheTechniqueArtiste",
        orphanRemoval: true,
        cascade: ["remove"]
    )]
    #[Groups(['ficheTechniqueArtiste:read'])]
    private Collection $offres;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant de la fiche technique.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère les besoins en sonorisation de l'offre.
     *
     * @return string|null
     */
    public function getBesoinSonorisation(): ?string
    {
        return $this->besoinSonorisation;
    }

    /**
     * Définit les besoins en sonorisation de l'offre.
     *
     * @param string|null $besoinSonorisation
     * @return static
     */
    public function setBesoinSonorisation(?string $besoinSonorisation): static
    {
        $this->besoinSonorisation = $besoinSonorisation;

        return $this;
    }

    /**
     * Récupère les besoins en éclairage de l'offre.
     *
     * @return string|null
     */
    public function getBesoinEclairage(): ?string
    {
        return $this->besoinEclairage;
    }

    /**
     * Définit les besoins en éclairage de l'offre.
     *
     * @param string|null $besoinEclairage
     * @return static
     */
    public function setBesoinEclairage(?string $besoinEclairage): static
    {
        $this->besoinEclairage = $besoinEclairage;

        return $this;
    }

    /**
     * Récupère les besoins en scène de l'offre.
     *
     * @return string|null
     */
    public function getBesoinScene(): ?string
    {
        return $this->besoinScene;
    }

    /**
     * Définit les besoins en scène de l'offre.
     *
     * @param string|null $besoinScene
     * @return static
     */
    public function setBesoinScene(?string $besoinScene): static
    {
        $this->besoinScene = $besoinScene;

        return $this;
    }

    /**
     * Récupère les besoins en backline de l'offre.
     *
     * @return string|null
     */
    public function getBesoinBackline(): ?string
    {
        return $this->besoinBackline;
    }

    /**
     * Définit les besoins en backline de l'offre.
     *
     * @param string|null $besoinBackline
     * @return static
     */
    public function setBesoinBackline(?string $besoinBackline): static
    {
        $this->besoinBackline = $besoinBackline;

        return $this;
    }

    /**
     * Récupère les besoins en équipements de l'offre.
     *
     * @return string|null
     */
    public function getBesoinEquipements(): ?string
    {
        return $this->besoinEquipements;
    }

    /**
     * Définit les besoins en équipements de l'offre.
     *
     * @param string|null $besoinEquipements
     * @return static
     */
    public function setBesoinEquipements(?string $besoinEquipements): static
    {
        $this->besoinEquipements = $besoinEquipements;

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
            $offre->setFicheTechniqueArtiste($this);
        }
        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            if ($offre->getFicheTechniqueArtiste() === $this) {
                $offre->setFicheTechniqueArtiste(null);
            }
        }
        return $this;
    }
}
