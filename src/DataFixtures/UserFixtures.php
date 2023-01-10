<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        // Création d’un utilisateur de type user simple
        $simpleUser = new User();
        $simpleUser->setEmail('conn.rubie@tillman.com');
        $simpleUser->setFirstName('Norbert');
        $simpleUser->setLastName('Huel');
        $simpleUser->setLogin('Norbert');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $simpleUser,
            'simpleUserPassword'
        );
        $simpleUser->setPassword($hashedPassword);
        $manager->persist($simpleUser);
        $this->addReference('user_' . 0, $simpleUser);

        // Création d’un utilisateur de type user simple
        $simpleUser = new User();
        $simpleUser->setEmail('sibyl.grimes@weissnat.com');
        $simpleUser->setFirstName('Boyd');
        $simpleUser->setLastName('O\'Reilly');
        $simpleUser->setLogin('Boyd');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $simpleUser,
            'simpleUserPassword'
        );
        $simpleUser->setPassword($hashedPassword);
        $manager->persist($simpleUser);
        $this->addReference('user_' . 1, $simpleUser);

        // Création d’un utilisateur de type administrateur
        $admin = new User();
        $admin->setEmail('jasmin77@hotmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setFirstName('Rudy');
        $admin->setLastName('Bednar');
        $admin->setLogin('Rudy');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'adminPassword'
        );
        $admin->setPassword($hashedPassword);
        $manager->persist($admin);
        $this->addReference('user_' . 2, $simpleUser);

        // Création de fixtures de Users simples

        for ($i = 3; $i < 10; $i++) {
            $simpleUser = new user();
            $simpleUser->setEmail($faker->email());
            $simpleUser->setFirstname($faker->firstName());
            $simpleUser->setLastname($faker->lastName());
            $simpleUser->setLogin($faker->firstName());
            $hashedPassword = $this->passwordHasher->hashPassword(
                $simpleUser,
                'PasswordTest'
            );
            $simpleUser->setPassword($hashedPassword);
            $manager->persist($simpleUser);
            $this->addReference('user_' . $i, $simpleUser);
        }
        $manager->flush();
    }
}
