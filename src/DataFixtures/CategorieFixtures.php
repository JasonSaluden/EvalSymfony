<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            'Montres',
            'Casques audio',
            'Vêtements',
            'Soins personnels',
            'Accessoires électroniques',
            'Bijoux',
            'Accessoires de sport'
        ];

        foreach ($categories as $i => $nom) {
            $categorie = new Categorie();
            $categorie->setNom($nom);
            $manager->persist($categorie);
            $this->addReference('categorie_' . ($i + 1), $categorie);
        }

        $manager->flush();
    }
}
