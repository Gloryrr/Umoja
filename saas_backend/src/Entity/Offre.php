<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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
    /**
     * Identifiant unique de l'offre.
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Titre de l'offre.
     *
     * @var string|null
     */
    #[ORM\Column(length: 50)]
    private ?string $titleOffre = null;

    /**
     * Date limite pour répondre à l'offre.
     *
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $deadLine = null;

    /**
     * Description de la tournée associée à l'offre.
     *
     * @var string|null
     */
    #[ORM\Column(length: 500)]
    private ?string $descrTournee = null;

    /**
     * Date minimale proposée pour la tournée.
     *
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateMinProposee = null;

    /**
     * Date maximale proposée pour la tournée.
     *
     * @var \DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateMaxProposee = null;

    /**
     * Ville visée par la tournée.
     *
     * @var string|null
     */
    #[ORM\Column(length: 50)]
    private ?string $villeVisee = null;

    /**
     * Région visée par la tournée.
     *
     * @var string|null
     */
    #[ORM\Column(length: 50)]
    private ?string $regionVisee = null;

    /**
     * Nombre minimum de places disponibles.
     *
     * @var int|null
     */
    #[ORM\Column]
    private ?int $placesMin = null;

      /**
     * Nombre de contrirbuteur à l'offre.
     *
     * @var int|null
     */
    #[ORM\Column]
    private ?int $nb_contributeur = null;

    /**
     * Nombre maximum de places disponibles.
     *
     * @var int|null
     */
    #[ORM\Column]
    private ?int $placesMax = null;

    /**
     * Nombre d'artistes concernés par l'offre.
     *
     * @var int|null
     */
    #[ORM\Column]
    private ?int $nbArtistesConcernes = null;

    /**
     * Nombre d'invités concernés par l'offre.
     *
     * @var int|null
     */
    #[ORM\Column]
    private ?int $nbInvitesConcernes = null;

    /**
     * Liens promotionnels associés à l'offre.
     *
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    private ?string $liensPromotionnels = null;

    /**
     * Relation avec l'entité Extras.
     *
     * Définit une relation ManyToOne avec l'entité Extras. Cela représente
     * les extras associés à une offre. Cette colonne ne peut pas être nulle.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Extras $extras = null;

    /**
     * Relation avec l'entité EtatOffre.
     *
     * Définit une relation ManyToOne avec l'entité EtatOffre, qui spécifie l'état
     * ou le statut de l'offre (par exemple, "en cours", "terminée").
     * Cette colonne ne peut pas être nulle.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?EtatOffre $etatOffre = null;

    /**
     * Relation avec l'entité TypeOffre.
     *
     * Définit une relation ManyToOne avec l'entité TypeOffre, représentant le type
     * spécifique de l'offre (par exemple, "concert", "événement privé").
     * Cette colonne ne peut pas être nulle.
    */
     #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeOffre $typeOffre = null;

    /**
     * Relation avec l'entité ConditionsFinancieres.
     *
     * Définit une relation ManyToOne avec l'entité ConditionsFinancieres,
     * qui précise les conditions financières associées à l'offre.
     * Cette colonne ne peut pas être nulle.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?ConditionsFinancieres $conditionsFinancieres = null;

    /**
     * Relation avec l'entité BudgetEstimatif.
     *
     * Définit une relation ManyToOne avec l'entité BudgetEstimatif,
     * représentant le budget estimé pour l'offre. Cette colonne ne peut pas être nulle.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?BudgetEstimatif $budgetEstimatif = null;

    /**
     * Relation avec l'entité FicheTechniqueArtiste.
     *
     * Définit une relation ManyToOne avec l'entité FicheTechniqueArtiste,
     * qui spécifie la fiche technique de l'artiste liée à l'offre.
     * Cette colonne ne peut pas être nulle.
     */
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FicheTechniqueArtiste $ficheTechniqueArtiste = null;

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
     * Obtient le nombre de contributeur par l'offre.
     *
     * @return int|null
     */
    public function getNbContributeur(): ?int
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
}
