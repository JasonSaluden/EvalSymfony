<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitForm;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/produit')]
final class ProduitController extends AbstractController
{
    // Barre de recherche
    #[Route('/search', name: 'app_produit_search', methods: ['GET'])]
    public function search(Request $request, ProduitRepository $produitRepository): Response
    {        
        $query = $request->query->get('query');
        $produits = $produitRepository->searchByName($query);

        return $this->render('produit/search.html.twig', [
            'produits' => $produits,
            'query' => $query,
        ]);
    }

    
    // Restaure un produit supprimé
    #[Route('/restore/{id}', name: 'app_produit_restore', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function restore(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('restore' . $produit->getId(), $request->request->get('_token'))) {
            $produit->setSupprime(false);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Produit restauré avec succès.');

        return $this->redirectToRoute('app_produit_deleted');
    }

    // Affiche la liste des produits
    #[Route(name: 'app_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findBy(['supprime' => false]),
        ]);
    }

    // Crée un produit avec un formulaire. pas d'ajout d'image pour le moment
    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitForm::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    // Modifie un produit
    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if($produit->isSupprime()) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        $form = $this->createForm(ProduitForm::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }
    
    
    // Suppression physique d'un produit
    #[Route('/{id}', name: 'app_produit_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
            $produit->setSupprime(true);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('app_produit_index');
    }
    

    // Affiche tous les produits d'une catégorie
    #[Route('/categorie/{id}', name: 'app_produit_by_categorie', methods: ['GET'])]
    public function produitsByCategorie(ProduitRepository $produitRepository, CategorieRepository $categorieRepository, int $id): Response
    {
        $produits = $produitRepository->findBy(['id_categorie' => $id, 'supprime' => false]);
        $categorie = $categorieRepository->find($id);

        return $this->render('produit/by_categorie.html.twig', [
            'produits' => $produits,
            'id_categorie' => $id,
            'categorie' => $categorie,
        ]);
    }

    //Afficher produits supprimés
    #[Route('/deleted', name: 'app_produit_deleted', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deleted(ProduitRepository $produitRepository): Response
    {
        $produitsSupprimes = $produitRepository->findBy(['supprime' => true]);

        return $this->render('produit/deleted_products.twig', [
            'produits' => $produitsSupprimes,
        ]);
    }
    
    // Affiche un seul produit
    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        if (!$produit) {
        throw $this->createNotFoundException('Produit introuvable');
        }

        if ($produit->isSupprime()) {
            throw $this->createNotFoundException('Produit non trouvé');
        }

        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    
}
