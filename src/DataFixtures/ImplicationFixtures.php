<?php

namespace App\DataFixtures;

use App\Entity\Implication;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImplicationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $implication = new Implication();
        $implication->setName('Impactée');
        $manager->persist($implication);
        $this->addReference('implication_1', $implication);

        $implication = new Implication();
        $implication->setName('Experte');
        $manager->persist($implication);
        $this->addReference('implication_2', $implication);

        $manager->flush();
    }
}
