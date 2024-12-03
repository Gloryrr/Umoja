<?php

namespace App\Tests\Entity;

use App\Entity\Commentaire;
use App\Entity\Utilisateur;
use App\Entity\Offre;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité Commentaire.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité Commentaire
 * à l'aide de PHPUnit.
 */
class CommentaireTest extends TestCase
{
    /**
     * Instance de Commentaire à tester.
     *
     * @var Commentaire
     */
    private Commentaire $commentaire;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de Commentaire.
     */
    protected function setUp(): void
    {
        $this->commentaire = new Commentaire();
    }

    /**
     * Test de la méthode getIdCommentaire().
     *
     * Vérifie si l'identifiant de Commentaire peut être récupéré.
     */
    public function testGetId()
    {
        $this->assertEquals(0, $this->commentaire->getId());
    }

    /**
     * Test de la méthode getCommentaire() et setCommentaire().
     *
     * Vérifie si le commentaire peut être correctement
     * défini et récupéré.
     */
    public function testCommentaire()
    {
        $texteCommentaire = "Un excellent commentaire";
        $this->commentaire->setCommentaire($texteCommentaire);
        $this->assertSame($texteCommentaire, $this->commentaire->getCommentaire());
    }

    /**
     * Test de la méthode getUtilisateur() et setIdUtilisateur().
     *
     * Vérifie si l'utilisateur peut être correctement
     * défini et récupéré.
     */
    public function testUtilisateur()
    {
        $utilisateur = new Utilisateur();
        $this->commentaire->setUtilisateur($utilisateur);
        $this->assertSame($utilisateur, $this->commentaire->getUtilisateur());
    }

    /**
     * Test de la méthode getOffre() et setIdOffre().
     *
     * Vérifie si l'offre peut être correctement
     * définie et récupérée.
     */
    public function testIdOffre()
    {
        $offre = new Offre();
        $this->commentaire->setOffre($offre);
        $this->assertSame($offre, $this->commentaire->getOffre());
    }
}
