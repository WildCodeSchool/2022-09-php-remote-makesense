<?php

namespace App\DataFixtures;

use App\Entity\Decision;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DecisionFixtures extends Fixture implements DependentFixtureInterface
{
    public const DESCRIPTION = [
        [
            'title' => 'Déménager à Milan',
            'content' => 'Toute ma famille est à Milan. Je dois me déplacer continuellement.
            Je souhaiterais travailler en remote depuis mon logement à Milan',
            'utility' => 'Je gagnerai en efficacité et en temps de trajet.',
            'context' => 'les collegues avec qui je travaille sont aussi à l\'étranger',
            'benefits' => 'Je gagnerai en efficacité et en temps de trajet. L\organisation du travail sera facilitée
            pour tout le monde',
            'inconvenients' => 'Il y aura moins de réunion en physique mais je peux tout de même maintenir un trajet
            par mois',
        ],
    ];
    public function load(ObjectManager $manager): void
    {
        foreach (self::DESCRIPTION as $description) {
            $decision = new Decision();
            $decision->setTitle($description['title']);
            $decision->setContent($description['content']);
            $decision->setUtility($description['utility']);
            $decision->setContext($description['context']);
            $decision->setBenefits($description['benefits']);
            $decision->setInconvenients($description['inconvenients']);
            $decision->setUser($this->getReference('user_0'));
            $manager->persist($decision);
            $this->addReference('decision_0', $decision);
        }
        $faker = Factory::create();
        for ($i = 0; $i < 11; $i++) {
            $decision = new Decision();
            $decision->setTitle($faker->words(3, true));
            $decision->setContent($faker->paragraphs(6, true));
            $decision->setUtility($faker->paragraphs(6, true));
            $decision->setContext($faker->paragraphs(6, true));
            $decision->setBenefits($faker->paragraphs(6, true));
            $decision->setInconvenients($faker->paragraph(6));
            $decision->setUser($this->getReference('user_0'));
            $manager->persist($decision);
            $this->addReference('decision_' . ($i + 1), $decision);
        }

        for ($i = 12; $i < 15; $i++) {
            $decision = new Decision();
            $decision->setTitle($faker->words(3, true));
            $decision->setContent($faker->paragraphs(6, true));
            $decision->setUtility($faker->paragraphs(6, true));
            $decision->setContext($faker->paragraphs(6, true));
            $decision->setBenefits($faker->paragraphs(6, true));
            $decision->setInconvenients($faker->paragraph(6));
            $decision->setUser($this->getReference('user_1'));
            $manager->persist($decision);
            $this->addReference('decision_' . $i, $decision);
        }
        for ($i = 2; $i < 7; $i++) {
            $decision = new Decision();
            $decision->setTitle($faker->words(3, true));
            $decision->setContent($faker->paragraphs(6, true));
            $decision->setUtility($faker->paragraphs(6, true));
            $decision->setContext($faker->paragraphs(6, true));
            $decision->setBenefits($faker->paragraphs(6, true));
            $decision->setInconvenients($faker->paragraph(6));
            $decision->setUser($this->getReference('user_' . $i));
            $manager->persist($decision);
            $this->addReference('decision_' . ($i + 13), $decision);
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
