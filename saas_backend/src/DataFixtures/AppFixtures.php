<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use App\Entity\GenreMusical;
use App\Entity\Reseau;
use App\Entity\Artiste;

class AppFixtures extends Fixture
{
    public function load(
        ObjectManager $manager, 
    ): void {
        // données fictives d'entrées pour un test fonctionnel de l'API
        $rock = $this->createGenreMusical('Rock');
        $pop = $this->createGenreMusical('Pop');

        $artiste = $this->createArtiste();

        $reseau = $this->createReseau('Facebook');
        $reseau2 = $this->createReseau('Instagram');
        $reseau3 = $this->createReseau('Twitter');

        $user = $manager->getRepository(Utilisateur::class)->findOneBy([]);

        if ($user === null) {
            throw new \Exception("Aucun utilisateur trouvé dans la base de données.");
        }

        $user->addGenreMusical($rock);
        $user->addGenreMusical($pop);
        $user->addReseau($reseau);
        $user->addReseau($reseau2);
        $user->addReseau($reseau3);

        $manager->persist($rock);
        $manager->persist($pop);
        $manager->persist($artiste);
        $manager->persist($reseau);
        $manager->persist($reseau2);
        $manager->persist($reseau3);
        $manager->persist($user);
        $manager->flush();
    }

    public function createArtiste(): Artiste
    {
        $artiste = new Artiste();
        $artiste->setNomArtiste("Nekfeu");
        $artiste->setDescrArtiste("Nekfeu, de son vrai nom Ken Samaras, né le 3 avril 1990 à La Trinité, dans les Alpes-Maritimes, est un rappeur, acteur et producteur français.");

        return $artiste;
    }

    public function createGenreMusical(string $nomGenreMusical): GenreMusical
    {
        $genreMusical = new GenreMusical();
        $genreMusical->setNomGenreMusical($nomGenreMusical);

        return $genreMusical;
    }

    public function createReseau(string $nomReseau) : Reseau
    {
        $reseau = new Reseau();
        $reseau->setNomReseau($nomReseau);

        return $reseau;
    }
}
