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
        UserFactory::createMany(10);

        // NOTE: To create some tags
        TagFactory::createOne(['name' => 'jeux']);
        TagFactory::createOne(['name' => 'véhicules']);
        TagFactory::createOne(['name' => 'loisirs']);
        TagFactory::createOne(['name' => 'divers']);

        PostFactory::createMany(10);


        $manager->flush();
    }
}
