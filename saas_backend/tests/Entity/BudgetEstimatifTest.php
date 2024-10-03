<?php

namespace App\Tests\Entity;

use App\Entity\BudgetEstimatif;
use App\Entity\Offre;

use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité BudgetEstimatif.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité BudgetEstimatif
 * à l'aide de PHPUnit.
 */
class BudgetEstimatifTest extends TestCase
{
    /**
     * Instance du budget estimatif à tester.
     *
     * @var BudgetEstimatif
     */
    private BudgetEstimatif $budgetEstimatif;

    /**
     * Instance de l'offre à tester.
     *
     * @var Offre
     */
    private Offre $offre;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de BudgetEstimatif.
     */
    protected function setUp(): void
    {
        $this->budgetEstimatif = new BudgetEstimatif();
        $this->offre = new Offre();
    }

    /**
     * Test de la méthode setId() et getId().
     *
     * Vérifie si l'identifiant du budget estimatif peut être correctement
     * défini et récupéré.
     */
    public function testId()
    {
        $this->budgetEstimatif->setId(1);
        $this->assertEquals(1, $this->budgetEstimatif->getId());

    }

    /**
     * Test de la méthode setCachetArtiste() et getCachetArtiste().
     *
     * Vérifie si le montant du cachet de l'artiste peut être correctement
     * défini et récupéré.
     */
    public function testCachetArtiste()
    {
        $this->budgetEstimatif->setCachetArtiste(1500);
        $this->assertEquals(1500, $this->budgetEstimatif->getCachetArtiste());
    }

    /**
     * Test de la méthode setFraisDeplacement() et getFraisDeplacement().
     *
     * Vérifie si le montant des frais de déplacement peut être correctement
     * défini et récupéré.
     */
    public function testFraisDeplacement()
    {
        $this->budgetEstimatif->setFraisDeplacement(300);
        $this->assertEquals(300, $this->budgetEstimatif->getFraisDeplacement());
    }

    /**
     * Test de la méthode setFraisHebergement() et getFraisHebergement().
     *
     * Vérifie si le montant des frais d'hébergement peut être correctement
     * défini et récupéré.
     */
    public function testFraisHebergement()
    {
        $this->budgetEstimatif->setFraisHebergement(800);
        $this->assertEquals(800, $this->budgetEstimatif->getFraisHebergement());
    }

    /**
     * Test de la méthode setFraisRestauration() et getFraisRestauration().
     *
     * Vérifie si le montant des frais de restauration peut être correctement
     * défini et récupéré.
     */
    public function testFraisRestauration()
    {
        $this->budgetEstimatif->setFraisRestauration(200);
        $this->assertEquals(200, $this->budgetEstimatif->getFraisRestauration());
    }

    /**
     * Test de la méthode setOffre() et getOffre().
     *
     * Vérifie si l'offre peut être correctement définie et récupérée.
     */
    public function testOffre()
    {
        $this->budgetEstimatif->setOffre($this->offre);
        $this->assertSame($this->offre, $this->budgetEstimatif->getOffre());
    }
}
