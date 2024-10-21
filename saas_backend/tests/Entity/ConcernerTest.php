<?php

namespace App\Tests\Entity;

use App\Entity\Concerner;
use App\Entity\Artiste;
use App\Entity\Offre;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité Concerner.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité Concerner
 * à l'aide de PHPUnit.
 */
class ConcernerTest extends TestCase
{
    /**
     * Instance de Concerner à tester.
     *
     * @var Concerner
     */
    private Concerner $concerner;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de Concerner.
     */
    protected function setUp(): void
    {
        $this->concerner = new Concerner();
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie si l'identifiant de Concerner peut être récupéré.
     */
    public function testGetIdC()
    {
        $this->assertNull($this->concerner->getIdC());
    }

    /**
     * Test de la méthode getIdArtiste() et setIdArtiste().
     *
     * Vérifie si l'artiste peut être correctement
     * défini et récupéré.
     */
    public function testIdArtiste()
    {
        $artiste = new Artiste();
        $this->concerner->setIdArtiste($artiste);
        $this->assertSame($artiste, $this->concerner->getIdArtiste());
    }

    /**
     * Test de la méthode getIdOffre() et setIdOffre().
     *
     * Vérifie si l'offre peut être correctement
     * définie et récupérée.
     */
    public function testIdOffre()
    {
        $offre = new Offre();
        $this->concerner->setIdOffre($offre);
        $this->assertSame($offre, $this->concerner->getIdOffre());
    }
}
