<?php

namespace App\Tests\Entity;

use App\Entity\EtatOffre;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité EtatOffre.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité EtatOffre
 * à l'aide de PHPUnit.
 */
class EtatOffreTest extends TestCase
{
    /**
     * Instance de l'état d'offre à tester.
     *
     * @var EtatOffre
     */
    private EtatOffre $etatOffre;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de EtatOffre.
     */
    protected function setUp(): void
    {
        $this->etatOffre = new EtatOffre();
    }

    /**
     * Test de la méthode setNomEtat() et getNomEtat().
     *
     * Vérifie si le nom d'un état d'offre peut être correctement
     * défini et récupéré.
     */
    public function testNomEtat()
    {
        $this->etatOffre->setNomEtat("En cours");
        $this->assertEquals("En cours", $this->etatOffre->getNomEtat());

        $this->etatOffre->setNomEtat("Terminé");
        $this->assertEquals("Terminé", $this->etatOffre->getNomEtat());
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie que l'identifiant est null par défaut avant
     * toute génération.
     */
    public function testGetIdInitial()
    {
        $this->assertNull($this->etatOffre->getId());
    }

    /**
     * Test de la méthode getId() après assignation.
     *
     * Vérifie que l'identifiant peut être défini et récupéré correctement.
     */
    public function testGetId()
    {
        // Utilisation de reflection pour accéder à l'attribut privé
        $reflection = new \ReflectionClass($this->etatOffre);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($this->etatOffre, 1);

        $this->assertEquals(1, $this->etatOffre->getId());
    }
}