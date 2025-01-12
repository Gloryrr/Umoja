<?php

namespace App\Tests\Entity;

use App\Entity\Utilisateur;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité Utilisateur.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité Utilisateur
 * à l'aide de PHPUnit.
 */
class UtilisateurTest extends TestCase
{
    /**
     * Instance de l'utilisateur à tester.
     *
     * @var Utilisateur
     */
    private Utilisateur $utilisateur;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de Utilisateur.
     */
    protected function setUp(): void
    {
        $this->utilisateur = new Utilisateur();
    }

    /**
     * Test de la méthode setId() et getId().
     *
     * Vérifie si l'identifiant d'un utilisateur peut être correctement
     * défini et récupéré.
     */
    public function testIdUtilisateur()
    {
        $this->utilisateur->setId(1);
        $this->assertEquals(1, $this->utilisateur->getId());
    }

    /**
     * Test de la méthode setEmailUtilisateur() et getEmailUtilisateur().
     *
     * Vérifie si l'email d'un utilisateur peut être correctement
     * défini et récupéré.
     */
    public function testEmailUtilisateur()
    {
        $this->utilisateur->setEmailUtilisateur("test@example.com");
        $this->assertEquals("test@example.com", $this->utilisateur->getEmailUtilisateur());
    }

    /**
     * Test de la méthode setMdpUtilisateur() et getMdpUtilisateur().
     *
     * Vérifie si le mot de passe d'un utilisateur peut être correctement
     * défini et récupéré.
     */
    public function testMdpUtilisateur()
    {
        $this->utilisateur->setMdpUtilisateur("password123");
        $this->assertEquals("password123", $this->utilisateur->getPassword());
    }

    /**
     * Test de la méthode setRoleUtilisateur() et getRoleUtilisateur().
     *
     * Vérifie si le rôle d'un utilisateur peut être correctement
     * défini et récupéré.
     */
    public function testRoleUtilisateur()
    {
        $this->utilisateur->setRoles("USER");
        $this->assertEquals(["USER"], $this->utilisateur->getRoles());
    }

    /**
     * Test de la méthode setUsername() et getUsername().
     *
     * Vérifie si le nom d'utilisateur peut être correctement
     * défini et récupéré.
     */
    public function testUsername()
    {
        $this->utilisateur->setUsername("username_particulier");
        $this->assertEquals("username_particulier", $this->utilisateur->getUsername());
    }

    /**
     * Test de la méthode setNumTelUtilisateur() et getNumTelUtilisateur().
     *
     * Vérifie si le numéro de téléphone d'un utilisateur peut être
     * correctement défini et récupéré.
     */
    public function testNumTelUtilisateur()
    {
        $this->utilisateur->setNumTelUtilisateur("0123456789");
        $this->assertEquals("0123456789", $this->utilisateur->getNumTelUtilisateur());
    }

    /**
     * Test de la méthode setNomUtilisateur() et getNomUtilisateur().
     *
     * Vérifie si le nom d'un utilisateur peut être correctement
     * défini et récupéré.
     */
    public function testNomUtilisateur()
    {
        $this->utilisateur->setNomUtilisateur("Fontaine");
        $this->assertEquals("Fontaine", $this->utilisateur->getNomUtilisateur());
    }

    /**
     * Test de la méthode setPrenomUtilisateur() et getPrenomUtilisateur().
     *
     * Vérifie si le prénom d'un utilisateur peut être correctement
     * défini et récupéré.
     */
    public function testPrenomUtilisateur()
    {
        $this->utilisateur->setPrenomUtilisateur("Jean");
        $this->assertEquals("Jean", $this->utilisateur->getPrenomUtilisateur());
    }
}