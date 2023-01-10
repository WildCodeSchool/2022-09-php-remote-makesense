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

        for ($i = 0; $i < 5; $i++) {
            $contribution = new Contribution();
            $contribution->setType($type[array_rand($type, 1)]);
            $contribution->setDate($faker->dateTime());
            $contribution->setContent($faker->sentences('3', true));
            $contribution->setDecision($this->getReference('decision_' . $i));
            $contribution->setContributor($this->getReference('contributor_' . ($i + 2)));
            $manager->persist($contribution);
        }
        $contribution = new Contribution();
        $contribution->setType('avis');
        $contribution->setDate($faker->dateTime());
        $contribution->setContent($faker->sentences('3', true));
        $contribution->setDecision($this->getReference('decision_5'));
        $contribution->setContributor($this->getReference('contributor_0'));
        $manager->persist($contribution);

        $contribution = new Contribution();
        $contribution->setType('avis');
        $contribution->setDate($faker->dateTime());
        $contribution->setContent($faker->sentences('3', true));
        $contribution->setDecision($this->getReference('decision_6'));
        $contribution->setContributor($this->getReference('contributor_1'));
        $manager->persist($contribution);



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
