<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

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
    #[Groups([
        'offre:read',
        'utilisateur:read',
        'extras:read',
        'etatIffre:read',
        'type_offre:read',
        'etat_offre:read',
        'conditions_financieres:read',
        'budget_estimatif:read',
        'fiche_technique_artiste:read',
        'artiste:read',
        'reseau:read',
        'genre_musical:read',
        'commentaire:read',
        'reponse:read',
    ])]
    private int $id = 0;

    #[ORM\Column(length: 50)]
    #[Groups(['offre:read', 'offre:write'])]
    private string $titleOffre;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['offre:read', 'offre:write'])]
    private \DateTimeInterface $deadLine;

    #[ORM\Column(length: 500)]
    #[Groups(['offre:read', 'offre:write'])]
    private string $descrTournee;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['offre:read', 'offre:write'])]
    private \DateTimeInterface $dateMinProposee;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['offre:read', 'offre:write'])]
    private \DateTimeInterface $dateMaxProposee;

    #[ORM\Column(length: 50)]
    #[Groups(['offre:read', 'offre:write'])]
    private string $villeVisee;

    #[ORM\Column(length: 50)]
    #[Groups(['offre:read', 'offre:write'])]
    private string $regionVisee;

    #[ORM\Column]
    #[Groups(['offre:read', 'offre:write'])]
    private int $placesMin;

      /**
     * Nombre de contrirbuteur à l'offre.
     *
     * @var int
     */
    #[ORM\Column]
    private int $nb_contributeur;

    /**
     * Nombre maximum de places disponibles.
     *
     * @var int
     */

    #[ORM\Column]
    #[Groups(['offre:read', 'offre:write'])]
    private int $placesMax;

    #[ORM\Column]
    #[Groups(['offre:read', 'offre:write'])]
    private int $nbArtistesConcernes;

    #[ORM\Column]
    #[Groups(['offre:read', 'offre:write'])]
    private int $nbInvitesConcernes;

    #[ORM\Column(length: 255)]
    #[Groups(['offre:read', 'offre:write'])]
    private string $liensPromotionnels;

    #[ORM\ManyToOne(targetEntity: Extras::class, inversedBy: "offres", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private Extras $extras;

    #[ORM\ManyToOne(targetEntity: EtatOffre::class, inversedBy: "offres", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private EtatOffre $etatOffre;

    #[ORM\ManyToOne(targetEntity: TypeOffre::class, inversedBy: "offres", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private TypeOffre $typeOffre;

    #[ORM\ManyToOne(targetEntity: ConditionsFinancieres::class, inversedBy: "offres", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private ConditionsFinancieres $conditionsFinancieres;

    #[ORM\ManyToOne(targetEntity: BudgetEstimatif::class, inversedBy: "offres", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private BudgetEstimatif $budgetEstimatif;

    #[ORM\ManyToOne(targetEntity: FicheTechniqueArtiste::class, inversedBy: "offres", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private FicheTechniqueArtiste $ficheTechniqueArtiste;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: "offres", cascade: ["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['offre:read', 'offre:write'])]
    private Utilisateur $utilisateur;

    #[ORM\ManyToMany(targetEntity: Artiste::class, mappedBy: "offres", cascade: ["persist"])]
    #[Groups(['offre:read', 'offre:write'])]
    #[MaxDepth(1)]
    private Collection $artistes;

    #[ORM\ManyToMany(targetEntity: Reseau::class, mappedBy: "offres", cascade: ["persist"])]
    #[Groups(['offre:read', 'offre:write'])]
    #[MaxDepth(1)]
    private Collection $reseaux;

    #[ORM\ManyToMany(targetEntity: GenreMusical::class, mappedBy: "offres", cascade: ["persist"])]
    #[Groups(['offre:read', 'offre:write'])]
    #[MaxDepth(1)]
    private Collection $genresMusicaux;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: "offre", orphanRemoval: true, cascade: ["remove"])]
    #[Groups(['offre:read'])]
    #[MaxDepth(1)]
    private Collection $commenteesPar;

    #[ORM\OneToMany(targetEntity: Reponse::class, mappedBy: "offre", orphanRemoval: true, cascade: ["remove"])]
    #[Groups(['offre:read', 'offre:write'])]
    #[MaxDepth(1)]
    private Collection $reponses;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    #[Groups(['offre:read', 'offre:write'])]
    private $image = null;

    public function __construct()
    {
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
     * @return string
     */
    public function getTitleOffre(): string
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
     * @return \DateTimeInterface
     */
    public function getDeadLine(): \DateTimeInterface
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
     * @return string
     */
    public function getDescrTournee(): string
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
     * @return \DateTimeInterface
     */
    public function getDateMinProposee(): \DateTimeInterface
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
     * @return \DateTimeInterface
     */
    public function getDateMaxProposee(): \DateTimeInterface
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
     * @return string
     */
    public function getVilleVisee(): string
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
     * @return string
     */
    public function getRegionVisee(): string
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
     * @return int
     */
    public function getPlacesMin(): int
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
     * @return int
     */
    public function getPlacesMax(): int
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
     * @return int
     */
    public function getNbArtistesConcernes(): int
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
     * Obtient le nombre de contributeur par l'offre.
     *
     * @return int
     */
    public function getNbContributeur(): int
    {
        return $this->nb_contributeur;
    }

    /**
     * Définit le nombre de contributeur par offre.
     *
     * @param int $nb_contributeur
     * @return self
     */
    public function setNbContributeur(int $nb_contributeur): static
    {
        $this->nb_contributeur = $nb_contributeur;

        return $this;
    }

    /**
     * Obtient le nombre d'invités concernés par l'offre.
     *
     * @return int
     */
    public function getNbInvitesConcernes(): int
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
     * @return string
     */
    public function getLiensPromotionnels(): string
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
     * @return Extras L'entité Extras associée ou null si aucune n'est définie.
     */
    public function getExtras(): Extras
    {
        return $this->extras;
    }

    /**
     * Définit l'entité Extras associée à cette offre.
     *
     * @param Extras $extras L'entité Extras à associer à l'offre.
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
     * @return EtatOffre L'état de l'offre ou null si aucun n'est défini.
     */
    public function getEtatOffre(): EtatOffre
    {
        return $this->etatOffre;
    }

    /**
     * Définit l'entité EtatOffre associée à cette offre.
     *
     * @param EtatOffre $etatOffre L'entité EtatOffre à associer à l'offre.
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
     * @return TypeOffre Le type de l'offre ou null si aucun n'est défini.
     */
    public function getTypeOffre(): TypeOffre
    {
        return $this->typeOffre;
    }

    /**
     * Définit l'entité TypeOffre associée à cette offre.
     *
     * @param TypeOffre $typeOffre Le type d'offre à associer à cette instance.
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
     * @return ConditionsFinancieres Les conditions financières de l'offre ou null si aucune n'est définie.
     */
    public function getConditionsFinancieres(): ConditionsFinancieres
    {
        return $this->conditionsFinancieres;
    }

    /**
     * Définit l'entité ConditionsFinancieres associée à cette offre.
     *
     * @param ConditionsFinancieres $conditionsFinancieres Les conditions financières à associer à l'offre.
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
     * @return BudgetEstimatif Le budget estimatif de l'offre ou null si aucun n'est défini.
     */
    public function getBudgetEstimatif(): BudgetEstimatif
    {
        return $this->budgetEstimatif;
    }

    /**
     * Définit l'entité BudgetEstimatif associée à cette offre.
     *
     * @param BudgetEstimatif $budgetEstimatif Le budget estimatif à associer à l'offre.
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
     * @return FicheTechniqueArtiste La fiche technique de l'artiste liée à l'offre ou null si aucune n'est définie
     */
    public function getFicheTechniqueArtiste(): FicheTechniqueArtiste
    {
        return $this->ficheTechniqueArtiste;
    }

    /**
     * Définit l'entité FicheTechniqueArtiste associée à cette offre.
     *
     * @param FicheTechniqueArtiste $ficheTechniqueArtiste La fiche technique de l'artiste à associer à l'offre.
     * @return static Retourne l'instance actuelle pour chaînage des méthodes.
     */
    public function setFicheTechniqueArtiste(?FicheTechniqueArtiste $ficheTechniqueArtiste): static
    {
        $this->ficheTechniqueArtiste = $ficheTechniqueArtiste;

        return $this;
    }

    public function getUtilisateur(): Utilisateur
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

    public function getReponses(): Collection
    {
        return $this->reponses;
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

    public function getImage(): ?string
    {
        if ($this->image === null) {
            return null;
        }
        if (is_resource($this->image)) {
            $binaryData = stream_get_contents($this->image);
        } else {
            $binaryData = $this->image;
        }
        if (base64_encode(base64_decode($binaryData, true)) === $binaryData) {
            return $binaryData;
        }
        return base64_encode($binaryData);
    }


    public function setImage(mixed $image): self
    {
        if (is_array($image)) {
            $this->image = implode('', $image);
        } elseif (is_string($image)) {
            if (base64_decode($image, true) !== false) {
                $this->image = base64_decode($image);
            } else {
                $this->image = $image;
            }
        } else {
            $this->image = null;
        }

        return $this;
    }
}
