<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 51; $i++) {
            $user = new User();
            $user
                ->setLastname($faker->lastName())
                ->setFirstname($faker->firstName())
                ->setUserName($faker->firstName())
                ->setPassword($faker->password())
                ->setEmail($faker->email());
            $manager->persist($user);
            $this->addReference('user_' . $i, $user);
        }
        $manager->flush();
    }
}
