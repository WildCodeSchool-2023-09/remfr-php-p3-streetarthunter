<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Partner;
use Faker\Factory;

class PartnerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 101; $i++) {
            $partner = new Partner();
            $partner
                ->setName($faker->name())
                ->setMunicipalitypartner($faker->word())
                ->setPrivatepartner($faker->word());
            $manager->persist($partner);
            $this->addReference('partner_' . $i, $partner);
        }
        $manager->flush();
    }
}
