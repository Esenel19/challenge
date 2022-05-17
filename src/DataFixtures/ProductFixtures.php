<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Product;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $faker = \Faker\Factory::create('fr_FR');

        //    $userFirstNames = ['Aoi', 'Bibi','Coco'];
        // $userLastNames = ['Cu','Aro','Bobo'];
        // foreach($userFirstNames as $userLastNames)
       
            // $user = new User();

            // $user->setEmail("test@gmail.com")
            //      ->setLastname("Test")
            //      ->setFirstname("E")
            //      ->setPassword("Test1234");

            //      $manager->persist($user);

                 
            // $categorie = new Categorie();

            // $categorie->setTitle("TestCategorie");
            // $categorie->setTitle($title);
            //recupere bien mes categorieFixture il faut trouver comment les use directement avec mtn, bonne chance
            
            // $manager->persist($categorie);
        


        // for($k = 1; $k <= mt_rand(8,10); $k++)
        // {
        //     $product = new Product;

        //     $product->setTitle($faker->sentence(3))
        //             ->setImage($faker->imageUrl)
        //             ->setUser($user)
        //             ->setCategorie($categorie)
        //             ->setPrice($faker->randomFloat(2,10,100));
        //             //2 decimales, min 10, max 100
        //     // $categories = $this->getReference($title);
        //     // $product->setCategorie($categories);


        //     $manager->persist($product);
        // }

        // $manager->flush();
    }
}
