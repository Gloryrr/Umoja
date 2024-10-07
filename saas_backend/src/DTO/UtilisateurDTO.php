<?php

namespace App\DTO;

class UtilisateurDTO
{
    public ?int $idUtilisateur = null;
    public ?string $emailUtilisateur = null;
    public ?string $roleUtilisateur = null;
    public ?string $username = null;
    public ?string $nomUtilisateur = null;
    public ?string $prenomUtilisateur = null;
    public ?string $numTelUtilisateur = null;
    public array $membreDesReseaux = [];
    public array $genresMusicauxPreferes = [];

    public function __construct(
        ?int $idUtilisateur = null,
        ?string $emailUtilisateur = null,
        ?string $roleUtilisateur = null,
        ?string $username = null,
        ?string $nomUtilisateur = null,
        ?string $prenomUtilisateur = null,
        ?string $numTelUtilisateur = null
    ) {
        $this->idUtilisateur = $idUtilisateur;
        $this->emailUtilisateur = $emailUtilisateur;
        $this->roleUtilisateur = $roleUtilisateur;
        $this->username = $username;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->prenomUtilisateur = $prenomUtilisateur;
        $this->numTelUtilisateur = $numTelUtilisateur;
    }
}