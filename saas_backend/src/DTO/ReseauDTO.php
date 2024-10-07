<?php

namespace App\DTO;

class ReseauDTO
{
    public ?int $idReseau = null;
    public ?string $nomReseau = null;
    public array $membreDuReseau = [];
    public array $genresMusicauxDuReseau = [];

    public function __construct(
        ?int $idReseau = null,
        ?string $nomReseau = null,
        array $membreDuReseau = [],
        array $genresMusicauxDuReseau = []
    )
    {
        $this->idReseau = $idReseau;
        $this->nomReseau = $nomReseau;
        $this->membreDuReseau = $membreDuReseau;
        $this->genresMusicauxDuReseau = $genresMusicauxDuReseau;
    }
}