<?php

namespace App\Tests\Entity;

use App\Entity\EtatReponse;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité EtatReponse.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité EtatReponse
 * à l'aide de PHPUnit.
 */
class EtatReponseTest extends TestCase
{
    /**
     * Instance de EtatReponse à tester.
     *
     * @var EtatReponse
     */
    private EtatReponse $etatReponse;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de EtatReponse.
     */
    protected function setUp(): void
    {
        $this->etatReponse = new EtatReponse();
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie si l'identifiant de EtatReponse peut être récupéré.
     */
    public function testGetId()
    {
        $this->assertEquals(0, $this->etatReponse->getId());
    }

    /**
     * Test de la méthode getNomEtatReponse() et setNomEtatReponse().
     *
     * Vérifie si le nom de l'état de réponse peut être correctement
     * défini et récupéré.
     */
    public function testNomEtatReponse()
    {
        $nom = "Nom Test";
        $this->etatReponse->setNomEtatReponse($nom);
        $this->assertSame($nom, $this->etatReponse->getNomEtatReponse());
    }

    /**
     * Test de la méthode getDescriptionEtatReponse() et setDescriptionEtatReponse().
     *
     * Vérifie si la description de l'état de réponse peut être correctement
     * définie et récupérée.
     */
    public function testDescriptionEtatReponse()
    {
        $description = "Description de test";
        $this->etatReponse->setDescriptionEtatReponse($description);
        $this->assertSame($description, $this->etatReponse->getDescriptionEtatReponse());
    }
}