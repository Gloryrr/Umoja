<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Test;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // for ($i=0 ; $i<10 ; $i++) {
        //     $test = new Test;
        //     $test->setName("Test numéro : " . $i);
        //     $manager->persist($test);
        // }

        $manager->flush();
    }
}
