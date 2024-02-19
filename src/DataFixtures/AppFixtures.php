<?php

namespace App\DataFixtures;

use App\Entity\Monster;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Config\Framework\FragmentsConfig;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++) {
            $monster = new Monster();
            $monster->setPrice($faker->numberBetween(5, 9));
            $monster->setNom($faker->firstName);
            $manager->persist($monster);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
