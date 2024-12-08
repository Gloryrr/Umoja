<?php

namespace App\Tests\Entity;

use App\Entity\ConditionsFinancieres;
use App\Entity\Offre;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité ConditionsFinancieres.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité ConditionsFinancieres
 * à l'aide de PHPUnit.
 */
class ConditionsFinancieresTest extends TestCase
{
    /**
     * Instance de ConditionsFinancieres à tester.
     *
     * @var ConditionsFinancieres
     */
    private ConditionsFinancieres $conditionsFinancieres;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de ConditionsFinancieres.
     */
    protected function setUp(): void
    {
        $this->conditionsFinancieres = new ConditionsFinancieres();
    }

    /**
     * Test de la méthode setId() et getId().
     *
     * Vérifie si l'identifiant des conditions financières peut être
     * correctement défini et récupéré.
     */
    public function testIdCF()
    {
        $this->conditionsFinancieres->setId(0);
        $this->assertEquals(0, $this->conditionsFinancieres->getId());
    }

    /**
     * Test de la méthode setMinimunGaranti() et getMinimunGaranti().
     *
     * Vérifie si le montant minimum garanti peut être correctement
     * défini et récupéré.
     */
    public function testMinimunGaranti()
    {
        $this->conditionsFinancieres->setMinimunGaranti(5000);
        $this->assertEquals(5000, $this->conditionsFinancieres->getMinimunGaranti());
    }

    /**
     * Test de la méthode setConditionsPaiement() et getConditionsPaiement().
     *
     * Vérifie si les conditions de paiement peuvent être correctement
     * définies et récupérées.
     */
    public function testConditionsPaiement()
    {
        $conditions = "Paiement sous 30 jours après facturation.";
        $this->conditionsFinancieres->setConditionsPaiement($conditions);
        $this->assertEquals($conditions, $this->conditionsFinancieres->getConditionsPaiement());
    }

    /**
     * Test de la méthode setPourcentageRecette() et getPourcentageRecette().
     *
     * Vérifie si le pourcentage de recette peut être correctement
     * défini et récupéré.
     */
    public function testPourcentageRecette()
    {
        $this->conditionsFinancieres->setPourcentageRecette(12.5);
        $this->assertEquals(12.5, $this->conditionsFinancieres->getPourcentageRecette());
    }
}
