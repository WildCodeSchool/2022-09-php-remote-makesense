<?php

namespace App\DataFixtures;

use App\Entity\Contribution;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContributionFixtures extends Fixture implements DependentFixtureInterface
{
    public const CONTRIBUTIONSDB = [
        [
            'type' => 'avis',
            'date' => '2023-01-21 09:23:05',
            'content' => 'Excellente idée',
            'decision' => 'decision_0',
            'contributor' => 'contributor_0',
        ],
        [
            'type' => 'avis',
            'date' => '2023-01-22 09:23:05',
            'content' => 'Cela risque des complications',
            'decision' => 'decision_0',
            'contributor' => 'contributor_1',
        ],
        [
            'type' => 'avis',
            'date' => '2023-01-20 09:23:05',
            'content' => 'Il fait bien analyser tous les tenants et aboutissants',
            'decision' => 'decision_0',
            'contributor' => 'contributor_2',
        ],
        [
            'type' => 'avis',
            'date' => '2022-12-20 09:23:05',
            'content' => 'Il faut mesurer les conséquences financières',
            'decision' => 'decision_1',
            'contributor' => 'contributor_3',
        ],
        [
            'type' => 'conflit',
            'date' => '2023-01-21 09:23:05',
            'content' => 'Cela va poser des problèmes d\'organisation',
            'decision' => 'decision_2',
            'contributor' => 'contributor_5',
        ],
        [
            'type' => 'avis',
            'date' => '2023-01-20 09:23:05',
            'content' => 'Je suis pour ce type de changement',
            'decision' => 'decision_4',
            'contributor' => 'contributor_7',
        ],
        [
            'type' => 'avis',
            'date' => '2023-01-15 09:23:05',
            'content' => 'Excellente idée',
            'decision' => 'decision_10',
            'contributor' => 'contributor_13',
        ],

        [
            'type' => 'avis',
            'date' => '2023-01-16 09:23:05',
            'content' => 'Excellente idée',
            'decision' => 'decision_11',
            'contributor' => 'contributor_14',
        ],
        [
            'type' => 'avis',
            'date' => '2023-01-14 09:23:05',
            'content' => 'Excellente idée, je suis convaincu.',
            'decision' => 'decision_12',
            'contributor' => 'contributor_15',
        ],
        [
            'type' => 'avis',
            'date' => '2023-01-15 09:23:05',
            'content' => 'Je pense que cela aidera les bénévoles',
            'decision' => 'decision_14',
            'contributor' => 'contributor_17',
        ],
        [
            'type' => 'conflit',
            'date' => '2023-01-21 09:23:05',
            'content' => 'Je te déconseille cela. En effet, des tensions risquent de survenir.',
            'decision' => 'decision_15',
            'contributor' => 'contributor_18',
        ],
        [
            'type' => 'conflit',
            'date' => '2023-01-21 09:23:05',
            'content' => 'Cela risque d\être très compliqué.',
            'decision' => 'decision_16',
            'contributor' => 'contributor_19',
        ],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::CONTRIBUTIONSDB as $contributionDB) {
            $contribution = new Contribution();
            $contribution->setType($contributionDB['type']);
            $contribution->setDate(new datetime($contributionDB['date']));
            $contribution->setContent($contributionDB['content']);
            $contribution->setDecision($this->getReference($contributionDB['decision']));
            $contribution->setContributor($this->getReference($contributionDB['contributor']));
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
