<?php

namespace App\Tests\Entity;

use App\Entity\Commentaire;
use App\Entity\Utilisateur;
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
     * Instance du commentaire à tester.
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
     * Vérifie si l'identifiant d'un commentaire peut être récupéré.
     */
    public function testGetIdCommentaire()
    {
        $this->assertNull($this->commentaire->getIdCommentaire());
    }

    /**
     * Test de la méthode setCommentaire() et getCommentaire().
     *
     * Vérifie si le texte du commentaire peut être correctement
     * défini et récupéré.
     */
    public function testCommentaire()
    {
        $this->commentaire->setCommentaire("Ceci est un commentaire.");
        $this->assertEquals("Ceci est un commentaire.", $this->commentaire->getCommentaire());
    }

    /**
     * Test de la méthode getIdUtilisateur() et setIdUtilisateur().
     *
     * Vérifie si l'utilisateur associé à un commentaire peut être
     * correctement défini et récupéré.
     */
    public function testIdUtilisateur()
    {
        $utilisateur = new Utilisateur(); // Simulez un objet Utilisateur.

        $this->commentaire->setIdUtilisateur($utilisateur);
        $this->assertEquals($utilisateur, $this->commentaire->getIdUtilisateur());
    }

    /**
     * Test du comportement lorsque l'utilisateur est nul.
     *
     * Vérifie que la méthode getIdUtilisateur() retourne null
     * lorsqu'aucun utilisateur n'est associé.
     */
    public function testIdUtilisateurNull()
    {
        $this->assertNull($this->commentaire->getIdUtilisateur());
    }
}