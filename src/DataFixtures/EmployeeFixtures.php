<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class EmployeeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++) {
            $employee = new Employee();

            $employee->setFirstname($faker->firstName());
            $employee->setLastname($faker->lastName());
            $employee->setEmail($faker->email());

            $manager->persist($employee);
        }
        $manager->flush();
    }
}
