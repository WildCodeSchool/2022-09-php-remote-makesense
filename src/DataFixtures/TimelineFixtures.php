<?php

namespace App\DataFixtures;

use App\Entity\Timeline;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TimelineFixtures extends Fixture implements DependentFixtureInterface
{
    public const CALENDAR = [
        [
            'name' => 'Prise de décision commencée',
            'startedAt' => '2023-01-01 09:23:05',
            'endedAt' => '2023-01-01 09:23:05',
            'decision' => 'decision_0',
        ],
        [
            'name' => 'Deadline pour donner son avis',
            'startedAt' => '2023-01-20 09:23:05',
            'endedAt' => '2023-02-15 09:23:05',
            'decision' => 'decision_0',
        ],
        [
            'name' => 'Première décision prise',
            'startedAt' => '2023-02-15 09:23:05',
            'endedAt' => '2023-02-20 09:23:05',
            'decision' => 'decision_0',
        ],
        [
            'name' => 'Deadline pour entrer en conflit',
            'startedAt' => '2023-02-20 09:23:05',
            'endedAt' => '2023-02-25 09:23:05',
            'decision' => 'decision_0',
        ],
        [
            'name' => 'Décision définitive',
            'startedAt' => '2023-02-25 09:23:05',
            'endedAt' => '2023-03-01 09:23:05',
            'decision' => 'decision_0',
        ],
        [
            'name' => 'Prise de décision commencée',
            'startedAt' => '2022-12-15 09:23:05',
            'endedAt' => '2023-12-15 09:23:05',
            'decision' => 'decision_1',
        ],
        [
            'name' => 'Deadline pour donner son avis',
            'startedAt' => '2023-12-15 09:23:05',
            'endedAt' => '2023-01-10 09:23:05',
            'decision' => 'decision_1',
        ],
        [
            'name' => 'Première décision prise',
            'startedAt' => '2023-01-10 09:23:05',
            'endedAt' => '2023-02-15 09:23:05',
            'decision' => 'decision_1',
        ],
        [
            'name' => 'Deadline pour entrer en conflit',
            'startedAt' => '2023-02-15 09:23:05',
            'endedAt' => '2023-02-25 09:23:05',
            'decision' => 'decision_1',
        ],
        [
            'name' => 'Décision définitive',
            'startedAt' => '2023-02-25 09:23:05',
            'endedAt' => '2023-03-01 09:23:05',
            'decision' => 'decision_1',
        ],

        [
            'name' => 'Prise de décision commencée',
            'startedAt' => '2022-12-15 09:23:05',
            'endedAt' => '2023-12-15 09:23:05',
            'decision' => 'decision_2',
        ],
        [
            'name' => 'Deadline pour donner son avis',
            'startedAt' => '2023-12-15 09:23:05',
            'endedAt' => '2023-01-10 09:23:05',
            'decision' => 'decision_2',
        ],
        [
            'name' => 'Première décision prise',
            'startedAt' => '2023-01-10 09:23:05',
            'endedAt' => '2023-01-20 09:23:05',
            'decision' => 'decision_2',
        ],
        [
            'name' => 'Deadline pour entrer en conflit',
            'startedAt' => '2023-01-20 09:23:05',
            'endedAt' => '2023-02-15 09:23:05',
            'decision' => 'decision_2',
        ],
        [
            'name' => 'Décision définitive',
            'startedAt' => '2023-02-15 09:23:05',
            'endedAt' => '2023-02-25 09:23:05',
            'decision' => 'decision_2',
        ],
        [
            'name' => 'Prise de décision commencée',
            'startedAt' => '2022-12-15 09:23:05',
            'endedAt' => '2023-12-15 09:23:05',
            'decision' => 'decision_3',
        ],
        [
            'name' => 'Deadline pour donner son avis',
            'startedAt' => '2023-12-15 09:23:05',
            'endedAt' => '2023-01-10 09:23:05',
            'decision' => 'decision_3',
        ],
        [
            'name' => 'Première décision prise',
            'startedAt' => '2023-01-10 09:23:05',
            'endedAt' => '2023-01-15 09:23:05',
            'decision' => 'decision_3',
        ],
        [
            'name' => 'Deadline pour entrer en conflit',
            'startedAt' => '2023-01-15 09:23:05',
            'endedAt' => '2023-01-20 09:23:05',
            'decision' => 'decision_3',
        ],
        [
            'name' => 'Décision définitive',
            'startedAt' => '2023-01-20 09:23:05',
            'endedAt' => '2023-02-15 09:23:05',
            'decision' => 'decision_3',
        ],
        [
            'name' => 'Prise de décision commencée',
            'startedAt' => '2022-01-15 09:23:05',
            'endedAt' => '2023-01-15 09:23:05',
            'decision' => 'decision_4',
        ],
        [
            'name' => 'Deadline pour donner son avis',
            'startedAt' => '2023-01-15 09:23:05',
            'endedAt' => '2023-02-15 09:23:05',
            'decision' => 'decision_4',
        ],
        [
            'name' => 'Première décision prise',
            'startedAt' => '2023-02-15 09:23:05',
            'endedAt' => '2023-02-25 09:23:05',
            'decision' => 'decision_4',
        ],
        [
            'name' => 'Deadline pour entrer en conflit',
            'startedAt' => '2023-02-25 09:23:05',
            'endedAt' => '2023-03-01 09:23:05',
            'decision' => 'decision_4',
        ],
        [
            'name' => 'Décision définitive',
            'startedAt' => '2023-03-01 09:23:05',
            'endedAt' => '2023-03-15 09:23:05',
            'decision' => 'decision_4',
        ],
        [
            'name' => 'Prise de décision commencée',
            'startedAt' => '2022-01-17 09:23:05',
            'endedAt' => '2023-01-17 09:23:05',
            'decision' => 'decision_5',
        ],
        [
            'name' => 'Deadline pour donner son avis',
            'startedAt' => '2023-01-17 09:23:05',
            'endedAt' => '2023-02-17 09:23:05',
            'decision' => 'decision_5',
        ],
        [
            'name' => 'Première décision prise',
            'startedAt' => '2023-02-17 09:23:05',
            'endedAt' => '2023-02-25 09:23:05',
            'decision' => 'decision_5',
        ],
        [
            'name' => 'Deadline pour entrer en conflit',
            'startedAt' => '2023-02-25 09:23:05',
            'endedAt' => '2023-03-01 09:23:05',
            'decision' => 'decision_5',
        ],
        [
            'name' => 'Décision définitive',
            'startedAt' => '2023-03-01 09:23:05',
            'endedAt' => '2023-03-15 09:23:05',
            'decision' => 'decision_5',
        ],
        [
            'name' => 'Prise de décision commencée',
            'startedAt' => '2022-01-20 09:23:05',
            'endedAt' => '2023-01-20 09:23:05',
            'decision' => 'decision_6',
        ],
        [
            'name' => 'Deadline pour donner son avis',
            'startedAt' => '2023-01-20 09:23:05',
            'endedAt' => '2023-02-15 09:23:05',
            'decision' => 'decision_6',
        ],
        [
            'name' => 'Première décision prise',
            'startedAt' => '2023-02-15 09:23:05',
            'endedAt' => '2023-02-25 09:23:05',
            'decision' => 'decision_6',
        ],
        [
            'name' => 'Deadline pour entrer en conflit',
            'startedAt' => '2023-02-25 09:23:05',
            'endedAt' => '2023-02-28 09:23:05',
            'decision' => 'decision_6',
        ],
        [
            'name' => 'Décision définitive',
            'startedAt' => '2023-02-28 09:23:05',
            'endedAt' => '2023-03-15 09:23:05',
            'decision' => 'decision_6',
        ],
        [
            'name' => 'Prise de décision commencée',
            'startedAt' => '2022-01-22 09:23:05',
            'endedAt' => '2023-01-22 09:23:05',
            'decision' => 'decision_7',
        ],
        [
            'name' => 'Deadline pour donner son avis',
            'startedAt' => '2023-01-22 09:23:05',
            'endedAt' => '2023-02-15 09:23:05',
            'decision' => 'decision_7',
        ],
        [
            'name' => 'Première décision prise',
            'startedAt' => '2023-02-15 09:23:05',
            'endedAt' => '2023-02-25 09:23:05',
            'decision' => 'decision_7',
        ],
        [
            'name' => 'Deadline pour entrer en conflit',
            'startedAt' => '2023-02-25 09:23:05',
            'endedAt' => '2023-03-01 09:23:05',
            'decision' => 'decision_7',
        ],
        [
            'name' => 'Décision définitive',
            'startedAt' => '2023-03-01 09:23:05',
            'endedAt' => '2023-03-15 09:23:05',
            'decision' => 'decision_7',
        ],
        [
            'name' => 'Prise de décision commencée',
            'startedAt' => '2023-01-01 09:23:05',
            'endedAt' => '2023-01-01 09:23:05',
            'decision' => 'decision_8',
        ],
        [
            'name' => 'Deadline pour donner son avis',
            'startedAt' => '2023-01-01 09:23:05',
            'endedAt' => '2023-01-15 09:23:05',
            'decision' => 'decision_8',
        ],
        [
            'name' => 'Première décision prise',
            'startedAt' => '2023-01-15 09:23:05',
            'endedAt' => '2023-02-15 09:23:05',
            'decision' => 'decision_8',
        ],
        [
            'name' => 'Deadline pour entrer en conflit',
            'startedAt' => '2023-02-15 09:23:05',
            'endedAt' => '2023-02-20 09:23:05',
            'decision' => 'decision_8',
        ],
        [
            'name' => 'Décision définitive',
            'startedAt' => '2023-02-20 09:23:05',
            'endedAt' => '2023-03-15 09:23:05',
            'decision' => 'decision_8',
        ],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::CALENDAR as $step) {
            $timeline = new Timeline();
            $timeline->setName($step['name']);
            $timeline->setStartedAt(new datetime($step['startedAt']));
            $timeline->setEndedAt(new datetime($step['endedAt']));
            $timeline->setDecision($this->getReference($step['decision']));
            $manager->persist($timeline);
        }

        $faker = Factory::create();

        for ($i = 9; $i < 15; $i++) {
            $timeline = new Timeline();
            $timeline->setName('Prise de décision commencée');
            $date = $faker->dateTimeBetween('-20 days', '-10 days');
            $timeline->setStartedAt($date);
            $timeline->setEndedAt($date);
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);

            $timeline = new Timeline();
            $timeline->setName('Deadline pour donner son avis');
            $timeline->setStartedAt($date);
            $date2 = $faker->dateTimeBetween('-9 days', '-3 days');
            $timeline->setEndedAt($date2);
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);

            $timeline = new Timeline();
            $timeline->setName('Première décision prise');
            $timeline->setStartedAt($date2);
            $date3 = $faker->dateTimeBetween('+1 day', '+10 days');
            $timeline->setEndedAt($date3);
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);

            $timeline = new Timeline();
            $timeline->setName('Deadline pour entrer en conflit');
            $timeline->setStartedAt($date3);
            $date4 = $faker->dateTimeInInterval('+11 days', '+20 days');
            $timeline->setEndedAt($date4);
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);

            $timeline = new Timeline();
            $timeline->setName('Décision définitive');
            $timeline->setStartedAt($date4);
            $timeline->setEndedAt($faker->dateTimeInInterval('+21 days', '+28 days'));
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);
        }
        for ($i = 15; $i < 20; $i++) {
            $timeline = new Timeline();
            $timeline->setName('Prise de décision commencée');
            $date = $faker->dateTimeBetween('-20 days', '-10 days');
            $timeline->setStartedAt($date);
            $timeline->setEndedAt($date);
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);

            $timeline = new Timeline();
            $timeline->setName('Deadline pour donner son avis');
            $timeline->setStartedAt($date);
            $date2 = $faker->dateTimeBetween('-9 days', '-5 days');
            $timeline->setEndedAt($date2);
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);

            $timeline = new Timeline();
            $timeline->setName('Première décision prise');
            $timeline->setStartedAt($date2);
            $date3 = $faker->dateTimeBetween('-4 days', '-2 days');
            $timeline->setEndedAt($date3);
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);

            $timeline = new Timeline();
            $timeline->setName('Deadline pour entrer en conflit');
            $timeline->setStartedAt($date3);
            $date4 = $faker->dateTimeInInterval('+1 day', '+20 days');
            $timeline->setEndedAt($date4);
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);

            $timeline = new Timeline();
            $timeline->setName('Décision définitive');
            $timeline->setStartedAt($date4);
            $timeline->setEndedAt($faker->dateTimeInInterval('+21 days', '+28 days'));
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            DecisionFixtures::class,
            ];
    }
}
