<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Utilisateur; // N'oublie pas d'importer Utilisateur
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

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]    
    public function register(Request $request): Response
    {
        $user = new User();
        $utilisateur = new Utilisateur();

        // Créer le formulaire d'inscription
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hacher le mot de passe avec le password hasher
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));

            // Sauvegarder l'utilisateur dans la table User
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Remplir les informations supplémentaires dans la table Utilisateur
            $utilisateur->setNom($form->get('nom')->getData());
            $utilisateur->setPrenom($form->get('prenom')->getData());
            $utilisateur->setDateInscription(new \DateTime());
            $utilisateur->setUser($user); // Lier l'utilisateur au User

            // Sauver les informations dans la table Utilisateur
            $this->entityManager->persist($utilisateur);
            $this->entityManager->flush();

            // Rediriger l'utilisateur vers la page de connexion
            return $this->redirectToRoute('app_dashboard');
        }

        // Renvoyer le formulaire à la vue
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
