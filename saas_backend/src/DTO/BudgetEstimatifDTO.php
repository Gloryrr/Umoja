<?php

namespace App\DTO;

class BudgetEstimatifDTO
{
    public ?int $idBE = null;
    public ?int $cachetArtiste = null;
    public ?int $fraisDeplacement = null;
    public ?int $fraisHebergement = null;
    public ?int $fraisRestauration = null;

    public function __construct(
        ?int $idBE = null,
        ?int $cachetArtiste = null,
        ?int $fraisDeplacement = null,
        ?int $fraisHebergement = null,
        ?int $fraisRestauration = null
    ) {
        $this->idBE = $idBE;
        $this->cachetArtiste = $cachetArtiste;
        $this->fraisDeplacement = $fraisDeplacement;
        $this->fraisHebergement = $fraisHebergement;
        $this->fraisRestauration = $fraisRestauration;
    }
}
