<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SecurityController extends AbstractController
{
    // Affiche la page de connexion
    #[Route('/login', name: 'app_login')]
    public function login(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard'); 
        }

        return $this->render('security/login.html.twig');
    }

    // Déconnection de l'utilisateur
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {

        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
