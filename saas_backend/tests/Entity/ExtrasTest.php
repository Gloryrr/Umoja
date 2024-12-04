<?php

namespace App\Tests\Entity;

use App\Entity\Extras;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité Extras.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité Extras
 * à l'aide de PHPUnit.
 */
class ExtrasTest extends TestCase
{
    /**
     * Instance de Extras à tester.
     *
     * @var Extras
     */
    private Extras $extras;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de Extras.
     */
    protected function setUp(): void
    {
        $this->extras = new Extras();
    }

    /**
     * Test de la méthode getId() et setId().
     *
     * Vérifie si l'identifiant des extras peut être correctement
     * défini et récupéré.
     */
    public function testGetId(): void
    {
        // L'ID est généré automatiquement, donc il devrait être null à l'initialisation
        $this->assertEquals(0, $this->extras->getId());
    }

    /**
     * Test de la méthode getDescrExtras() et setDescrExtras().
     *
     * Vérifie si la description des extras peut être correctement
     * définie et récupérée.
     */
    public function testDescrExtras(): void
    {
        $this->extras->setDescrExtras("Service VIP");
        $this->assertEquals("Service VIP", $this->extras->getDescrExtras());
    }

    /**
     * Test de la méthode getCoutExtras() et setCoutExtras().
     *
     * Vérifie si le coût des extras peut être correctement
     * défini et récupéré.
     */
    public function testCoutExtras(): void
    {
        $this->extras->setCoutExtras(150);
        $this->assertEquals(150, $this->extras->getCoutExtras());
    }

    /**
     * Test de la méthode getExclusivite() et setExclusivite().
     *
     * Vérifie si l'exclusivité des extras peut être correctement
     * définie et récupérée.
     */
    public function testExclusivite(): void
    {
        $this->extras->setExclusivite("Oui");
        $this->assertEquals("Oui", $this->extras->getExclusivite());
    }

    /**
     * Test de la méthode getException() et setException().
     *
     * Vérifie si l'exception des extras peut être correctement
     * définie et récupérée.
     */
    public function testException(): void
    {
        $this->extras->setException("Aucune exception");
        $this->assertEquals("Aucune exception", $this->extras->getException());
    }

    /**
     * Test de la méthode getOrdrePassage() et setOrdrePassage().
     *
     * Vérifie si l'ordre de passage des extras peut être correctement
     * défini et récupéré.
     */
    public function testOrdrePassage(): void
    {
        $this->extras->setOrdrePassage("Premier");
        $this->assertEquals("Premier", $this->extras->getOrdrePassage());
    }

    /**
     * Test de la méthode getClausesConfidentialites() et setClausesConfidentialites().
     *
     * Vérifie si les clauses de confidentialité des extras peuvent être correctement
     * définies et récupérées.
     */
    public function testClausesConfidentialites(): void
    {
        $this->extras->setClausesConfidentialites("Confidentiel");
        $this->assertEquals("Confidentiel", $this->extras->getClausesConfidentialites());
    }
}
