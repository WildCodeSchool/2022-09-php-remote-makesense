<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EmployeeFixtures extends Fixture
{
    public const EMPLOYEESDB = [
        [
            'firstname' => 'Norbert',
            'lastname' => 'Huel',
            'email' => 'norbert.huel@makesense.com',
        ],
        [
            'firstname' => 'Alex',
            'lastname' => 'Delmhot',
            'email' => 'alex.delmhot@makesense.com',
        ],
        [
            'firstname' => 'Axel',
            'lastname' => 'Cruiser',
            'email' => 'axel.cruiser@makesense.com',
        ],
        [
            'firstname' => 'Meg',
            'lastname' => 'Peeloon',
            'email' => 'meg.peeloon@makesense.com',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::EMPLOYEESDB as $key => $empl) {
            $employee = new Employee();
            $employee->setFirstname($empl['firstname']);
            $employee->setLastName($empl['lastname']);
            $employee->setEmail($empl['email']);
            $manager->persist($employee);
            $this->addReference('employee_' . $key, $employee);
        }
        $faker = Factory::create();
        for ($i = 4; $i <= 20; $i++) {
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
