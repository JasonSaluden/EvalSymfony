<?php

namespace App\DataFixtures;

use App\Entity\MessageContact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MessageContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $messages = [
            [
                'utilisateurRef' => 'utilisateur_2',
                'nom' => 'jason saluden',
                'sujet' => 'TEST',
                'email' => 'saluden.jason@gmail.com',
                'dateEnvoi' => new \DateTime('2025-04-29 18:17:40'),
                'message' => 'AISJIJSJUS'
            ],
            [
                'utilisateurId' => 2,
                'nom' => 'jason saluden',
                'sujet' => 'TEST',
                'email' => 'saluden.jason@gmail.com',
                'dateEnvoi' => new \DateTime('2025-04-29 18:17:45'),
                'message' => 'asaz'
            ],
        ];

        foreach ($messages as $data) {
            $msg = new MessageContact();
            $msg->setNom($data['nom']);
            $msg->setSujet($data['sujet']);
            $msg->setEmail($data['email']);
            $msg->setDateEnvoi($data['dateEnvoi']);
            $msg->setMessage($data['message']);

            $msg->setUtilisateur($this->getReference($data['utilisateurRef']));

            $manager->persist($msg);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UtilisateurFixtures::class];
    }

}
