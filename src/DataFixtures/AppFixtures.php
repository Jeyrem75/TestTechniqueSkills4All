<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\CarCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $categories = [];

        for($i = 0; $i < 9; $i++) {
            $category = new CarCategory();
            $category->setName($faker->word());
            $manager->persist($category);
            $categories[] = $category;
        }

        $cars = [];

        for($j = 0; $j < 100; $j++) {
            $car = new Car();
            $car->setNbSeats($faker->numberBetween(2, 9));
            $car->setNbDoors($faker->numberBetween(2, 4));
            $car->setName($faker->words(2, true));
            $car->setCost($faker->randomFloat(2, 5000, 50000));
            $car->setCategory($faker->randomElement($categories));
            $manager->persist($car);
            $cars = $car;
        }

        $manager->flush();
    }
}
