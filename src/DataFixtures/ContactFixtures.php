<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $contact = new Contact();
            $contact->setLastname($faker->name());
            $contact->setFirstname($faker->name());
            $contact->setEmail($faker->email());
            $contact->setMessage($faker->sentence(55));
            $manager->persist($contact);
        }

        $manager->flush();
    }
}
