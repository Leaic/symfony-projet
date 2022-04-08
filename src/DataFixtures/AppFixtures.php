<?php

namespace App\DataFixtures;

use DateTimeImmutable;
use App\Entity\Property;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    private ObjectManager $manager;
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        /*$this->manager = $manager;

        $property= new Property();



        $property->setTitle('Mon Premier bien')
        ->setDescription("Une petite description")
        ->setSurface(60)
        ->setRooms(4)
        ->setBedrooms(3)
        ->setFloor(4)
        ->setPrice('200000')
        ->setCity("MontPellier")
        ->setPostalcode(34000)
        ->setCeatedAt( new \DateTimeImmutable(''));

        
        $this->manager->persist($property);
        
        $manager->flush();*/
    }
}
