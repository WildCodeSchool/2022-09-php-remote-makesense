<?php

namespace App\DataFixtures;

use App\Entity\Decision;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DecisionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $decision = new Decision();

            $decision->setTitle($faker->title());
            $decision->setContent($faker->paragraphs(6, true));
            $decision->setUtility($faker->paragraphs(6, true));
            $decision->setContext($faker->paragraphs(6, true));
            $decision->setBenefits($faker->paragraphs(6, true));
            $decision->setInconvenients($faker->paragraph(6));

            $manager->persist($decision);
        }
        $manager->flush();
    }
}
