<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for($i=0; $i < 100; $i++){

            $property = new Property();

            $property->setTitle($faker->words(3, true))
            ->setDescription($faker->words(6, true) )
            ->setSurface($faker->numberBetween(20, 350))
            ->setRooms($faker->numberBetween(2, 10))
            ->setBedrooms($faker->numberBetween(1, 9))
            ->setFloor($faker->numberBetween(0, 15))
            ->setPrice($faker->numberBetween(10000, 1000000))
            ->setCity($faker->city)
            ->setPostalcode($faker->postcode)
            ->setSold(false)
            ->setCeatedAt( new \DateTimeImmutable(''));
            
        
            $manager->persist($property);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
