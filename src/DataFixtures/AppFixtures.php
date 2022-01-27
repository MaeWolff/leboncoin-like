<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use App\Factory\TagFactory;
use App\Factory\PostFactory;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(20);

        // NOTE: To create some tags
        TagFactory::createOne(['name' => 'jeux']);
        TagFactory::createOne(['name' => 'véhicules']);
        TagFactory::createOne(['name' => 'loisirs']);
        TagFactory::createOne(['name' => 'divers']);

        PostFactory::createMany(30, function () {
            $number = rand(1, 4);
            $images = [];

            for ($i = 0; $i <= $number; $i++) {
                // TODO: Replace this placeholder by the random images
                $images[] = "https://loremflickr.com/320/240";
            }
            return ["images" => $images];
        });


        $manager->flush();
    }
}
