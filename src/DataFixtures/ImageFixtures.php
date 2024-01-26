<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Image;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 101; $i++) {
            $image = new Image();
            $image
                ->setPhoto($faker->imageUrl(640, 480, 'animals', true))
                ->setUser($this->getReference('user_' . $faker->numberBetween(0, 50)))
                ->setArtwork($this->getReference('artwork_' . $faker->numberBetween(0, 100)));
            $manager->persist($image);
            $this->addReference('image_' . $i, $image);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ArtworkFixtures::class,
        ];
    }
}
