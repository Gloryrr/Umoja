<?php

namespace App\Tests\Entity;

use App\Entity\Offre;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité Offre.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité Offre
 * à l'aide de PHPUnit.
 */
class OffreTest extends TestCase
{
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
     * Elle initialise une nouvelle instance de Offre.
     */
    protected function setUp(): void
    {
        $this->offre = new Offre();
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie si l'identifiant d'une offre peut être récupéré.
     */
    public function testGetId()
    {
        $this->assertNull($this->offre->getId());
    }

    /**
     * Test de la méthode getNomArtisteConcerne() et setNomArtisteConcerne().
     *
     * Vérifie si le nom de l'artiste concerné peut être correctement
     * défini et récupéré.
     */
    public function testNomArtisteConcerne()
    {
        $this->offre->setNomArtisteConcerne("Artiste Test");
        $this->assertEquals("Artiste Test", $this->offre->getNomArtisteConcerne());
    }

    /**
     * Test de la méthode getDescrTournee() et setDescrTournee().
     *
     * Vérifie si la description de la tournée peut être correctement
     * définie et récupérée.
     */
    public function testDescrTournee()
    {
        $this->offre->setDescrTournee("Description de la tournée.");
        $this->assertEquals("Description de la tournée.", $this->offre->getDescrTournee());
    }

    /**
     * Test de la méthode setDateMinProposee() et getDateMinProposee().
     *
     * Vérifie si la date minimale proposée peut être correctement
     * définie et récupérée.
     */
    public function testDateMinProposee()
    {
        $date = new \DateTime('2023-01-01');
        $this->offre->setDateMinProposee($date);
        $this->assertEquals($date, $this->offre->getDateMinProposee());
    }

    /**
     * Test de la méthode setDateMaxProposee() et getDateMaxProposee().
     *
     * Vérifie si la date maximale proposée peut être correctement
     * définie et récupérée.
     */
    public function testDateMaxProposee()
    {
        $date = new \DateTime('2023-12-31');
        $this->offre->setDateMaxProposee($date);
        $this->assertEquals($date, $this->offre->getDateMaxProposee());
    }

    /**
     * Test de la méthode getVilleVisee() et setVilleVisee().
     *
     * Vérifie si la ville visée peut être correctement
     * définie et récupérée.
     */
    public function testVilleVisee()
    {
        $this->offre->setVilleVisee("Paris");
        $this->assertEquals("Paris", $this->offre->getVilleVisee());
    }

    /**
     * Test de la méthode getRegionVisee() et setRegionVisee().
     *
     * Vérifie si la région visée peut être correctement
     * définie et récupérée.
     */
    public function testRegionVisee()
    {
        $this->offre->setRegionVisee("Île-de-France");
        $this->assertEquals("Île-de-France", $this->offre->getRegionVisee());
    }

    /**
     * Test de la méthode setPlaceMin() et getPlaceMin().
     *
     * Vérifie si le nombre minimum de places peut être correctement
     * défini et récupéré.
     */
    public function testPlaceMin()
    {
        $this->offre->setPlaceMin(100);
        $this->assertEquals(100, $this->offre->getPlaceMin());
    }

    /**
     * Test de la méthode setPlaceMax() et getPlaceMax().
     *
     * Vérifie si le nombre maximum de places peut être correctement
     * défini et récupéré.
     */
    public function testPlaceMax()
    {
        $this->offre->setPlaceMax(500);
        $this->assertEquals(500, $this->offre->getPlaceMax());
    }

    /**
     * Test de la méthode setDateLimiteReponse() et getDateLimiteReponse().
     *
     * Vérifie si la date limite de réponse peut être correctement
     * définie et récupérée.
     */
    public function testDateLimiteReponse()
    {
        $date = new \DateTime('2023-05-01');
        $this->offre->setDateLimiteReponse($date);
        $this->assertEquals($date, $this->offre->getDateLimiteReponse());
    }

    /**
     * Test de la méthode setValid() et isValid().
     *
     * Vérifie si la validité de l'offre peut être correctement
     * définie et récupérée.
     */
    public function testValid()
    {
        $this->offre->setValid(true);
        $this->assertTrue($this->offre->isValid());

        $this->offre->setValid(false);
        $this->assertFalse($this->offre->isValid());
    }
}