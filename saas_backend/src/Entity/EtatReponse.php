<?php

namespace App\Entity;

use App\Repository\EtatReponseRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * Classe EtatReponse
 *
 * @ORM\Entity(repositoryClass=EtatReponseRepository::class)
 */
#[ORM\Entity(repositoryClass: EtatReponseRepository::class)]
class EtatReponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[Groups(['etat_reponse:read'])]
    private int $id = 0;

    #[ORM\Column(type: "string", length: 100)]
    #[Groups(['etat_reponse:read', 'etat_reponse:write', 'reponse:read'])]
    private string $nomEtatReponse;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['etat_reponse:read', 'etat_reponse:write'])]
    private ?string $descriptionEtatReponse = null;

    #[ORM\OneToMany(targetEntity: Reponse::class, mappedBy: "etatReponse", orphanRemoval: true, cascade: ["remove"])]
    #[Groups(['etat_reponse:read'])]
    #[MaxDepth(1)]
    private Collection $reponses;

    public function __construct()
    {
        $this->reponses = new ArrayCollection();
    }

    /**
     * Obtient l'identifiant de l'état de réponse
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Obtient le nom de l'état de réponse
     *
     * @return string
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
     * @return string
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

    public function getReponses(): Collection
    {
        return $this->reponses;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setEtatReponse($this);
        }
        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            if ($reponse->getEtatReponse() === $this) {
                $reponse->setEtatReponse(null);
            }
        }
        return $this;
    }
}
