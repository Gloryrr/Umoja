<?php

namespace App\DTO;

class FicheTechniqueArtisteDTO
{
    public ?int $idFT = null;
    public ?string $besoinSonorisation = null;
    public ?string $besoinEclairage = null;
    public ?string $besoinScene = null;
    public ?string $besoinBackline = null;
    public ?string $besoinEquipements = null;

    public function __construct(
        ?int $idFT = null,
        ?string $besoinSonorisation = null,
        ?string $besoinEclairage = null,
        ?string $besoinScene = null,
        ?string $besoinBackline = null,
        ?string $besoinEquipements = null
    ) {
        $this->idFT = $idFT;
        $this->besoinSonorisation = $besoinSonorisation;
        $this->besoinEclairage = $besoinEclairage;
        $this->besoinScene = $besoinScene;
        $this->besoinBackline = $besoinBackline;
        $this->besoinEquipements = $besoinEquipements;
    }
}
