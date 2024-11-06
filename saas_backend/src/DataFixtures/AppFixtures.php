<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use App\Entity\GenreMusical;
use App\Entity\Reseau;
use App\Entity\Appartenir;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // données fictives d'entrées pour un test fonctionnel de l'API
        $user = $this->createUtilisateur();
        $manager->persist($user);
        $manager->flush();

        $manager->persist($this->createGenreMusical('Rock'));
        $manager->flush();
        $manager->persist($this->createGenreMusical('Pop'));
        $manager->flush();

        $reseau = $this->createReseau();
        $manager->persist($reseau);
        $manager->flush();

        $manager->persist($this->createAppartenance($user, $reseau));
        $manager->flush();
    }

    public function createUtilisateur(): Utilisateur
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setEmailUtilisateur("test@example.com");
        $utilisateur->setMdpUtilisateur("mot-de-passe-hashé");
        $utilisateur->setNumTelUtilisateur("0607080904");
        $utilisateur->setRoles("ADMIN:USER");
        $utilisateur->setNomUtilisateur("Fontaine");
        $utilisateur->setPrenomUtilisateur("Jean");
        $utilisateur->setUsername("username n° 1");

        return $utilisateur;
    }

    public function createGenreMusical(string $nomGenreMusical): GenreMusical
    {
        $genreMusical = new GenreMusical();
        $genreMusical->setNomGenreMusical($nomGenreMusical);

        return $genreMusical;
    }

    public function createReseau()
    {
        $reseau = new Reseau();
        $reseau->setNomReseau("Facebook");

        return $reseau;
    }

    public function createAppartenance(Utilisateur $user, Reseau $reseau): Appartenir
    {
        $appartenir = new Appartenir();
        $appartenir->setIdReseau($reseau);
        $appartenir->setIdUtilisateur($user);

        return $appartenir;
    }
}
