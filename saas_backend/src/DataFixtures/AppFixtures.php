<?php

namespace App\DataFixtures;

use App\Entity\EtatOffre;
use App\Entity\TypeOffre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use App\Entity\GenreMusical;
use App\Entity\PreferenceNotification;
use App\Entity\EtatReponse;

class AppFixtures extends Fixture
{
    public function load(
        ObjectManager $manager,
    ): void {
        // Préférences de notification
        $preferenceNotification = new PreferenceNotification();

        // Utilisateurs
        $admin = new Utilisateur();
        $admin->setEmailUtilisateur($_ENV['MAIL_UMOJA']);
        $admin->setMdpUtilisateur("admin_umoja");
        $admin->setUsername("admin_umoja");
        $admin->setRoles("ROLE_ADMIN");
        $admin->setPreferenceNotification($preferenceNotification);

        $manager->persist($admin);

        // États de réponse
        $etatReponseEnAttente = $this->createEtatReponse(
            "En Attente",
            "Indique que la proposition n'a pas été validée"
        );
        $etatReponseValidee = $this->createEtatReponse(
            "Validée",
            "Indique que la proposition a été validée par l'utilisateur"
        );
        $etatReponseRefusee = $this->createEtatReponse(
            "Refusée",
            "Indique que la proposition a été refusée par l'utilisateur"
        );

        $manager->persist($etatReponseEnAttente);
        $manager->persist($etatReponseValidee);
        $manager->persist($etatReponseRefusee);

        // États d'offre
        $etatOffreEnCours = $this->createEtatOffre("En Cours");
        $etatOffreTerminee = $this->createEtatOffre("Terminée");

        $manager->persist($etatOffreEnCours);
        $manager->persist($etatOffreTerminee);

        // Types d'offre
        $typeOffreTournee = $this->createTypeOffre("Tournée");
        $typeOffreConcert = $this->createTypeOffre("Concert");

        $manager->persist($typeOffreTournee);
        $manager->persist($typeOffreConcert);

        // Genres musicaux
        $genresMusicaux = [
            "Pop", "Rock", "Hip-hop", "Jazz", "Classique",
            "Blues", "Électro", "Reggae", "Country", "Folk",
            "Soul", "R&B", "Métal", "Punk", "Disco",
            "Ska", "Trap", "House", "Techno", "Latino"
        ];

        foreach ($genresMusicaux as $nomGenre) {
            $genreMusical = $this->createGenreMusical($nomGenre);
            $manager->persist($genreMusical);
        }

        // Persist and flush
        $manager->flush();
    }

    public function createEtatReponse(string $etatReponse, string $descriptionEtatReponse): EtatReponse
    {
        $etatReponseObject = new EtatReponse();
        $etatReponseObject->setNomEtatReponse($etatReponse);
        $etatReponseObject->setDescriptionEtatReponse($descriptionEtatReponse);

        return $etatReponseObject;
    }

    public function createEtatOffre(string $etatOffre)
    {
        $etatOffreObject = new EtatOffre();
        $etatOffreObject->setNomEtat($etatOffre);

        return $etatOffreObject;
    }

    public function createTypeOffre(string $typeOffre)
    {
        $typeOffreObject = new TypeOffre();
        $typeOffreObject->setNomTypeOffre($typeOffre);

        return $typeOffreObject;
    }

    public function createGenreMusical(string $nomGenreMusical): GenreMusical
    {
        $genreMusical = new GenreMusical();
        $genreMusical->setNomGenreMusical($nomGenreMusical);

        return $genreMusical;
    }
}
