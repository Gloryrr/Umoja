<?php

namespace App\Tests\Entity;

use App\Entity\Artiste;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité Artiste.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité Artiste
 * à l'aide de PHPUnit.
 */
class ArtisteTest extends TestCase
{
    /**
     * Instance de l'artiste à tester.
     *
     * @var Artiste
     */
    private Artiste $artiste;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de Artiste.
     */
    protected function setUp(): void
    {
        $this->artiste = new Artiste();
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie si l'identifiant d'un artiste peut être récupéré.
     */
    public function testGetId()
    {
        $this->assertEquals(0, $this->artiste->getId());
    }

    /**
     * Test de la méthode getNomArtiste() et setNomArtiste().
     *
     * Vérifie si le nom d'un artiste peut être correctement
     * défini et récupéré.
     */
    public function testNomArtiste()
    {
        $this->artiste->setNomArtiste("Artiste Test");
        $this->assertEquals("Artiste Test", $this->artiste->getNomArtiste());
    }

    /**
     * Test de la méthode getDescrArtiste() et setDescrArtiste().
     *
     * Vérifie si la description d'un artiste peut être correctement
     * définie et récupérée.
     */
    public function testDescrArtiste()
    {
        $description = "Ceci est un artiste de test.";
        
        $this->artiste->setDescrArtiste($description);
        $this->assertEquals($description, $this->artiste->getDescrArtiste());
    }

    /**
     * Test de la méthode setDescrArtiste() avec description nulle.
     *
     * Vérifie si la description peut être mise à null.
     */
    public function testSetDescrArtisteNull()
    {
        $this->artiste->setDescrArtiste(null);
        $this->assertNull($this->artiste->getDescrArtiste());
    }
}