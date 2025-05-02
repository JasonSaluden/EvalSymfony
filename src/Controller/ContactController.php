<?php

namespace App\Controller;

use App\Entity\MessageContact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ContactController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/contact', name: 'contact_form')]
    public function index(): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();

        // Initialiser les variables à passer au template
        $userData = [
            'email' => '',
            'prenom' => '',
            'nom' => ''
        ];

        // Si l'utilisateur est connecté, on récup ses infos
        if ($user) {
            $userData['email'] = $user->getEmail();

            // Liaison infos Utilisateur associé
            $utilisateur = $user->getUtilisateur();

            if ($utilisateur) {
                $userData['prenom'] = $utilisateur->getPrenom() ?: '';
                $userData['nom'] = $utilisateur->getNom() ?: '';
            }
        }
        // Récupérer les messages de contact
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'userData' => $userData
        ]);
    }

    // Soumettre le formulaire de contact
    #[Route('/contact/submit', name: 'contact_form_submit')]
    public function submitContactForm(Request $request): Response
    {
        // Récupérer les données du formulaire
        $email = $request->request->get('email');
        $firstName = $request->request->get('first_name');
        $lastName = $request->request->get('last_name');
        $subject = $request->request->get('subject');
        $messageText = $request->request->get('message');

        // Créer une nouvelle instance de MessageContact
        $messageContact = new MessageContact();
        $messageContact->setEmail($email);
        $messageContact->setNom("$firstName $lastName"); // On concatène le prénom et le nom
        $messageContact->setSujet($subject);
        $messageContact->setMessage($messageText);
        // La date d'envoi est déjà initialisée dans le constructeur

        // Si l'utilisateur est connecté, associer le message à son compte
        $user = $this->getUser();
        if ($user && $user->getUtilisateur()) {
            $messageContact->setIdUtilisateur($user->getUtilisateur());
        }

        // Enregistrer le message dans la base de données
        $this->entityManager->persist($messageContact);
        $this->entityManager->flush();

        // Message de confirmation
        $this->addFlash('success', 'Votre message a été envoyé avec succès !');

        // Redirection vers la page de contact
        return $this->redirectToRoute('contact_form');
    }
}
