<?php

namespace App\DataFixtures;

use App\Entity\Contributor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContributorFixtures extends Fixture implements DependentFixtureInterface
{
    public const CONTRIBUTORSDB = [
        [
            'decision' => 'decision_0',
            'employee' => 'employee_1',
            'implication' => 'implication_1',
            'contributor' => 'contributor_0',
        ],
        [
            'decision' => 'decision_0',
            'employee' => 'employee_2',
            'implication' => 'implication_1',
            'contributor' => 'contributor_1',
        ],
        [
            'decision' => 'decision_0',
            'employee' => 'employee_3',
            'implication' => 'implication_2',
            'contributor' => 'contributor_2',
        ],
        [
            'decision' => 'decision_1',
            'employee' => 'employee_2',
            'implication' => 'implication_2',
            'contributor' => 'contributor_3',
        ],
        [
            'decision' => 'decision_1',
            'employee' => 'employee_3',
            'implication' => 'implication_1',
            'contributor' => 'contributor_4',
        ],
        [
            'decision' => 'decision_2',
            'employee' => 'employee_1',
            'implication' => 'implication_1',
            'contributor' => 'contributor_5',
        ],
        [
            'decision' => 'decision_3',
            'employee' => 'employee_2',
            'implication' => 'implication_2',
            'contributor' => 'contributor_6',
        ],
        [
            'decision' => 'decision_4',
            'employee' => 'employee_3',
            'implication' => 'implication_2',
            'contributor' => 'contributor_7',
        ],
        [
            'decision' => 'decision_5',
            'employee' => 'employee_1',
            'implication' => 'implication_1',
            'contributor' => 'contributor_8',
        ],
        [
            'decision' => 'decision_6',
            'employee' => 'employee_2',
            'implication' => 'implication_1',
            'contributor' => 'contributor_9',
        ],
        [
            'decision' => 'decision_7',
            'employee' => 'employee_3',
            'implication' => 'implication_2',
            'contributor' => 'contributor_10',
        ],
        [
            'decision' => 'decision_8',
            'employee' => 'employee_1',
            'implication' => 'implication_2',
            'contributor' => 'contributor_11',
        ],
        [
            'decision' => 'decision_9',
            'employee' => 'employee_2',
            'implication' => 'implication_2',
            'contributor' => 'contributor_12',
        ],
        [
            'decision' => 'decision_10',
            'employee' => 'employee_3',
            'implication' => 'implication_1',
            'contributor' => 'contributor_13',
        ],
        [
            'decision' => 'decision_11',
            'employee' => 'employee_1',
            'implication' => 'implication_1',
            'contributor' => 'contributor_14',
        ],
        [
            'decision' => 'decision_12',
            'employee' => 'employee_0',
            'implication' => 'implication_1',
            'contributor' => 'contributor_15',
        ],
        [
            'decision' => 'decision_13',
            'employee' => 'employee_0',
            'implication' => 'implication_2',
            'contributor' => 'contributor_16',
        ],
        [
            'decision' => 'decision_14',
            'employee' => 'employee_0',
            'implication' => 'implication_1',
            'contributor' => 'contributor_17',
        ],
        [
            'decision' => 'decision_15',
            'employee' => 'employee_0',
            'implication' => 'implication_2',
            'contributor' => 'contributor_18',
        ],
        [
            'decision' => 'decision_16',
            'employee' => 'employee_0',
            'implication' => 'implication_1',
            'contributor' => 'contributor_19',
        ],
        [
            'decision' => 'decision_17',
            'employee' => 'employee_0',
            'implication' => 'implication_2',
            'contributor' => 'contributor_20',
        ],
        [
            'decision' => 'decision_17',
            'employee' => 'employee_0',
            'implication' => 'implication_1',
            'contributor' => 'contributor_21',
        ],
        [
            'decision' => 'decision_19',
            'employee' => 'employee_0',
            'implication' => 'implication_2',
            'contributor' => 'contributor_22',
        ],
        ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::CONTRIBUTORSDB as $contrib) {
            $contributor = new Contributor();
            $contributor->setEmployee($this->getReference($contrib['employee']));
            $contributor->setDecision($this->getReference($contrib['decision']));
            $contributor->setImplication($this->getReference($contrib['implication']));
            $manager->persist($contributor);
            $this->addReference($contrib['contributor'], $contributor);
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
