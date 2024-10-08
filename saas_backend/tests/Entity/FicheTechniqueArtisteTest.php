<?php

namespace App\Tests\Entity;

use App\Entity\FicheTechniqueArtiste;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité FicheTechniqueArtiste.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité FicheTechniqueArtiste
 * à l'aide de PHPUnit.
 */
class FicheTechniqueArtisteTest extends TestCase
{
    /**
     * Instance de la fiche technique à tester.
     *
     * @var FicheTechniqueArtiste
     */
    private FicheTechniqueArtiste $ficheTechnique;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de FicheTechniqueArtiste.
     */
    protected function setUp(): void
    {
        $this->ficheTechnique = new FicheTechniqueArtiste();
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie si l'identifiant d'une fiche technique peut être récupéré.
     */
    public function testGetIdFT()
    {
        $this->assertNull($this->ficheTechnique->getIdFT());
    }

    /**
     * Test de la méthode setBesoinSonorisation() et getBesoinSonorisation().
     *
     * Vérifie si les besoins en sonorisation peuvent être correctement
     * définis et récupérés.
     */
    public function testBesoinSonorisation()
    {
        $this->ficheTechnique->setBesoinSonorisation("Sonorisation complète");
        $this->assertEquals("Sonorisation complète", $this->ficheTechnique->getBesoinSonorisation());
    }

    /**
     * Test de la méthode setBesoinEclairage() et getBesoinEclairage().
     *
     * Vérifie si les besoins en éclairage peuvent être correctement
     * définis et récupérés.
     */
    public function testBesoinEclairage()
    {
        $this->ficheTechnique->setBesoinEclairage("Eclairage LED");
        $this->assertEquals("Eclairage LED", $this->ficheTechnique->getBesoinEclairage());
    }

    /**
     * Test de la méthode setBesoinScene() et getBesoinScene().
     *
     * Vérifie si les besoins en scène peuvent être correctement
     * définis et récupérés.
     */
    public function testBesoinScene()
    {
        $this->ficheTechnique->setBesoinScene("Scène de 10x8 mètres");
        $this->assertEquals("Scène de 10x8 mètres", $this->ficheTechnique->getBesoinScene());
    }

    /**
     * Test de la méthode setBesoinBackline() et getBesoinBackline().
     *
     * Vérifie si les besoins en backline peuvent être correctement
     * définis et récupérés.
     */
    public function testBesoinBackline()
    {
        $this->ficheTechnique->setBesoinBackline("Backline standard");
        $this->assertEquals("Backline standard", $this->ficheTechnique->getBesoinBackline());
    }

    /**
     * Test de la méthode setBesoinEquipements() et getBesoinEquipements().
     *
     * Vérifie si les besoins en équipements peuvent être correctement
     * définis et récupérés.
     */
    public function testBesoinEquipements()
    {
        $this->ficheTechnique->setBesoinEquipements("Microphones et câbles");
        $this->assertEquals("Microphones et câbles", $this->ficheTechnique->getBesoinEquipements());
    }
}
