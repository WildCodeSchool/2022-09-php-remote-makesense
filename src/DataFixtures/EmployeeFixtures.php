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
        $employee = new Employee();
        $employee->setFirstname('Norbert');
        $employee->setLastname('Huel');
        $employee->setEmail('conn.rubie@tillman.com');
        $manager->persist($employee);
        $this->addReference('employee_0', $employee);

        $faker = Factory::create();

        for ($i = 1; $i < 50; $i++) {
            $employee = new Employee();

            $employee->setFirstname($faker->firstName());
            $employee->setLastname($faker->lastName());
            $employee->setEmail($faker->email());

            $manager->persist($employee);

            $this->addReference('employee_' . $i, $employee);
        }
        $manager->flush();
    }
}
