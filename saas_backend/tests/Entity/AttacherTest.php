<?php

namespace App\Tests\Entity;

use App\Entity\Attacher;
use App\Entity\Artiste;
use App\Entity\GenreMusical;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité Attacher.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité Attacher
 * à l'aide de PHPUnit.
 */
class AttacherTest extends TestCase
{
    /**
     * Instance de Attacher à tester.
     *
     * @var Attacher
     */
    private Attacher $attacher;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de Attacher.
     */
    protected function setUp(): void
    {
        $this->attacher = new Attacher();
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie si l'identifiant de Attacher peut être récupéré.
     */
    public function testGetId()
    {
        $this->assertNull($this->attacher->getId());
    }

    /**
     * Test de la méthode getIdArtiste() et setIdArtiste().
     *
     * Vérifie si l'artiste peut être correctement
     * défini et récupéré.
     */
    public function testIdArtiste()
    {
        $artiste = new Artiste();
        $this->attacher->setIdArtiste($artiste);
        $this->assertSame($artiste, $this->attacher->getIdArtiste());
    }

    /**
     * Test de la méthode getGenresAttaches() et setGenresAttaches().
     *
     * Vérifie si le genre musical peut être correctement
     * défini et récupéré.
     */
    public function testGenresAttaches()
    {
        $genre = new GenreMusical();
        $this->attacher->setGenresAttaches($genre);
        $this->assertSame($genre, $this->attacher->getGenresAttaches());
    }
}
