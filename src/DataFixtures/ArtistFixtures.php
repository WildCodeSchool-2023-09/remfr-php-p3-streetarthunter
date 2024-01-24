<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Artist;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArtistFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 101; $i++) {
            $artist = new Artist();
            $artist
                ->setName($faker->name())
                ->addPartner($this->getReference('partner_' . $faker->numberBetween(0, 100)));
            $manager->persist($artist);
            $this->addReference('artist_' . $i, $artist);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PartnerFixtures::class,
        ];
    }
}
