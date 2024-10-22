<?php

namespace App\Entity;

use App\Repository\EtatReponseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classe EtatReponse
 *
 * @ORM\Entity(repositoryClass=EtatReponseRepository::class)
 */
#[ORM\Entity(repositoryClass: EtatReponseRepository::class)]
class EtatReponse
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
    private ?int $id = null;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=100)
     */
    #[ORM\Column(type: "string", length: 100)]
    private ?string $nomEtatReponse = null;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255)
     */
    #[ORM\Column(type: "string", length: 255)]
    private ?string $descriptionEtatReponse = null;

    /**
     * Obtient l'identifiant de l'état de réponse
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Obtient le nom de l'état de réponse
     *
     * @return string|null
     */
    public function getNomEtatReponse(): ?string
    {
        return $this->nomEtatReponse;
    }

    /**
     * Définit le nom de l'état de réponse
     *
     * @param string $nomEtatReponse
     * @return self
     */
    public function setNomEtatReponse(string $nomEtatReponse): self
    {
        $this->nomEtatReponse = $nomEtatReponse;
        return $this;
    }

    /**
     * Obtient la description de l'état de réponse
     *
     * @return string|null
     */
    public function getDescriptionEtatReponse(): ?string
    {
        return $this->descriptionEtatReponse;
    }

    /**
     * Définit la description de l'état de réponse
     *
     * @param string $descriptionEtatReponse
     * @return self
     */
    public function setDescriptionEtatReponse(string $descriptionEtatReponse): self
    {
        $this->descriptionEtatReponse = $descriptionEtatReponse;
        return $this;
    }
}
