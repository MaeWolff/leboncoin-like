<?php

namespace App\DataFixtures;

use Faker\Factory;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory::create();

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user
                ->setEmail($this->faker->email)
                ->setPassword('changeMe')
                ->setIsAdmin(false)
                ->setVotes(0)
                ->setUsername($this->faker->userName);

            $manager->persist($user);
        }

        $manager->flush();
    }
}
