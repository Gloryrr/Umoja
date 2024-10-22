<?php

namespace App\Tests\Entity;

use App\Entity\Creer;
use App\Entity\Utilisateur;
use App\Entity\Offre;
use PHPUnit\Framework\TestCase;

/**
 * Classe de test pour l'entité Creer.
 *
 * Vérifie le bon fonctionnement des méthodes de l'entité Creer
 * à l'aide de PHPUnit.
 */
class CreerTest extends TestCase
{
    /**
     * Instance de Creer à tester.
     *
     * @var Creer
     */
    private Creer $creer;

    /**
     * Préparation de l'environnement de test.
     *
     * Cette méthode est exécutée avant chaque test.
     * Elle initialise une nouvelle instance de Creer.
     */
    protected function setUp(): void
    {
        $this->creer = new Creer();
    }

    /**
     * Test de la méthode getId().
     *
     * Vérifie si l'identifiant de Creer peut être récupéré.
     * Comme il n'est pas défini, il doit retourner null.
     */
    public function testGetId()
    {
        $this->assertNull($this->creer->getId());
    }

    /**
     * Test de la méthode getIdUtilisateur() et setIdUtilisateur().
     *
     * Vérifie si un utilisateur peut être correctement défini
     * et récupéré dans l'instance Creer.
     */
    public function testIdUtilisateur()
    {
        $utilisateur = new Utilisateur();
        $this->creer->setIdUtilisateur($utilisateur);
        $this->assertSame($utilisateur, $this->creer->getIdUtilisateur());
    }

    /**
     * Test de la méthode getIdOffre() et setIdOffre().
     *
     * Vérifie si une offre peut être correctement définie
     * et récupérée dans l'instance Creer.
     */
    public function testIdOffre()
    {
        $offre = new Offre();
        $this->creer->setIdOffre($offre);
        $this->assertSame($offre, $this->creer->getIdOffre());
    }

    /**
     * Test de la méthode getContact() et setContact().
     *
     * Vérifie si le contact peut être correctement défini
     * et récupéré dans l'instance Creer.
     */
    public function testContact()
    {
        $contact = 'contact@example.com';
        $this->creer->setContact($contact);
        $this->assertSame($contact, $this->creer->getContact());
    }
}
