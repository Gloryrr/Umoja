<?php

namespace App\Entity;

use App\Repository\ExtrasRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Classe représentant les extras associés à une offre ou une condition.
 *
 * @ORM\Entity(repositoryClass=ExtrasRepository::class)
 */
#[ORM\Entity(repositoryClass: ExtrasRepository::class)]
class Extras
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['extras:read'])]
    private ?int $id = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['extras:read', 'extras:write'])]
    private ?string $descrExtras = null;
    
    #[ORM\Column(nullable: true)]
    #[Groups(['extras:read', 'extras:write'])]
    private ?int $coutExtras = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['extras:read', 'extras:write'])]
    private ?string $exclusivite = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['extras:read', 'extras:write'])]
    private ?string $exception = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['extras:read', 'extras:write'])]
    private ?string $ordrePassage = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['extras:read', 'extras:write'])]
    private ?string $clausesConfidentialites = null;
    
    #[ORM\OneToMany(targetEntity: Offre::class, mappedBy: "extras", orphanRemoval: true, cascade: ["remove"])]
    #[Groups(['extras:read'])]
    private Collection $offres;    

    public function __construct() {
        $this->offres = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant des extras.
     *
     * @return int|null L'identifiant des extras, ou null s'il n'est pas défini.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère la description des extras.
     *
     * @return string|null La description des extras, ou null si aucune n'est définie.
     */
    public function getDescrExtras(): ?string
    {
        return $this->descrExtras;
    }

    /**
     * Définit la description des extras.
     *
     * @param string|null $descrExtras La nouvelle description.
     * @return static Retourne l'instance courante pour le chaînage de méthodes.
     */
    public function setDescrExtras(?string $descrExtras): static
    {
        $this->descrExtras = $descrExtras;

        return $this;
    }

    /**
     * Récupère le coût des extras.
     *
     * @return int|null Le coût des extras, ou null s'il n'est pas défini.
     */
    public function getCoutExtras(): ?int
    {
        return $this->coutExtras;
    }

    /**
     * Définit le coût des extras.
     *
     * @param int|null $coutExtras Le nouveau coût des extras.
     * @return static Retourne l'instance courante pour le chaînage de méthodes.
     */
    public function setCoutExtras(?int $coutExtras): static
    {
        $this->coutExtras = $coutExtras;

        return $this;
    }

    /**
     * Récupère l'exclusivité des extras.
     *
     * @return string|null L'exclusivité des extras, ou null si aucune n'est définie.
     */
    public function getExclusivite(): ?string
    {
        return $this->exclusivite;
    }

    /**
     * Définit l'exclusivité des extras.
     *
     * @param string|null $exclusivite La nouvelle exclusivité.
     * @return static Retourne l'instance courante pour le chaînage de méthodes.
     */
    public function setExclusivite(?string $exclusivite): static
    {
        $this->exclusivite = $exclusivite;

        return $this;
    }

    /**
     * Récupère l'exception des extras.
     *
     * @return string|null L'exception des extras, ou null si aucune n'est définie.
     */
    public function getException(): ?string
    {
        return $this->exception;
    }

    /**
     * Définit l'exception des extras.
     *
     * @param string|null $exception La nouvelle exception.
     * @return static Retourne l'instance courante pour le chaînage de méthodes.
     */
    public function setException(?string $exception): static
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * Récupère l'ordre de passage des extras.
     *
     * @return string|null L'ordre de passage, ou null s'il n'est pas défini.
     */
    public function getOrdrePassage(): ?string
    {
        return $this->ordrePassage;
    }

    /**
     * Définit l'ordre de passage des extras.
     *
     * @param string|null $ordrePassage Le nouvel ordre de passage.
     * @return static Retourne l'instance courante pour le chaînage de méthodes.
     */
    public function setOrdrePassage(?string $ordrePassage): static
    {
        $this->ordrePassage = $ordrePassage;

        return $this;
    }

    /**
     * Récupère les clauses de confidentialité des extras.
     *
     * @return string|null Les clauses de confidentialité, ou null si aucune n'est définie.
     */
    public function getClausesConfidentialites(): ?string
    {
        return $this->clausesConfidentialites;
    }

    /**
     * Définit les clauses de confidentialité des extras.
     *
     * @param string|null $clausesConfidentialites Les nouvelles clauses de confidentialité.
     * @return static Retourne l'instance courante pour le chaînage de méthodes.
     */
    public function setClausesConfidentialites(?string $clausesConfidentialites): static
    {
        $this->clausesConfidentialites = $clausesConfidentialites;

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
            $offre->setExtras($this);
        }
        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            if ($offre->getExtras() === $this) {
                $offre->setExtras(null);
            }
        }
        return $this;
    }
}
