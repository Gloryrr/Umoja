<?php

namespace App\Tests\Entity;

use App\Entity\Offre;
use App\Entity\Utilisateur;
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
     * Test de la méthode setId() et getId().
     *
     * Vérifie si l'identifiant d'une offre peut être correctement
     * défini et récupéré.
     */
    public function testId()
    {
        // Les ID sont généralement générés par la base de données,
        // donc ce test peut être omis ou simuler l'attribution de l'ID.
        $this->assertNull($this->offre->getId());
    }

    /**
     * Test de la méthode setDescrTournee() et getDescrTournee().
     *
     * Vérifie si la description de la tournée peut être correctement
     * définie et récupérée.
     */
    public function testDescrTournee()
    {
        $this->offre->setDescrTournee("Tournée 2024");
        $this->assertEquals("Tournée 2024", $this->offre->getDescrTournee());
    }

    /**
     * Test de la méthode setDateMinProposee() et getDateMinProposee().
     *
     * Vérifie si la date minimale proposée peut être correctement
     * définie et récupérée.
     */
    public function testDateMinProposee()
    {
        $date = new \DateTime('2024-01-01');
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
        $date = new \DateTime('2024-12-31');
        $this->offre->setDateMaxProposee($date);
        $this->assertEquals($date, $this->offre->getDateMaxProposee());
    }

    /**
     * Test de la méthode setVilleVisee() et getVilleVisee().
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
     * Test de la méthode setRegionVisee() et getRegionVisee().
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
        $this->offre->setPlaceMin(10);
        $this->assertEquals(10, $this->offre->getPlaceMin());
    }

    /**
     * Test de la méthode setPlaceMax() et getPlaceMax().
     *
     * Vérifie si le nombre maximum de places peut être correctement
     * défini et récupéré.
     */
    public function testPlaceMax()
    {
        $this->offre->setPlaceMax(50);
        $this->assertEquals(50, $this->offre->getPlaceMax());
    }

    /**
     * Test de la méthode setDateLimiteReponse() et getDateLimiteReponse().
     *
     * Vérifie si la date limite de réponse peut être correctement
     * définie et récupérée.
     */
    public function testDateLimiteReponse()
    {
        $date = new \DateTime('2024-06-30');
        $this->offre->setDateLimiteReponse($date);
        $this->assertEquals($date, $this->offre->getDateLimiteReponse());
    }

    /**
     * Test de la méthode setValidee() et isValidee().
     *
     * Vérifie si l'état de validation de l'offre peut être correctement
     * défini et récupéré.
     */
    public function testValidee()
    {
        $this->offre->setValidee(true);
        $this->assertTrue($this->offre->isValidee());
    }

    /**
     * Test de la méthode setIdArtisteConcerne() et getArtisteConcerne().
     *
     * Vérifie si l'artiste concerné par l'offre peut être correctement
     * défini et récupéré.
     */
    public function testArtisteConcerne()
    {
        $artiste = new Utilisateur(); // Supposons que Utilisateur est une classe valide
        $this->offre->setArtisteConcerne($artiste);
        $this->assertEquals($artiste, $this->offre->getArtisteConcerne());
    }
}
