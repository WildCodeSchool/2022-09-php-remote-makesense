<?php

namespace App\DataFixtures;

use App\Entity\Timeline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TimelineFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 41; $i++) {
            $timeline = new Timeline();
            $timeline->setName('Prise de décision commencée');
            $date = $faker->dateTimeInInterval('-1 week', '+6 days');
            $timeline->setStartedAt($date);
            $timeline->setEndedAt($date);
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);

            $timeline = new Timeline();
            $timeline->setName('Deadline pour donner son avis');
            $timeline->setStartedAt($date);
            $date2 = $faker->dateTimeInInterval('+2 weeks', '+1 day');
            $timeline->setEndedAt($date2);
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);

            $timeline = new Timeline();
            $timeline->setName('Première décision prise');
            $timeline->setStartedAt($date2);
            $date3 = $faker->dateTimeInInterval('+3 weeks', '+1 day');
            $timeline->setEndedAt($date3);
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);

            $timeline = new Timeline();
            $timeline->setName('Deadline pour entrer en conflit');
            $timeline->setStartedAt($date3);
            $date4 = $faker->dateTimeInInterval('+5 weeks', '+1 day');
            $timeline->setEndedAt($date4);
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);

            $timeline = new Timeline();
            $timeline->setName('Décision définitive');
            $timeline->setStartedAt($date4);
            $timeline->setEndedAt($faker->dateTimeInInterval('+7 weeks', '+1 day'));
            $timeline->setDecision($this->getReference('decision_' . $i));
            $manager->persist($timeline);
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
