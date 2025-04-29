<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact_form')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    #[Route('/contact/submit', name: 'contact_form_submit')]
    public function submitContactForm(Request $request): Response
    {
        // Récupérer les données du formulaire
        $email = $request->request->get('email');
        $firstName = $request->request->get('first_name');
        $lastName = $request->request->get('last_name');
        $subject = $request->request->get('subject');
        $message = $request->request->get('message');


        // Pour l'instant, on redirige simplement vers une page de confirmation
        return $this->redirectToRoute('contact_form_success');
    }
}
