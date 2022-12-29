<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d’un utilisateur de type user simple
        $simpleUser = new User();
        $simpleUser->setEmail('conn.rubie@tillman.com');
        $simpleUser->setRoles(['ROLE_SIMPLEUSER']);
        $simpleUser->setFirstName('Norbert');
        $simpleUser->setLastName('Huel');
        $simpleUser->setLogin('Norbert');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $simpleUser,
            'simpleUserPassword'
        );
        $simpleUser->setPassword($hashedPassword);
        $manager->persist($simpleUser);

        // Création d’un utilisateur de type user simple
        $simpleUser = new User();
        $simpleUser->setEmail('sibyl.grimes@weissnat.com');
        $simpleUser->setRoles(['ROLE_SIMPLEUSER']);
        $simpleUser->setFirstName('Boyd');
        $simpleUser->setLastName('O\'Reilly');
        $simpleUser->setLogin('Boyd');
        $hashedPassword = $this->passwordHasher->hashPassword(
            $simpleUser,
            'simpleUserPassword'
        );
        $simpleUser->setPassword($hashedPassword);
        $manager->persist($simpleUser);

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

        $manager->flush();
    }
}
