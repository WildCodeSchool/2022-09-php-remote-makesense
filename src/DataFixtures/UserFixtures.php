<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public const USERSDB = [
        [
            'email' => 'norbert.huel@makesense.com',
            'firstname' => 'Norbert',
            'lastname' => 'Huel',
            'createdAt' => '2023-01-01 09:23:05',
        ],
        [
            'email' => 'alex.deelmhot@makesense.com',
            'firstname' => 'Alex',
            'lastname' => 'Delmhot',
            'createdAt' => '2023-01-02 09:23:05',
        ],
        [
            'email' => 'axel.cruiser@makesense.com',
            'firstname' => 'Axel',
            'lastname' => 'Cruiser',
            'createdAt' => '2023-01-03 09:23:05',
        ],
        [
            'email' => 'meg.peeloon@makesense.com',
            'firstname' => 'Meg',
            'lastname' => 'Peeloon',
            'createdAt' => '2023-01-04 09:23:05',
        ],
    ];


    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERSDB as $key => $userEmp) {
            $user = new user();
            $user -> setEmail($userEmp['email']);
            $user -> setFirstName($userEmp['firstname']);
            $user -> setLastName($userEmp['lastname']);
            $user -> setCreatedAt(new DateTimeImmutable($userEmp['createdAt']));
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                'simpleUserPassword'
            );
            $user -> setPassword($hashedPassword);
            $user -> setEmployee($this -> getReference('employee_' . $key));
            $manager->persist($user);
            $this->addReference('user_' . $key, $user);
        }

        // Création d’un utilisateur de type administrateur
        $admin = new User();
        $admin->setEmail('admin@makesense.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setFirstName('admin');
        $admin->setLastName('admin');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'adminPassword'
        );
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);
        $this->addReference('admin', $admin);

        // Création de fixtures de Users simples
        $faker = Factory::create();
        for ($i = 0; $i < 5; $i++) {
            $user = new user();
            $user->setEmail($faker->email());
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user -> setCreatedAt(new DateTimeImmutable('2023-01-04 09:23:05'));
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                'simpleUserPassword'
            );
            $user->setPassword($hashedPassword);
            $user -> setEmployee($this -> getReference('employee_' . ($i + 4)));
            $manager->persist($user);
            $this->addReference('user_' . ($i + 4), $user);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            EmployeeFixtures::class,
        ];
    }
}
