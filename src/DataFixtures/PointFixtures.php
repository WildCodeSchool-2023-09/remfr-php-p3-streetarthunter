<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Point;
use Faker\Factory;

class PointFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 101; $i++) {
            $point = new Point();
            $point
                ->setLevel($faker->randomDigit());
            $manager->persist($point);
            $this->addReference('point_' . $i, $point);
        }
        $manager->flush();
    }
}
