<?php

namespace App\Tests\Entity;

use App\Entity\Reponse;
use App\Entity\EtatReponse;
use App\Entity\Offre;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité Reponse.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité Reponse
 * à l'aide de PHPUnit.
 */
class ReponseTest extends TestCase
{
    /**
     * Instance de la réponse à tester.
     *
     * @var Reponse
     */
    private Reponse $reponse;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de Reponse.
     */
    protected function setUp(): void
    {
        $this->reponse = new Reponse();
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie si l'identifiant d'une réponse peut être récupéré.
     */
    public function testGetId()
    {
        $this->reponse->setId(0);
        $this->assertEquals(0, $this->reponse->getId());
    }

    /**
     * Test de la méthode getEtatReponse() et setEtatReponse().
     *
     * Vérifie si l'état d'une réponse peut être correctement défini et récupéré.
     */
    public function testEtatReponse()
    {
        $etatReponse = new EtatReponse();
        $this->reponse->setEtatReponse($etatReponse);

        $this->assertSame($etatReponse, $this->reponse->getEtatReponse());
    }

    /**
     * Test de la méthode getOffre() et setOffre().
     *
     * Vérifie si l'offre associée à une réponse peut être correctement définie et récupérée.
     */
    public function testOffre()
    {
        $offre = new Offre();
        $this->reponse->setOffre($offre);

        $this->assertSame($offre, $this->reponse->getOffre());
    }

    /**
     * Test de la méthode getPrixParticipation() et setPrixParticipation().
     *
     * Vérifie si le prix de participation peut être correctement défini et récupéré.
     */
    public function testPrixParticipation()
    {
        $prixParticipation = 150.50;
        $this->reponse->setPrixParticipation($prixParticipation);

        $this->assertEquals($prixParticipation, $this->reponse->getPrixParticipation());
    }
    /**
        * Test de la méthode getNomSalleFestival() et setNomSalleFestival().
        *
        * Vérifie si le nom de la salle de festival peut être correctement défini et récupéré.
        */
    public function testNomSalleFestival()
    {
        $nomSalleFestival = "Salle A";
        $this->reponse->setNomSalleFestival($nomSalleFestival);

        $this->assertEquals($nomSalleFestival, $this->reponse->getNomSalleFestival());
    }

    /**
        * Test de la méthode getNomSalleConcert() et setNomSalleConcert().
        *
        * Vérifie si le nom de la salle de concert peut être correctement défini et récupéré.
        */
    public function testNomSalleConcert()
    {
        $nomSalleConcert = "Salle B";
        $this->reponse->setNomSalleConcert($nomSalleConcert);

        $this->assertEquals($nomSalleConcert, $this->reponse->getNomSalleConcert());
    }

    /**
        * Test de la méthode getVille() et setVille().
        *
        * Vérifie si la ville peut être correctement définie et récupérée.
        */
    public function testVille()
    {
        $ville = "Paris";
        $this->reponse->setVille($ville);

        $this->assertEquals($ville, $this->reponse->getVille());
    }

    /**
        * Test de la méthode getDatesPossible() et setDatesPossible().
        *
        * Vérifie si les dates possibles peuvent être correctement définies et récupérées.
        */
    public function testDatesPossible()
    {
        $datesPossible = "2023-12-01";
        $this->reponse->setDatesPossible($datesPossible);

        $this->assertEquals($datesPossible, $this->reponse->getDatesPossible());
    }

    /**
        * Test de la méthode getCapacite() et setCapacite().
        *
        * Vérifie si la capacité peut être correctement définie et récupérée.
        */
    public function testCapacite()
    {
        $capacite = 500;
        $this->reponse->setCapacite($capacite);

        $this->assertEquals($capacite, $this->reponse->getCapacite());
    }

    /**
        * Test de la méthode getDeadline() et setDeadline().
        *
        * Vérifie si la date limite peut être correctement définie et récupérée.
        */
    public function testDeadline()
    {
        $deadline = new \DateTime('2023-12-31');
        $this->reponse->setDeadline($deadline);

        $this->assertEquals($deadline, $this->reponse->getDeadline());
    }

    /**
        * Test de la méthode getDureeShow() et setDureeShow().
        *
        * Vérifie si la durée du show peut être correctement définie et récupérée.
        */
    public function testDureeShow()
    {
        $dureeShow = "2 hours";
        $this->reponse->setDureeShow($dureeShow);

        $this->assertEquals($dureeShow, $this->reponse->getDureeShow());
    }

    /**
        * Test de la méthode getMontantCachet() et setMontantCachet().
        *
        * Vérifie si le montant du cachet peut être correctement défini et récupéré.
        */
    public function testMontantCachet()
    {
        $montantCachet = 1000;
        $this->reponse->setMontantCachet($montantCachet);

        $this->assertEquals($montantCachet, $this->reponse->getMontantCachet());
    }

    /**
        * Test de la méthode getDeviseCachet() et setDeviseCachet().
        *
        * Vérifie si la devise du cachet peut être correctement définie et récupérée.
        */
    public function testDeviseCachet()
    {
        $deviseCachet = "EUR";
        $this->reponse->setDeviseCachet($deviseCachet);

        $this->assertEquals($deviseCachet, $this->reponse->getDeviseCachet());
    }

    /**
        * Test de la méthode getExtras() et setExtras().
        *
        * Vérifie si les extras peuvent être correctement définis et récupérés.
        */
    public function testExtras()
    {
        $extras = "Sound system";
        $this->reponse->setExtras($extras);

        $this->assertEquals($extras, $this->reponse->getExtras());
    }

    /**
        * Test de la méthode getCoutExtras() et setCoutExtras().
        *
        * Vérifie si le coût des extras peut être correctement défini et récupéré.
        */
    public function testCoutExtras()
    {
        $coutExtras = 200;
        $this->reponse->setCoutExtras($coutExtras);

        $this->assertEquals($coutExtras, $this->reponse->getCoutExtras());
    }

    /**
        * Test de la méthode getOrdrePassage() et setOrdrePassage().
        *
        * Vérifie si l'ordre de passage peut être correctement défini et récupéré.
        */
    public function testOrdrePassage()
    {
        $ordrePassage = "First";
        $this->reponse->setOrdrePassage($ordrePassage);

        $this->assertEquals($ordrePassage, $this->reponse->getOrdrePassage());
    }

    /**
        * Test de la méthode getConditionsGenerales() et setConditionsGenerales().
        *
        * Vérifie si les conditions générales peuvent être correctement définies et récupérées.
        */
    public function testConditionsGenerales()
    {
        $conditionsGenerales = "No smoking";
        $this->reponse->setConditionsGenerales($conditionsGenerales);

        $this->assertEquals($conditionsGenerales, $this->reponse->getConditionsGenerales());
    }
}