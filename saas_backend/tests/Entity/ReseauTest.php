<?php

namespace App\Tests\Entity;

use App\Entity\Reseau;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité Reseau.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité Reseau
 * à l'aide de PHPUnit.
 */
class ReseauTest extends TestCase
{
    /**
     * Instance du réseau à tester.
     *
     * @var Reseau
     */
    private Reseau $reseau;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de Reseau.
     */
    protected function setUp(): void
    {
        $this->reseau = new Reseau();
    }

    /**
     * Test de la méthode setNomReseau() et getNomReseau().
     *
     * Vérifie si le nom d'un réseau peut être correctement
     * défini et récupéré.
     */
    public function testNomReseau()
    {
        $this->reseau->setNomReseau("Réseau Local");
        $this->assertEquals("Réseau Local", $this->reseau->getNomReseau());

        $this->reseau->setNomReseau("Réseau Global");
        $this->assertEquals("Réseau Global", $this->reseau->getNomReseau());
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie que l'identifiant est null par défaut avant
     * toute génération.
     */
    public function testGetIdInitial()
    {
        $this->assertNull($this->reseau->getId());
    }

    /**
     * Test de la méthode getId() après assignation.
     *
     * Vérifie que l'identifiant peut être défini et récupéré correctement.
     */
    public function testGetId()
    {
        // Utilisation de reflection pour accéder à l'attribut privé
        $reflection = new \ReflectionClass($this->reseau);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($this->reseau, 1);

        $this->assertEquals(1, $this->reseau->getId());
    }
}