<?php

namespace App\Entity;

use App\Repository\ReseauRepository;
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
    private ?int $id = null;

    /**
     * @var string|null Le nom du réseau.
     * Doit avoir une longueur maximale de 100 caractères.
     */
    #[ORM\Column(length: 100)]
    private ?string $nomReseau = null;

    /**
     * Récupère l'identifiant du réseau.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
}
