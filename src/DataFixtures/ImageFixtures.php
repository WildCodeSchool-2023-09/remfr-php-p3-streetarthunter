<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Image;
use Faker\Factory;

class ImageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 101; $i++) {
            $image = new Image();
            $image
                ->setPhoto($faker->imageUrl(640, 480, 'animals', true));
            $manager->persist($image);
            $this->addReference('image_' . $i, $image);
        }

        $manager->flush();
    }
}
