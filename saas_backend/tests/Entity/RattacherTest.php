<?php

namespace App\Tests\Entity;

use App\Entity\Rattacher;
use App\Entity\Offre;
use App\Entity\GenreMusical;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité Rattacher.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité Rattacher
 * à l'aide de PHPUnit.
 */
class RattacherTest extends TestCase
{
    /**
     * Instance de Rattacher à tester.
     *
     * @var Rattacher
     */
    private Rattacher $rattacher;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de Rattacher.
     */
    protected function setUp(): void
    {
        $this->rattacher = new Rattacher();
    }

    /**
     * Test de la méthode getIdA().
     *
     * Vérifie si l'identifiant de Rattacher peut être récupéré.
     */
    public function testGetIdA()
    {
        $this->assertNull($this->rattacher->getIdA());
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
        $this->rattacher->setIdOffre($offre);
        $this->assertSame($offre, $this->rattacher->getIdOffre());
    }

    /**
     * Test de la méthode getIdGenreMusical() et setIdGenreMusical().
     *
     * Vérifie si le genre musical peut être correctement
     * défini et récupéré.
     */
    public function testIdGenreMusical()
    {
        $genre = new GenreMusical();
        $this->rattacher->setIdGenreMusical($genre);
        $this->assertSame($genre, $this->rattacher->getIdGenreMusical());
    }
}
