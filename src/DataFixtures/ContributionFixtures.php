<?php

namespace App\DataFixtures;

use App\Entity\Contribution;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContributionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $type =  ['conflit', 'avis'];

        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $contribution = new Contribution();

            $contribution->setType($type[array_rand($type, 1)]);
            $contribution->setDate($faker->dateTime());
            $contribution->setContent($faker->sentences('3', true));
            $contribution->setDecision($this->getReference('decision_' . $faker->numberBetween(0, 9)));
            $contribution->setContributor($this->getReference('contributor_' . $faker->numberBetween(0, 9)));
            $manager->persist($contribution);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            DecisionFixtures::class,
            ContributorFixtures::class,
        ];
    }
}
