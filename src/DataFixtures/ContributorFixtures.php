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
        $contributor = new Contributor();
        $contributor->setEmployee($this->getReference('employee_0'));
        $contributor->setDecision($this->getReference('decision_5'));
        $contributor->setImplication($this->getReference('implication_1'));
        $manager->persist($contributor);
        $this->addReference('contributor_0', $contributor);

        $contributor = new Contributor();
        $contributor->setEmployee($this->getReference('employee_0'));
        $contributor->setDecision($this->getReference('decision_6'));
        $contributor->setImplication($this->getReference('implication_2'));
        $manager->persist($contributor);
        $this->addReference('contributor_1', $contributor);

        $faker = Factory::create();
        for ($i = 0; $i < 13; $i++) {
            $contributor = new Contributor();
            $contributor->setEmployee($this->getReference('employee_0'));
            $contributor->setDecision($this->getReference('decision_' . ($i + 21)));

            $contributor->setImplication($this->getReference('implication_' . $faker->numberBetween(1, 2)));
            $manager->persist($contributor);
            $this->addReference('contributor_' . ($i + 2), $contributor);
        }


        for ($i = 0; $i < 41; $i++) {
            $contributor = new Contributor();
            $contributor->setEmployee($this->getReference('employee_' . ($i + 1)));
            $contributor->setDecision($this->getReference('decision_' . $i));
            $contributor->setImplication($this->getReference('implication_' . $faker->numberBetween(1, 2)));
            $manager->persist($contributor);
            $this->addReference('contributor_' . ($i + 15), $contributor);
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
