<?php

namespace App\Entity;

use App\Repository\ExtrasRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * Classe représentant les extras associés à une offre ou une condition.
 *
 * @ORM\Entity(repositoryClass=ExtrasRepository::class)
 */
#[ORM\Entity(repositoryClass: ExtrasRepository::class)]
class Extras
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\Column]
    #[Groups(['extras:read', 'offre:read'])]
    private int $id;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['extras:read', 'extras:write'])]
    private string $descrExtras;

    #[ORM\Column(nullable: false)]
    #[Groups(['extras:read', 'extras:write'])]
    private int $coutExtras;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['extras:read', 'extras:write'])]
    private string $exclusivite;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['extras:read', 'extras:write'])]
    private string $exception;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['extras:read', 'extras:write'])]
    private string $ordrePassage;

    #[ORM\Column(length: 255, nullable: false)]
    #[Groups(['extras:read', 'extras:write'])]
    private string $clausesConfidentialites;

    #[ORM\OneToMany(targetEntity: Offre::class, mappedBy: "extras", orphanRemoval: true, cascade: ["remove"])]
    #[Groups(['extras:read'])]
    #[MaxDepth(1)]
    private Collection $offres;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant des extras.
     *
     * @return int L'identifiant des extras.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Définit l'identifiant des extras.
     *
     * @param int $id Le nouvel identifiant.
     * @return static Retourne l'instance courante pour le chaînage de méthodes.
     */
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Récupère la description des extras.
     *
     * @return string La description des extras.
     */
    public function getDescrExtras(): string
    {
        return $this->descrExtras;
    }

    /**
     * Définit la description des extras.
     *
     * @param string $descrExtras La nouvelle description.
     * @return static Retourne l'instance courante pour le chaînage de méthodes.
     */
    public function setDescrExtras(string $descrExtras): static
    {
        $this->descrExtras = $descrExtras;

        return $this;
    }

    /**
     * Récupère le coût des extras.
     *
     * @return int Le coût des extras.
     */
    public function getCoutExtras(): int
    {
        return $this->coutExtras;
    }

    /**
     * Définit le coût des extras.
     *
     * @param int $coutExtras Le nouveau coût des extras.
     * @return static Retourne l'instance courante pour le chaînage de méthodes.
     */
    public function setCoutExtras(int $coutExtras): static
    {
        $this->coutExtras = $coutExtras;

        return $this;
    }

    /**
     * Récupère l'exclusivité des extras.
     *
     * @return string L'exclusivité des extras.
     */
    public function getExclusivite(): string
    {
        return $this->exclusivite;
    }

    /**
     * Définit l'exclusivité des extras.
     *
     * @param string $exclusivite La nouvelle exclusivité.
     * @return static Retourne l'instance courante pour le chaînage de méthodes.
     */
    public function setExclusivite(string $exclusivite): static
    {
        $this->exclusivite = $exclusivite;

        return $this;
    }

    /**
     * Récupère l'exception des extras.
     *
     * @return string L'exception des extras.
     */
    public function getException(): string
    {
        return $this->exception;
    }

    /**
     * Définit l'exception des extras.
     *
     * @param string $exception La nouvelle exception.
     * @return static Retourne l'instance courante pour le chaînage de méthodes.
     */
    public function setException(string $exception): static
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * Récupère l'ordre de passage des extras.
     *
     * @return string L'ordre de passage.
     */
    public function getOrdrePassage(): string
    {
        return $this->ordrePassage;
    }

    /**
     * Définit l'ordre de passage des extras.
     *
     * @param string $ordrePassage Le nouvel ordre de passage.
     * @return static Retourne l'instance courante pour le chaînage de méthodes.
     */
    public function setOrdrePassage(string $ordrePassage): static
    {
        $this->ordrePassage = $ordrePassage;

        return $this;
    }

    /**
     * Récupère les clauses de confidentialité des extras.
     *
     * @return string Les clauses de confidentialité.
     */
    public function getClausesConfidentialites(): string
    {
        return $this->clausesConfidentialites;
    }

    /**
     * Définit les clauses de confidentialité des extras.
     *
     * @param string $clausesConfidentialites Les nouvelles clauses de confidentialité.
     * @return static Retourne l'instance courante pour le chaînage de méthodes.
     */
    public function setClausesConfidentialites(string $clausesConfidentialites): static
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
