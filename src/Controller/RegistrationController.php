<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RegistrationController extends AbstractController
{
    private $entityManager;
    private $passwordHasher;
    private $tokenStorage;

    public function __construct(
        EntityManagerInterface $entityManager, 
        UserPasswordHasherInterface $passwordHasher,
        TokenStorageInterface $tokenStorage
    ) {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
        $this->tokenStorage = $tokenStorage;
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]    
    public function register(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode le mot de passe de l'utilisateur
            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));

            // Ajouter un rôle par défaut
            $user->setRoles(['ROLE_USER']);  // Changez le rôle si nécessaire

            // Sauvegarde l'utilisateur en base de données
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // Connexion manuelle après l'inscription
            $token = new UsernamePasswordToken(
                $user,
                'main', // Nom du firewall, vérifiez dans security.yaml
                $user->getRoles()
            );
            $this->tokenStorage->setToken($token);
            
            // Stockage en session
            $request->getSession()->set('_security_main', serialize($token));

            // Redirection vers le dashboard
            $this->addFlash('success', 'Votre compte a été créé avec succès!');
            return $this->redirectToRoute('app_dashboard'); // Changez selon votre route réelle
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}