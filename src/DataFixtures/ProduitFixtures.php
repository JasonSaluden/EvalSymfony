<?php

namespace App\DataFixtures;

use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProduitFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $produits = [
            ['Montre Luxe', 199.99, 50, 'La Montre Luxe est un modèle d\'exception conçu pour...'],
            ['Casque Audio', 39.99, 100, 'Plongez dans un son de qualité avec le Casque Audio...'],
            ['T-shirt Homme', 9.99, 200, 'Le T-shirt Homme est un vêtement incontournable de...'],
            ['Smartphone X10', 149.99, 30, 'Le Smartphone X10 est un appareil haut de gamme conçu...'],
            ['Gel Douche', 3.49, 500, 'Le Gel Douche est un soin doux et rafraîchissant pour...'],
            ['Power Bank 10000mAh', 19.99, 150, 'Ne soyez plus jamais à court de batterie avec la P...'],
            ['Collier en Or', 199.99, 20, 'Le Collier en Or est une pièce intemporelle qui...'],
            ['Bracelet en Argent', 49.99, 40, 'Le Bracelet en Argent est un bijou élégant et discr...'],
            ['Sac de Sport', 29.99, 90, 'Le Sac de Sport est l\'accessoire essentiel pour to...'],
            ['Gants de Gym', 12.99, 150, 'Les Gants de Gym sont conçus pour offrir une prise...'],
            ['Sweat à Capuche', 24.99, 120, 'Le Sweat à Capuche est le vêtement idéal pour vos...'],
            ['Crème Hydratante', 14.99, 120, 'La Crème Hydratante est un soin quotidien essentie...'],
        ];

        foreach ($produits as [$nom, $prix, $quantite, $desc, $categorieRef]) {
            $produit = new Produit();
            $produit->setNomProduit($nom);
            $produit->setPrix($prix);
            $produit->setQuantite($quantite);
            $produit->setDescription($desc);
            $produit->setDateAjout(new \DateTimeImmutable('now'));
            $produit->setSupprime(false);
            $produit->setCategorie($this->getReference($categorieRef));

            $manager->persist($produit);
            
            $this->addReference('produit_' . ($i + 7), $produit);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategorieFixtures::class,
        ];
    }
}
