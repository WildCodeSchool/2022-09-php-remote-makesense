<?php

namespace App\DataFixtures;

use App\Entity\Contributor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContributorFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $contributor = new Contributor();

            $contributor->setEmployee($this->getReference('employee_' . $faker->numberBetween(0, 9)));
            $contributor->setDecision($this->getReference('decision_0'));
            $contributor->setImplication($this->getReference('implication_' . $faker->numberBetween(1, 2)));

            $manager->persist($contributor);
            $this->addReference('contributor_' . $i, $contributor);
        }
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            DecisionFixtures::class,
            EmployeeFixtures::class,
            ImplicationFixtures::class,
        ];
    }
}
