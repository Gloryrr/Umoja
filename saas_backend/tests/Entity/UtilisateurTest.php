<?php

namespace App\Tests\Entity;

use App\Entity\Utilisateur;
use PHPUnit\Framework\TestCase;

class UtilisateurTest extends TestCase
{
    private Utilisateur $utilisateur;

    protected function setUp(): void
    {
        $this->utilisateur = new Utilisateur();
    }

    public function testIdUtilisateur()
    {
        $this->utilisateur->setIdUtilisateur(1);
        $this->assertEquals(1, $this->utilisateur->getIdUtilisateur());
    }

    public function testEmailUtilisateur()
    {
        $this->utilisateur->setEmailUtilisateur("test@example.com");
        $this->assertEquals("test@example.com", $this->utilisateur->getEmailUtilisateur());
    }

    public function testMdpUtilisateur()
    {
        $this->utilisateur->setMdpUtilisateur("password123");
        $this->assertEquals("password123", $this->utilisateur->getMdpUtilisateur());
    }

    public function testRoleUtilisateur()
    {
        $this->utilisateur->setRoleUtilisateur("ROLE_USER");
        $this->assertEquals("ROLE_USER", $this->utilisateur->getRoleUtilisateur());
    }

    public function testUsername()
    {
        $this->utilisateur->setUsername("Steven");
        $this->assertEquals("Steven", $this->utilisateur->getUsername());
    }

    public function testNumTelUtilisateur()
    {
        $this->utilisateur->setNumTelUtilisateur("0123456789");
        $this->assertEquals("0123456789", $this->utilisateur->getNumTelUtilisateur());
    }

    public function testNomUtilisateur()
    {
        $this->utilisateur->setNomUtilisateur("Marmion");
        $this->assertEquals("Marmion", $this->utilisateur->getNomUtilisateur());
    }

    public function testPrenomUtilisateur()
    {
        $this->utilisateur->setPrenomUtilisateur("Steven");
        $this->assertEquals("Steven", $this->utilisateur->getPrenomUtilisateur());
    }
}