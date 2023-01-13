<?php

namespace App\DataFixtures;

use App\Entity\Decision;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DecisionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 21; $i++) {
            $decision = new Decision();
            $decision->setTitle($faker->words(3, true));
            $decision->setContent($faker->paragraphs(6, true));
            $decision->setUtility($faker->paragraphs(6, true));
            $decision->setContext($faker->paragraphs(6, true));
            $decision->setBenefits($faker->paragraphs(6, true));
            $decision->setInconvenients($faker->paragraph(6));
            $decision->setUser($this->getReference('user_0'));
            $manager->persist($decision);
            $this->addReference('decision_' . $i, $decision);
        }

        for ($i = 21; $i < 41; $i++) {
            $decision = new Decision();
            $decision->setTitle($faker->words(3, true));
            $decision->setContent($faker->paragraphs(6, true));
            $decision->setUtility($faker->paragraphs(6, true));
            $decision->setContext($faker->paragraphs(6, true));
            $decision->setBenefits($faker->paragraphs(6, true));
            $decision->setInconvenients($faker->paragraph(6));
            $decision->setFirstDecision($faker->paragraph(6));
            $decision->setDefinitiveDecision($faker->paragraph(6));
            $decision->setUser($this->getReference('user_' . $faker->numberBetween(1, 9)));
            $manager->persist($decision);
            $this->addReference('decision_' . $i, $decision);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
