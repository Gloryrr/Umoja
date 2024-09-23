<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Test;
use App\Entity\Personne;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // for ($i=0 ; $i<10 ; $i++) {
        //     $test = new Test;
        //     $test->setName("Test numéro : " . $i);
        //     $manager->persist($test);
        // }

        for ($i=0 ; $i<10 ; $i++) {
            $personne = new Personne;
            $personne->setName("Personne numéro : " . $i);
            $manager->persist($personne);
        }

        $manager->flush();
    }
}
