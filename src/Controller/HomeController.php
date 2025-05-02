<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Security;


final class HomeController extends AbstractController
{
    // Affiche la page d'accueil, pour tous les utilisateurs non connectés
    #[Route('/home', name: 'home')]
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render('home/index.html.twig', [
            'user' => $user,
            'controller_name' => 'HomeController'
        ]);
    }

}
