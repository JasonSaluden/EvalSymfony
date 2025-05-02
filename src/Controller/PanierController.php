<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Ajout d'un produit au panier
    #[Route('/panier/ajouter/{id}', name: 'app_panier_ajouter', methods: ['POST'])]
    public function ajouterAuPanier(int $id, Request $request)
    {
        // Récupérer le produit à partir de l'Id
        $produit = $this->entityManager->getRepository(Produit::class)->find($id);

        if ($produit) {
            $session = $request->getSession();
            // Vérifier si le panier existe déjà dans la session, sinon l'initialiser
            $cart = $session->get('panier', []);

            $cart[$id] = isset($cart[$id]) ? $cart[$id] + 1 : 1;

            $session->set('panier', $cart);

        }

        return $this->redirectToRoute('app_panier');
    }

    // Afficher le contenu du panier
    #[Route('/panier', name: 'app_panier')]
    public function afficherPanier(Request $request): Response
    {
        // Récupérer le panier stocké dasn  la session
        $session = $request->getSession();
        $cart = $session->get('panier', []);

        // liste des produits dans le panier
        $produits = [];
        foreach ($cart as $id => $quantity) {
            $produit = $this->entityManager->getRepository(Produit::class)->find($id);
            if ($produit) {
                $produits[] = [
                    'produit' => $produit,
                    'quantite' => $quantity,
                ];
            }
        }

        // Calculer le total du panier
        $total = 0;
        foreach ($produits as $item) {
            $total += $item['produit']->getPrix() * $item['quantite'];
        }

        // Passer les données à la vue pour affichage
        return $this->render('panier/afficher.html.twig', [
            'produits' => $produits,
            'total' => $total,
        ]);
    }

    // Retrait produit du panier
    #[Route('/panier/diminuer/{id}', name: 'app_panier_diminuer')]
    public function diminuerQuantite(int $id, Request $request)
    {
        $produit = $this->entityManager->getRepository(Produit::class)->find($id);

        if ($produit) {
            $session = $request->getSession();
            $cart = $session->get('panier', []);

            if (isset($cart[$id]) && $cart[$id] > 1) {
                $cart[$id] -= 1;
            }
            $session->set('panier', $cart);

        }
        return $this->redirectToRoute('app_panier');
    }

     // Supprimer un produit du panier
     #[Route('/panier/supprimer/{id}', name: 'app_panier_remove')]
     public function supprimerDuPanier(int $id, Request $request)
     {
         $session = $request->getSession();
         $cart = $session->get('panier', []);
         unset($cart[$id]);
         $session->set('panier', $cart);
 
         return $this->redirectToRoute('app_panier');
     }

    // Mettre a jour la quantite d'un produit dans le panier
    #[Route('/panier/update/{id}/{action}', name: 'app_panier_update')]
    public function updatePanier(int $id, string $action, Request $request)
    {
        $produit = $this->entityManager->getRepository(Produit::class)->find($id);

        if ($produit) {
            $session = $request->getSession();
            $cart = $session->get('panier', []);

            if ($action == 'increase') {
                $cart[$id] = isset($cart[$id]) ? $cart[$id] + 1 : 1;
            } elseif ($action == 'decrease' && isset($cart[$id]) && $cart[$id] > 1) {
                $cart[$id] -= 1;
            }

            $session->set('panier', $cart);
        }

        return $this->redirectToRoute('app_panier');
    }
}
