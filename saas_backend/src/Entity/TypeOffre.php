<?php

namespace App\Entity;

use App\Repository\TypeOffreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeOffreRepository::class)]
class TypeOffre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomTypeOffre = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTypeOffre(): ?string
    {
        return $this->nomTypeOffre;
    }

    public function setNomTypeOffre(string $nomTypeOffre): static
    {
        $this->nomTypeOffre = $nomTypeOffre;

        return $this;
    }
}
