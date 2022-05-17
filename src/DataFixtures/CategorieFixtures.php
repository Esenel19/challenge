<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = ['Jeux','Sport','Musique','Art','Voyage'];
        foreach($categories as $title)
        {
            $categorie = new Categorie();

            $categorie->setTitle($title);
            
            // $this->addReference($title, $categories);
            //Le conserve et permet de l'use dans d'autre dixture
            $manager->persist($categorie);
        }
        $manager->flush();
    }
}
