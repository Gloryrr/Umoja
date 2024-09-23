<?php


namespace App\Tests;

use App\Entity\Personne;
use PHPUnit\Framework\TestCase;

class PersonneTest extends TestCase
{
    public function testSetNameAndGetName()
    {
        $personne = new Personne();
        $personne->setName("Steven Marmion");
        $this->assertEquals("Steven Marmion", $personne->getName());

        $personne->setName("Inconnu au bataillon");
        $this->assertEquals("Inconnu au bataillon", $personne->getName());
    }

    public function testGetId()
    {
        $personne = new Personne();
        $this->assertNull($personne->getId());
    }

    public function testNameIsNullable()
    {
        $personne = new Personne();
        $this->assertNull($personne->getName());
    }
}