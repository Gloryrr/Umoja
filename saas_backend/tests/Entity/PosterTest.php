<?php

namespace App\Tests\Entity;

use App\Entity\Poster;
use App\Entity\Reseau;
use App\Entity\Offre;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité Poster.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité Poster
 * à l'aide de PHPUnit.
 */
class PosterTest extends TestCase
{
    /**
     * Instance de Poster à tester.
     *
     * @var Poster
     */
    private Poster $poster;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de Poster.
     */
    protected function setUp(): void
    {
        $this->poster = new Poster();
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie si l'identifiant de Poster peut être récupéré.
     */
    public function testGetId()
    {
        $this->assertNull($this->poster->getId());
    }

    /**
     * Test de la méthode getIdReseau() et setIdReseau().
     *
     * Vérifie si le réseau peut être correctement défini et récupéré.
     */
    public function testIdReseau()
    {
        $reseau = new Reseau();
        $this->poster->setIdReseau($reseau);
        $this->assertSame($reseau, $this->poster->getIdReseau());
    }

    /**
     * Test de la méthode getIdOffre() et setIdOffre().
     *
     * Vérifie si l'offre peut être correctement définie et récupérée.
     */
    public function testIdOffre()
    {
        $offre = new Offre();
        $this->poster->setIdOffre($offre);
        $this->assertSame($offre, $this->poster->getIdOffre());
    }
}
