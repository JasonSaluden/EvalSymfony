<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RootController extends AbstractController
{
    #[Route('/', name: 'app_root')]
    public function index(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_dashboard');
        }
        return $this->redirectToRoute('home');
    }
}
