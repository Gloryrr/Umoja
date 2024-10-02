<?php

namespace App\Entity;

use App\Repository\FicheTechniqueArtisteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FicheTechniqueArtisteRepository::class)]
class FicheTechniqueArtiste
{
    /**
     * Identifiant unique de la fiche technique de l'offre.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Besoins en sonorisation de l'offre.
     *
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $besoinSonorisation = null;

    /**
     * Besoins en éclairage de l'offre.
     *
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $besoinEclairage = null;

    /**
     * Besoins en scène de l'offre.
     *
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $besoinScene = null;

    /**
     * Besoins en backline de l'offre.
     *
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $besoinBackline = null;

    /**
     * Besoins en équipements de l'offre.
     *
     * @var string|null
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $besoinEquipements = null;

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
}
