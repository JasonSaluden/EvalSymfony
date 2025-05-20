<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Utilisateur standard
        $user = new Utilisateur();
        $user->setEmail('user@test.com');
        $user->setRoles(['ROLE_USER']);
        $user->setMotDePasse($this->hasher->hashPassword($user, 'userpass'));
        $manager->persist($user);
        $this->addReference('utilisateur_1', $user);

        // Admin
        $admin = new Utilisateur();
        $admin->setEmail('admin@test.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setMotDePasse($this->hasher->hashPassword($admin, 'adminpass'));
        $manager->persist($admin);
        $this->addReference('utilisateur_2', $admin);

        $manager->flush();
    }
}
