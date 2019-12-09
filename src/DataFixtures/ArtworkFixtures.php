<?php

namespace App\DataFixtures;

use App\Entity\Artwork;
use App\Entity\Place;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class ArtworkFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // instancier faker
        $faker = Faker::create('fr_FR');

        // pour remplir la table, créer des objets puis les persister
        for ($i = 0; $i < 20; $i++) {
            $artwork = new Artwork();
            $place = new Place();

            $place
                ->setStreet($faker->streetAddress)
                ->setZipCode($faker->randomDigit)
                ->setCountry($faker->country)
                ->setCity($faker->city);

            $artwork
                ->setName($faker->unique()->country)
                ->setDescription($faker->text)
                ->setImage('peinture.jpg')
                ->setPlace($place);

            $randomCategory = random_int(0, 2);
            $artwork->setCategory($this->getReference("category$randomCategory"));

            $this->addReference("artwork$i", $artwork);
            $manager->persist($artwork);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class,
        );
    }
}
