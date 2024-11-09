<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Représente une offre dans le système.
 *
 * Cette entité encapsule les informations sur une offre, incluant son titre,
 * sa description, les dates proposées, la ville et région visées, et le nombre
 * d'artistes et d'invités concernés, ainsi que les liens promotionnels associés.
 */
#[ORM\Entity(repositoryClass: OffreRepository::class)]
class Offre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['offre:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?string $titleOffre = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?\DateTimeInterface $deadLine = null;

    #[ORM\Column(length: 500)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?string $descrTournee = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?\DateTimeInterface $dateMinProposee = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?\DateTimeInterface $dateMaxProposee = null;

    #[ORM\Column(length: 50)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?string $villeVisee = null;

    #[ORM\Column(length: 50)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?string $regionVisee = null;

    #[ORM\Column]
    #[Groups(['offre:read', 'offre:write'])]
    private ?int $placesMin = null;

    #[ORM\Column]
    #[Groups(['offre:read', 'offre:write'])]
    private ?int $placesMax = null;

    #[ORM\Column]
    #[Groups(['offre:read', 'offre:write'])]
    private ?int $nbArtistesConcernes = null;

    #[ORM\Column]
    #[Groups(['offre:read', 'offre:write'])]
    private ?int $nbInvitesConcernes = null;

    #[ORM\Column(length: 255)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?string $liensPromotionnels = null;

    #[ORM\ManyToOne(targetEntity: Extras::class, inversedBy: "offres")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?Extras $extras = null;

    #[ORM\ManyToOne(targetEntity: EtatOffre::class, inversedBy: "offres")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?EtatOffre $etatOffre = null;

    #[ORM\ManyToOne(targetEntity: TypeOffre::class, inversedBy: "offres")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?TypeOffre $typeOffre = null;

    #[ORM\ManyToOne(targetEntity: ConditionsFinancieres::class, inversedBy: "offres")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?ConditionsFinancieres $conditionsFinancieres = null;

    #[ORM\ManyToOne(targetEntity: BudgetEstimatif::class, inversedBy: "offres")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?BudgetEstimatif $budgetEstimatif = null;

    #[ORM\ManyToOne(targetEntity: FicheTechniqueArtiste::class, inversedBy: "offres")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?FicheTechniqueArtiste $ficheTechniqueArtiste = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "offres")]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToMany(targetEntity: Artiste::class, mappedBy: "offres")]
    #[Groups(['offre:read', 'offre:write'])]
    private Collection $artistes;

    #[ORM\ManyToMany(targetEntity: Reseau::class, mappedBy: "offres")]
    #[Groups(['offre:read', 'offre:write'])]
    private Collection $reseaux;

    #[ORM\ManyToMany(targetEntity: GenreMusical::class, mappedBy: "offres")]
    #[Groups(['offre:read', 'offre:write'])]
    private Collection $genresMusicaux;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: "offre", orphanRemoval: true, cascade: ["remove"])]
    #[Groups(['offre:read'])]
    private Collection $commenteesPar;

    #[ORM\OneToMany(targetEntity: Reponse::class, mappedBy: "offre", orphanRemoval: true, cascade: ["remove"])]
    #[Groups(['offre:read', 'offre:write'])]
    private Collection $reponses;

    public function __construct() {
        $this->artistes = new ArrayCollection();
        $this->reseaux = new ArrayCollection();
        $this->genresMusicaux = new ArrayCollection();
        $this->commenteesPar = new ArrayCollection();
        $this->reponses = new ArrayCollection();
    }

    /**
     * Obtient l'id de l'offre
     * 
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Obtient le titre de l'offre.
     *
     * @return string|null
     */
    public function getTitleOffre(): ?string
    {
        return $this->titleOffre;
    }

    /**
     * Définit le titre de l'offre.
     *
     * @param string $titleOffre
     * @return self
     */
    public function setTitleOffre(string $titleOffre): static
    {
        $this->titleOffre = $titleOffre;

        return $this;
    }

    /**
     * Obtient la date limite pour répondre à l'offre.
     *
     * @return \DateTimeInterface|null
     */
    public function getDeadLine(): ?\DateTimeInterface
    {
        return $this->deadLine;
    }

    /**
     * Définit la date limite pour répondre à l'offre.
     *
     * @param \DateTimeInterface $deadLine
     * @return self
     */
    public function setDeadLine(\DateTimeInterface $deadLine): static
    {
        $this->deadLine = $deadLine;

        return $this;
    }

    /**
     * Obtient la description de la tournée.
     *
     * @return string|null
     */
    public function getDescrTournee(): ?string
    {
        return $this->descrTournee;
    }

    /**
     * Définit la description de la tournée.
     *
     * @param string $descrTournee
     * @return self
     */
    public function setDescrTournee(string $descrTournee): static
    {
        $this->descrTournee = $descrTournee;
        return $this;
    }

    /**
     * Obtient la date minimale proposée pour la tournée.
     *
     * @return \DateTimeInterface|null
     */
    public function getDateMinProposee(): ?\DateTimeInterface
    {
        return $this->dateMinProposee;
    }

    /**
     * Définit la date minimale proposée pour la tournée.
     *
     * @param \DateTimeInterface $dateMinProposee
     * @return self
     */
    public function setDateMinProposee(\DateTimeInterface $dateMinProposee): static
    {
        $this->dateMinProposee = $dateMinProposee;
        return $this;
    }

    /**
     * Obtient la date maximale proposée pour la tournée.
     *
     * @return \DateTimeInterface|null
     */
    public function getDateMaxProposee(): ?\DateTimeInterface
    {
        return $this->dateMaxProposee;
    }

    /**
     * Définit la date maximale proposée pour la tournée.
     *
     * @param \DateTimeInterface $dateMaxProposee
     * @return self
     */
    public function setDateMaxProposee(\DateTimeInterface $dateMaxProposee): static
    {
        $this->dateMaxProposee = $dateMaxProposee;
        return $this;
    }

    /**
     * Obtient la ville visée par la tournée.
     *
     * @return string|null
     */
    public function getVilleVisee(): ?string
    {
        return $this->villeVisee;
    }

    /**
     * Définit la ville visée par la tournée.
     *
     * @param string $villeVisee
     * @return self
     */
    public function setVilleVisee(string $villeVisee): static
    {
        $this->villeVisee = $villeVisee;
        return $this;
    }

    /**
     * Obtient la région visée par la tournée.
     *
     * @return string|null
     */
    public function getRegionVisee(): ?string
    {
        return $this->regionVisee;
    }

    /**
     * Définit la région visée par la tournée.
     *
     * @param string $regionVisee
     * @return self
     */
    public function setRegionVisee(string $regionVisee): static
    {
        $this->regionVisee = $regionVisee;
        return $this;
    }

    /**
     * Obtient le nombre minimum de places disponibles.
     *
     * @return int|null
     */
    public function getPlacesMin(): ?int
    {
        return $this->placesMin;
    }

    /**
     * Définit le nombre minimum de places disponibles.
     *
     * @param int $placesMin
     * @return self
     */
    public function setPlacesMin(int $placesMin): static
    {
        $this->placesMin = $placesMin;

        return $this;
    }

    /**
     * Obtient le nombre maximum de places disponibles.
     *
     * @return int|null
     */
    public function getPlacesMax(): ?int
    {
        return $this->placesMax;
    }

    /**
     * Définit le nombre maximum de places disponibles.
     *
     * @param int $placesMax
     * @return self
     */
    public function setPlacesMax(int $placesMax): static
    {
        $this->placesMax = $placesMax;

        return $this;
    }

    /**
     * Obtient le nombre d'artistes concernés par l'offre.
     *
     * @return int|null
     */
    public function getNbArtistesConcernes(): ?int
    {
        return $this->nbArtistesConcernes;
    }

    /**
     * Définit le nombre d'artistes concernés par l'offre.
     *
     * @param int $nbArtistesConcernes
     * @return self
     */
    public function setNbArtistesConcernes(int $nbArtistesConcernes): static
    {
        $this->nbArtistesConcernes = $nbArtistesConcernes;

        return $this;
    }

    /**
     * Obtient le nombre d'invités concernés par l'offre.
     *
     * @return int|null
     */
    public function getNbInvitesConcernes(): ?int
    {
        return $this->nbInvitesConcernes;
    }

    /**
     * Définit le nombre d'invités concernés par l'offre.
     *
     * @param int $nbInvitesConcernes
     * @return self
     */
    public function setNbInvitesConcernes(int $nbInvitesConcernes): static
    {
        $this->nbInvitesConcernes = $nbInvitesConcernes;

        return $this;
    }

    /**
     * Obtient les liens promotionnels associés à l'offre.
     *
     * @return string|null
     */
    public function getLiensPromotionnels(): ?string
    {
        return $this->liensPromotionnels;
    }

    /**
     * Définit les liens promotionnels associés à l'offre.
     *
     * @param string $liensPromotionnels
     * @return self
     */
    public function setLiensPromotionnels(string $liensPromotionnels): static
    {
        $this->liensPromotionnels = $liensPromotionnels;

        return $this;
    }

    /**
     * Récupère l'entité Extras associée à cette offre.
     *
     * @return Extras|null L'entité Extras associée ou null si aucune n'est définie.
     */
    public function getExtras(): ?Extras
    {
        return $this->extras;
    }

    /**
     * Définit l'entité Extras associée à cette offre.
     *
     * @param Extras|null $extras L'entité Extras à associer à l'offre.
     * @return static Retourne l'instance actuelle pour chaînage des méthodes.
     */
    public function setExtras(?Extras $extras): static
    {
        $this->extras = $extras;

        return $this;
    }

    /**
     * Récupère l'entité EtatOffre associée à cette offre.
     *
     * @return EtatOffre|null L'état de l'offre ou null si aucun n'est défini.
     */
    public function getEtatOffre(): ?EtatOffre
    {
        return $this->etatOffre;
    }

    /**
     * Définit l'entité EtatOffre associée à cette offre.
     *
     * @param EtatOffre|null $etatOffre L'entité EtatOffre à associer à l'offre.
     * @return static Retourne l'instance actuelle pour chaînage des méthodes.
     */
    public function setEtatOffre(?EtatOffre $etatOffre): static
    {
        $this->etatOffre = $etatOffre;

        return $this;
    }

    /**
     * Récupère l'entité TypeOffre associée à cette offre.
     *
     * @return TypeOffre|null Le type de l'offre ou null si aucun n'est défini.
     */
    public function getTypeOffre(): ?TypeOffre
    {
        return $this->typeOffre;
    }

    /**
     * Définit l'entité TypeOffre associée à cette offre.
     *
     * @param TypeOffre|null $typeOffre Le type d'offre à associer à cette instance.
     * @return static Retourne l'instance actuelle pour chaînage des méthodes.
     */
    public function setTypeOffre(?TypeOffre $typeOffre): static
    {
        $this->typeOffre = $typeOffre;

        return $this;
    }

    /**
     * Récupère l'entité ConditionsFinancieres associée à cette offre.
     *
     * @return ConditionsFinancieres|null Les conditions financières de l'offre ou null si aucune n'est définie.
     */
    public function getConditionsFinancieres(): ?ConditionsFinancieres
    {
        return $this->conditionsFinancieres;
    }

    /**
     * Définit l'entité ConditionsFinancieres associée à cette offre.
     *
     * @param ConditionsFinancieres|null $conditionsFinancieres Les conditions financières à associer à l'offre.
     * @return static Retourne l'instance actuelle pour chaînage des méthodes.
     */
    public function setConditionsFinancieres(?ConditionsFinancieres $conditionsFinancieres): static
    {
        $this->conditionsFinancieres = $conditionsFinancieres;

        return $this;
    }

    /**
     * Récupère l'entité BudgetEstimatif associée à cette offre.
     *
     * @return BudgetEstimatif|null Le budget estimatif de l'offre ou null si aucun n'est défini.
     */
    public function getBudgetEstimatif(): ?BudgetEstimatif
    {
        return $this->budgetEstimatif;
    }

    /**
     * Définit l'entité BudgetEstimatif associée à cette offre.
     *
     * @param BudgetEstimatif|null $budgetEstimatif Le budget estimatif à associer à l'offre.
     * @return static Retourne l'instance actuelle pour chaînage des méthodes.
     */
    public function setBudgetEstimatif(?BudgetEstimatif $budgetEstimatif): static
    {
        $this->budgetEstimatif = $budgetEstimatif;

        return $this;
    }

    /**
     * Récupère l'entité FicheTechniqueArtiste associée à cette offre.
     *
     * @return FicheTechniqueArtiste|null La fiche technique de l'artiste liée à l'offre ou null si aucune n'est définie
     */
    public function getFicheTechniqueArtiste(): ?FicheTechniqueArtiste
    {
        return $this->ficheTechniqueArtiste;
    }

    /**
     * Définit l'entité FicheTechniqueArtiste associée à cette offre.
     *
     * @param FicheTechniqueArtiste|null $ficheTechniqueArtiste La fiche technique de l'artiste à associer à l'offre.
     * @return static Retourne l'instance actuelle pour chaînage des méthodes.
     */
    public function setFicheTechniqueArtiste(?FicheTechniqueArtiste $ficheTechniqueArtiste): static
    {
        $this->ficheTechniqueArtiste = $ficheTechniqueArtiste;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getArtistes(): Collection
    {
        return $this->artistes;
    }

    public function addArtiste(Artiste $artiste): self
    {
        if (!$this->artistes->contains($artiste)) {
            $this->artistes->add($artiste);
            $artiste->addOffre($this);
        }
        return $this;
    }

    public function removeArtiste(Artiste $artiste): self
    {
        if ($this->artistes->removeElement($artiste)) {
            $artiste->removeOffre($this);
        }
        return $this;
    }

    public function getReseaux(): Collection
    {
        return $this->reseaux;
    }

    public function addReseau(Reseau $reseau): self
    {
        if (!$this->reseaux->contains($reseau)) {
            $this->reseaux->add($reseau);
            $reseau->addOffre($this);
        }
        return $this;
    }

    public function removeReseau(Reseau $reseau): self
    {
        if ($this->reseaux->removeElement($reseau)) {
            $reseau->removeOffre($this);
        }
        return $this;
    }

    public function getGenresMusicaux(): Collection
    {
        return $this->genresMusicaux;
    }

    public function addGenreMusical(GenreMusical $genreMusical): self
    {
        if (!$this->genresMusicaux->contains($genreMusical)) {
            $this->genresMusicaux->add($genreMusical);
            $genreMusical->addOffre($this);
        }
        return $this;
    }

    public function removeGenreMusical(GenreMusical $genreMusical): self
    {
        if ($this->genresMusicaux->removeElement($genreMusical)) {
            $genreMusical->removeOffre($this);
        }
        return $this;
    }

    public function getCommenteesPar(): Collection
    {
        return $this->commenteesPar;
    }

    public function addCommenteePar(Utilisateur $commenteePar): self
    {
        if (!$this->commenteesPar->contains($commenteePar)) {
            $this->commenteesPar->add($commenteePar);
            $commenteePar->addOffre($this);
        }
        return $this;
    }

    public function removeCommenteePar(Utilisateur $commenteePar): self
    {
        if ($this->commenteesPar->removeElement($commenteePar)) {
            $commenteePar->removeOffre($this);
        }
        return $this;
    }

    public function addReponse(Reponse $reponse): self
    {
        if (!$this->reponses->contains($reponse)) {
            $this->reponses[] = $reponse;
            $reponse->setOffre($this);
        }
        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            if ($reponse->getOffre() === $this) {
                $reponse->setOffre(null);
            }
        }
        return $this;
    }
}
