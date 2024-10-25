<?php

namespace App\DTO;

class UtilisateurDTO
{
    public ?int $idUtilisateur = null;
    public ?string $emailUtilisateur = null;
    public array $roleUtilisateur = [];
    public ?string $username = null;
    public ?string $nomUtilisateur = null;
    public ?string $prenomUtilisateur = null;
    public array $membreDesReseaux = [];
    public array $genresMusicauxPreferes = [];

    public function __construct(
        ?int $idUtilisateur = null,
        ?string $emailUtilisateur = null,
        array $roleUtilisateur = [],
        ?string $username = null,
        ?string $nomUtilisateur = null,
        ?string $prenomUtilisateur = null,
        array $membreDesReseaux = [],
        array $genresMusicauxDuReseau = []
    ) {
        $this->idUtilisateur = $idUtilisateur;
        $this->emailUtilisateur = $emailUtilisateur;
        $this->roleUtilisateur = $roleUtilisateur;
        $this->username = $username;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->prenomUtilisateur = $prenomUtilisateur;
        $this->membreDesReseaux = $membreDesReseaux;
        $this->genresMusicauxDuReseau = $genresMusicauxDuReseau;
    }
}
