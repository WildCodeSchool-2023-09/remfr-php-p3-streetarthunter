<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Artwork;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArtworkFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 101; $i++) {
            $artwork = new Artwork();
            $artwork
                ->setLongitude($faker->longitude())
                ->setLatitude($faker->latitude())
                ->setCity($faker->city())
                ->setPoint($this->getReference('point_' . $faker->numberBetween(0, 100)))
                ->setArtist($this->getReference('artist_' . $faker->numberBetween(0, 100)));
            $manager->persist($artwork);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PointFixtures::class,
            ArtistFixtures::class,
        ];
    }
}
