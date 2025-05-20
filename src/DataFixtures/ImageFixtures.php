<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $images = [
            [7, 'images/montre_luxe_1.jpg', 'Montre de luxe en acier inoxydable'],
            [8, 'images/casque_audio_1.jpg', 'Casque audio sans fil, haute qualité sonore'],
            [9, 'images/tshirt_homme_1.jpg', 'T-shirt homme en coton avec motif graphique'],
            [10, 'images/smartphone_x10_1.jpg', 'Smartphone X10 avec écran 6.5 pouces et caméra 12M...'],
            [11, 'images/gel_douche_1.jpg', 'Gel douche parfum floral'],
            [12, 'images/power_bank_1.jpg', 'Batterie externe 10000mAh pour recharger vos appar...'],
            [13, 'images/collier_or_1.jpg', 'Collier en or 18 carats, design élégant'],
            [14, 'images/bracelet_argent_1.jpg', 'Bracelet en argent avec des détails raffinés'],
            [15, 'images/sac_sport_1.jpg', 'Sac de sport pratique et spacieux'],
            [16, 'images/gants_gym_1.jpg', 'Gants de gym avec protections pour les mains'],
            [17, 'images/sweat_a_capuche_1.jpg', 'Sweat à capuche en coton avec poche kangourou'],
            [18, 'images/creme_hydratante_1.jpg', 'Crème hydratante pour le visage, riche en vitamine...'],
        ];

        foreach ($images as [$produitId, $url, $alt]) {
            $image = new Image();
            $image->setUrl($url);
            $image->setAlt($alt);
            $image->setProduit($this->getReference('produit_' . $produitId)); 
            $manager->persist($image);
        }

        $manager->flush();
    }
}
