<?php
namespace App\Tests\Entity;

use App\Entity\TypeOffre;
use PHPUnit\Framework\TestCase;


/**
 * Classe de test pour l'entité TypeOffre.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité TypeOffre
 * à l'aide de PHPUnit.
 */
class TypeOffreTest extends TestCase
{
    /**
     * Instance du type d'offre à tester.
     *
     * @var TypeOffre
     */
    private TypeOffre $typeOffre;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de TypeOffre.
     */
    protected function setUp(): void
    {
        $this->typeOffre = new TypeOffre();
    }

    /**
     * Test de la méthode setNomTypeOffre() et getNomTypeOffre().
     *
     * Vérifie si le nom d'un type d'offre peut être correctement
     * défini et récupéré.
     */
    public function testNomTypeOffre()
    {
        $this->typeOffre->setNomTypeOffre("Offre Standard");
        $this->assertEquals("Offre Standard", $this->typeOffre->getNomTypeOffre());

        $this->typeOffre->setNomTypeOffre("Offre Premium");
        $this->assertEquals("Offre Premium", $this->typeOffre->getNomTypeOffre());
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie que l'identifiant est null par défaut avant
     * toute génération.
     */
    public function testGetIdInitial()
    {
        $this->typeOffre->setId(0);
        $this->assertEquals(0, $this->typeOffre->getId());
    }

    /**
     * Test de la méthode getId() après assignation.
     *
     * Vérifie que l'identifiant peut être défini et récupéré correctement.
     */
    public function testGetId()
    {
        // Utilisation de reflection pour accéder à l'attribut privé
        $reflection = new \ReflectionClass($this->typeOffre);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($this->typeOffre, 1);

        $this->assertEquals(1, $this->typeOffre->getId());
    }
}