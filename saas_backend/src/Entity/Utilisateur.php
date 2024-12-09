<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * Classe représentant un Utilisateur.
 *
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\Column]
    #[Groups(['utilisateur:read', 'utilisateur:write'])]
    private int $id;

    #[ORM\Column(length: 128, unique: true, nullable: false)]
    #[Groups(['utilisateur:read', 'utilisateur:write'])]
    private string $emailUtilisateur;

    #[ORM\Column(length: 255, nullable: false)]
    private string $mdpUtilisateur;

    #[ORM\Column(length: 20, nullable: false)]
    #[Groups(['utilisateur:read', 'utilisateur:write'])]
    private string $roleUtilisateur;

    #[ORM\Column(length: 50, nullable: false, unique: true)]
    #[Groups([
        'utilisateur:read',
        'utilisateur:write',
        'offre:read',
        'genre_musical:read',
        'reseau:read',
        'commentaire:read',
        'reponse:read',
        'preference_notification:read'
    ])]
    private string $username;

    #[ORM\Column(length: 15, nullable: true)]
    #[Groups(['utilisateur:read', 'utilisateur:write'])]
    private ?string $numTelUtilisateur = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['utilisateur:read', 'utilisateur:write'])]
    private ?string $nomUtilisateur = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['utilisateur:read', 'utilisateur:write'])]
    private ?string $prenomUtilisateur = null;

    #[ORM\ManyToMany(targetEntity: GenreMusical::class, inversedBy: "utilisateurs", cascade: ["persist"])]
    #[ORM\JoinTable(name: "preferencer")]
    #[ORM\JoinColumn(name: "utilisateur_id", onDelete: "CASCADE")]
    #[ORM\InverseJoinColumn(name: "genre_musical_id", onDelete: "CASCADE")]
    #[Groups(['utilisateur:read'])]
    #[MaxDepth(1)]
    private Collection $genresMusicaux;

    #[ORM\ManyToMany(targetEntity: Reseau::class, inversedBy: "utilisateurs", cascade: ["persist"])]
    #[ORM\JoinTable(name: "appartenir")]
    #[ORM\JoinColumn(name: "utilisateur_id", onDelete: "CASCADE")]
    #[ORM\InverseJoinColumn(name: "reseau_id", onDelete: "CASCADE")]
    #[Groups(['utilisateur:read', 'utilisateur:write'])]
    #[MaxDepth(1)]
    private Collection $reseaux;

    #[ORM\OneToMany(targetEntity: Offre::class, mappedBy: "utilisateur", orphanRemoval: true, cascade: ["remove"])]
    #[Groups(['utilisateur:read'])]
    #[MaxDepth(1)]
    private Collection $offres;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: "utilisateur", orphanRemoval: true, cascade:["remove"])]
    #[Groups(['utilisateur:read'])]
    #[MaxDepth(1)]
    private Collection $offresCommentees;

    #[ORM\OneToMany(targetEntity: Reponse::class, mappedBy: "utilisateur", orphanRemoval: true, cascade: ["remove"])]
    #[Groups(['utilisateur:read'])]
    #[MaxDepth(1)]
    private Collection $reponses;

    #[ORM\ManyToOne(targetEntity: PreferenceNotification::class, inversedBy: 'utilisateur', cascade: ["persist"])]
    #[ORM\JoinColumn]
    #[Groups(['utilisateur:read', 'utilisateur:write'])]
    #[MaxDepth(1)]
    private PreferenceNotification $preferenceNotification;

    /**
     * Constructeur de la classe.
     */
    public function __construct()
    {
        $this->genresMusicaux = new ArrayCollection();
        $this->reseaux = new ArrayCollection();
        $this->offres = new ArrayCollection();
        $this->offresCommentees = new ArrayCollection();
        $this->reponses = new ArrayCollection();
    }

    /**
     * Récupère l'identifiant de l'utilisateur.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Définit l'identifiant de l'utilisateur.
     *
     * @param int $id
     * @return static
     */
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Récupère l'email de l'utilisateur.
     *
     * @return string
     */
    public function getEmailUtilisateur(): string
    {
        return $this->emailUtilisateur;
    }

    /**
     * Définit l'email de l'utilisateur.
     *
     * @param string $emailUtilisateur
     * @return static
     */
    public function setEmailUtilisateur(string $emailUtilisateur): static
    {
        $this->emailUtilisateur = $emailUtilisateur;

        return $this;
    }

    /**
     * Récupère le mot de passe de l'utilisateur.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->mdpUtilisateur;
    }

    /**
     * Définit le mot de passe de l'utilisateur.
     *
     * @param string $mdpUtilisateur
     * @return static
     */
    public function setMdpUtilisateur(string $mdpUtilisateur): static
    {
        $this->mdpUtilisateur = $mdpUtilisateur;

        return $this;
    }

    /**
     * Récupère le numéro de téléphone de l'utilisateur.
     *
     * @return string
     */
    public function getNumTelUtilisateur(): string
    {
        return $this->numTelUtilisateur;
    }

    /**
     * Définit le numéro de téléphone de l'utilisateur.
     *
     * @param string $numTelUtilisateur
     * @return static
     */
    public function setNumTelUtilisateur(?string $numTelUtilisateur): static
    {
        $this->numTelUtilisateur = $numTelUtilisateur;

        return $this;
    }

    /**
     * Récupère le rôle de l'utilisateur, implémentation des fonctions d'interfaces.
     * Même si on renvoie une liste, l'utilisateur n'a qu'un rôle dans la hiérarchie
     *
     * Exemple : ['ROLE_USER'] ou ['ROLE_ADMIN'] donc son attribut sera un string comme 'ROLE_USER' ou 'ROLE_ADMIN'
     * Si l'utilisateur à 'ROLE_ADMIN', il est évident qu'il a aussi les droits 'ROLE_USER' implicitement.
     *
     * @return string
     */
    public function getRoles(): array
    {
        return [$this->roleUtilisateur];
    }

    /**
     * Définit le rôle de l'utilisateur.
     *
     * @param string $roleUtilisateur
     * @return static
     */
    public function setRoles(string $roleUtilisateur): static
    {
        $this->roleUtilisateur = $roleUtilisateur;

        return $this;
    }

    /**
     * Récupère le nom de l'utilisateur.
     *
     * @return string
     */
    public function getNomUtilisateur(): string
    {
        return $this->nomUtilisateur;
    }

    /**
     * Définit le nom de l'utilisateur.
     *
     * @param string $nomUtilisateur
     * @return static
     */
    public function setNomUtilisateur(?string $nomUtilisateur): static
    {
        $this->nomUtilisateur = $nomUtilisateur;

        return $this;
    }

    /**
     * Récupère le prénom de l'utilisateur.
     *
     * @return string
     */
    public function getPrenomUtilisateur(): string
    {
        return $this->prenomUtilisateur;
    }

    /**
     * Définit le prénom de l'utilisateur.
     *
     * @param string $prenomUtilisateur
     * @return static
     */
    public function setPrenomUtilisateur(?string $prenomUtilisateur): static
    {
        $this->prenomUtilisateur = $prenomUtilisateur;

        return $this;
    }

    /**
     * Récupère le nom d'utilisateur (username).
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Définit le nom d'utilisateur (username).
     *
     * @param string $username
     * @return static
     */
    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Implémentation de la méthode de l'interface UserInterface.
     *
     * @return string
     */
    public function eraseCredentials(): void
    {
        // Implémentation de la méthode de l'interface UserInterface.
        // Cette méthode ne fait rien, mais doit être implémentée.
    }

    /**
     * Implémentation de la méthode de l'interface PasswordAuthenticatedUserInterface.
     * Renvoie un string interpolé des identifiants de l'utilisateur: "email;username".
     *
     * @return string
     */
    public function getUserIdentifier(): string
    {
        return "{$this->emailUtilisateur}" . ";" . "{$this->username}";
    }

    public function getGenresMusicaux(): Collection
    {
        return $this->genresMusicaux;
    }

    public function addGenreMusical(GenreMusical $genreMusical): self
    {
        if (!$this->genresMusicaux->contains($genreMusical)) {
            $this->genresMusicaux->add($genreMusical);
            $genreMusical->addUtilisateur($this);
        }
        return $this;
    }

    public function removeGenreMusical(GenreMusical $genreMusical): self
    {
        if ($this->genresMusicaux->removeElement($genreMusical)) {
            $genreMusical->removeUtilisateur($this);
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
            $reseau->addUtilisateur($this);
        }
        return $this;
    }

    public function removeReseau(Reseau $reseau): self
    {
        if ($this->reseaux->removeElement($reseau)) {
            $reseau->removeUtilisateur($this);
        }
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
            $offre->setUtilisateur($this);
        }
        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            if ($offre->getUtilisateur() === $this) {
                $offre->setUtilisateur(null);
            }
        }
        return $this;
    }

    public function getOffresCommentees(): Collection
    {
        return $this->offresCommentees;
    }

    public function addOffreCommentee(Offre $offreCommentee): self
    {
        if (!$this->offresCommentees->contains($offreCommentee)) {
            $this->offresCommentees->add($offreCommentee);
            $offreCommentee->addCommenteePar($this);
        }
        return $this;
    }

    public function removeOffreCommentee(Offre $offreCommentee): self
    {
        if ($this->offresCommentees->removeElement($offreCommentee)) {
            $offreCommentee->removeCommenteePar($this);
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
            $reponse->setUtilisateur($this);
        }
        return $this;
    }

    public function removeReponse(Reponse $reponse): self
    {
        if ($this->reponses->removeElement($reponse)) {
            if ($reponse->getUtilisateur() === $this) {
                $reponse->setUtilisateur(null);
            }
        }
        return $this;
    }

    public function getPreferenceNotification(): PreferenceNotification
    {
        return $this->preferenceNotification;
    }

    public function setPreferenceNotification(?PreferenceNotification $preferenceNotification): static
    {
        $this->preferenceNotification = $preferenceNotification;

        return $this;
    }
}
