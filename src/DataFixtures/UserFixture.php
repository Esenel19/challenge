<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)

    {
        $faker = \Faker\Factory::create('fr_FR');

        for($i=1; $i <= mt_rand(5,7); $i++)

        {
            $user = new User;

            $user->setLastname($faker->lastname)
                 ->setFirstname($faker->firstname)
                 ->setEmail($faker->email)
                 ->setPassword(
                    password_hash($user->getFirstName() . "1234" )
                );
        }
        

        
     

        //     $manager->persist($user);
        // }
        // $manager->flush();
        $manager->flush();
    }

}

