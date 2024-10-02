<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Utilisateur;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // données fictives d'entrées pour un test fonctionnel de l'API
        //for ($i = 0; $i < 10; $i++) {
            $utilisateur = new Utilisateur();
            $utilisateur->setEmailUtilisateur("test@example.com");
            $utilisateur->setMdpUtilisateur("mot-de-passe-hashé");
            $utilisateur->setNumTelUtilisateur("0607080904");
            $utilisateur->setRoleUtilisateur("ADMIN:USER");
            $utilisateur->setNomUtilisateur("Fontaine");
            $utilisateur->setPrenomUtilisateur("Jean");
            $utilisateur->setUsername("username n° 1");
            $manager->persist($utilisateur);
        //}

        $manager->flush();
    }
}
