<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPassHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {

        /* fakers */
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 51; $i++) {
            $user = new User();
            $user
                ->setLastname($faker->lastName())
                ->setFirstname($faker->firstName())
                ->setUserName($faker->firstName() . $i)
                ->setPassword($this->userPassHasher->hashPassword($user, $faker->password()))
                ->setEmail($faker->email());
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }

        /* test Admin demo */
        $admin = new User();
        $admin
            ->setLastname('Admin')
            ->setFirstname('Admin')
            ->setUserName('Admin')
            ->setPassword($this->userPassHasher->hashPassword($admin, 'Admin'))
            ->setEmail('admin@admin.com')
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        /* test User demo */
        $testUser = new User();
        $testUser
            ->setLastname('TestUser')
            ->setFirstname('TestUser')
            ->setUserName('TestUser')
            ->setPassword($this->userPassHasher->hashPassword($testUser, 'TestUser'))
            ->setEmail('testuser@testuser.com');
        $manager->persist($testUser);

        $manager->flush();
    }
}
