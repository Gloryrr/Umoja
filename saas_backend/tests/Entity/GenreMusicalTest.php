<?php

namespace App\Tests\Entity;

use App\Entity\GenreMusical;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité GenreMusical.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité GenreMusical
 * à l'aide de PHPUnit.
 */
class GenreMusicalTest extends TestCase
{
    /**
     * Instance du genre musical à tester.
     *
     * @var GenreMusical
     */
    private GenreMusical $genreMusical;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de GenreMusical.
     */
    protected function setUp(): void
    {
        $this->genreMusical = new GenreMusical();
    }

    /**
     * Test de la méthode setNomGenreMusical() et getNomGenreMusical().
     *
     * Vérifie si le nom d'un genre musical peut être correctement
     * défini et récupéré.
     */
    public function testNomGenreMusical()
    {
        $this->genreMusical->setNomGenreMusical("Rock");
        $this->assertEquals("Rock", $this->genreMusical->getNomGenreMusical());
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie que l'identifiant est null par défaut avant
     * toute génération.
     */
    public function testGetIdInitial()
    {
        $this->assertNull($this->genreMusical->getId());
    }

    /**
     * Test de la méthode getId() après assignation.
     *
     * Vérifie que l'identifiant peut être défini et récupéré correctement.
     */
    public function testGetId()
    {
        // Utilisation de reflection pour accéder à l'attribut privé
        $reflection = new \ReflectionClass($this->genreMusical);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($this->genreMusical, 1);

        $this->assertEquals(1, $this->genreMusical->getId());
    }
}