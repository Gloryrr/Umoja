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
        $this->assertNull($this->reponse->getId());
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
     * Test de la méthode getDateDebut() et setDateDebut().
     *
     * Vérifie si la date de début peut être correctement définie et récupérée.
     */
    public function testDateDebut()
    {
        $dateDebut = new \DateTime();
        $this->reponse->setDateDebut($dateDebut);

        $this->assertSame($dateDebut, $this->reponse->getDateDebut());
    }

    /**
     * Test de la méthode getDateFin() et setDateFin().
     *
     * Vérifie si la date de fin peut être correctement définie et récupérée.
     */
    public function testDateFin()
    {
        $dateFin = new \DateTime();
        $this->reponse->setDateFin($dateFin);

        $this->assertSame($dateFin, $this->reponse->getDateFin());
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
     * Test de la méthode setPrixParticipation() avec un prix null.
     *
     * Vérifie si le prix de participation peut être mis à null.
     */
    public function testSetPrixParticipationNull()
    {
        $this->reponse->setPrixParticipation(null);

        $this->assertNull($this->reponse->getPrixParticipation());
    }
}