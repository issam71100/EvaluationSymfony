<?php

namespace App\DataFixtures;

use App\Entity\Place;
use App\Entity\Exposition;
use DateTime;
use Faker\Factory as Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class ExpositionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // instancier faker
        $faker = Faker::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $exposition = new Exposition();
            $place = new Place();

            $place
                ->setStreet($faker->streetAddress)
                ->setZipCode($faker->randomDigit)
                ->setCountry($faker->country);
            $exposition
                ->setName($faker->unique()->name)
                ->setDescription($faker->text)
                ->setPlace($place)
                ->setDate($faker->dateTimeBetween('-1 month','+1 month'))
                ;

            for ($j = 0; $j < 3; $j++) {
                $randomArtwork = random_int(0, 19);
                while ($exposition->getArtworks()->contains($this->getReference("artwork$randomArtwork"))) {
                    $randomArtwork = random_int(0, 19);
                }
                $exposition->addArtwork($this->getReference("artwork$randomArtwork"));
            }
            $manager->persist($exposition);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            ArtworkFixtures::class,
        );
    }
}
