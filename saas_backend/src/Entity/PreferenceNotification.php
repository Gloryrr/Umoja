<?php

namespace App\Entity;

use App\Repository\PreferenceNotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: PreferenceNotificationRepository::class)]
class PreferenceNotification
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "SEQUENCE")]
    #[ORM\Column]
    #[Groups([
        'preference_notification:read',
        'preference_notification:write',
        'utilisateur:read',
    ])]
    #[MaxDepth(1)]
    private int $id;

    #[ORM\Column]
    #[Groups(['preference_notification:read', 'preference_notification:write'])]
    #[MaxDepth(1)]
    private bool $email_nouvelle_offre;

    #[ORM\Column]
    #[Groups(['preference_notification:read', 'preference_notification:write'])]
    #[MaxDepth(1)]
    private bool $email_update_offre;

    #[ORM\Column]
    #[Groups(['preference_notification:read', 'preference_notification:write'])]
    #[MaxDepth(1)]
    private bool $reponse_offre;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\OneToMany(targetEntity: Utilisateur::class, mappedBy: 'preferenceNotification')]
    private Collection $utilisateur;

    public function __construct()
    {
        $this->email_nouvelle_offre = true;
        $this->email_update_offre = true;
        $this->reponse_offre = true;
        $this->utilisateur = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function isEmailNouvelleOffre(): bool
    {
        return $this->email_nouvelle_offre;
    }

    public function setEmailNouvelleOffre(bool $email_nouvelle_offre): static
    {
        $this->email_nouvelle_offre = $email_nouvelle_offre;

        return $this;
    }

    public function isEmailUpdateOffre(): bool
    {
        return $this->email_update_offre;
    }

    public function setEmailUpdateOffre(bool $email_update_offre): static
    {
        $this->email_update_offre = $email_update_offre;

        return $this;
    }

    public function isReponseOffre(): bool
    {
        return $this->reponse_offre;
    }

    public function setReponseOffre(bool $reponse_offre): static
    {
        $this->reponse_offre = $reponse_offre;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateur(): Collection
    {
        return $this->utilisateur;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->utilisateur->contains($utilisateur)) {
            $this->utilisateur->add($utilisateur);
            $utilisateur->setPreferenceNotification($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateur->removeElement($utilisateur)) {
            if ($utilisateur->getPreferenceNotification() === $this) {
                $utilisateur->setPreferenceNotification(null);
            }
        }

        return $this;
    }
}
