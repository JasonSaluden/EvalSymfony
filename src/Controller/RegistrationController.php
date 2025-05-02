<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;

    public function __construct(
        EntityManagerInterface $entityManager, 
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    // Affiche le formulaire d'inscription
    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]    
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $utilisateur = new Utilisateur();

        $user->setUtilisateur($utilisateur);
        $utilisateur->setUser($user);

        // Créer le formulaire d'inscription
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adminRole = $form->get('adminRole')->getData();

            // Attribue le rôle admin si la case est cochée
            $roles = $adminRole ? ['ROLE_ADMIN'] : ['ROLE_USER'];
            $user->setRoles($roles);

            // Hache le mot de passe avec le password hasher
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));

            // Sauvegarde l'utilisateur dans la table User
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Sauve les informations dans la table Utilisateur
            $this->entityManager->persist($utilisateur);
            $this->entityManager->flush();

            // Redirige l'utilisateur vers la page de connection
            return $this->redirectToRoute('app_dashboard');
        }

        // Renvoye le formulaire à la vue
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
