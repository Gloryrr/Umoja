<?php

namespace App\DTO;

class ConditionsFinancieresDTO
{
    public ?int $idCF = null;
    public ?int $minimunGaranti = null;
    public ?string $conditionsPaiement = null;
    public ?float $pourcentageRecette = null;

    public function __construct(
        ?int $idCF = null,
        ?int $minimunGaranti = null,
        ?string $conditionsPaiement = null,
        ?float $pourcentageRecette = null
    ) {
        $this->idCF = $idCF;
        $this->minimunGaranti = $minimunGaranti;
        $this->conditionsPaiement = $conditionsPaiement;
        $this->pourcentageRecette = $pourcentageRecette;
    }
}