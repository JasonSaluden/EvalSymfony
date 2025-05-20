<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function findByCategorie(int $categorieId)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.categorie = :val')
            ->setParameter('val', $categorieId)
            ->orderBy('p.nom_produit', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function searchByName(string $query): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.nom_produit LIKE :query')
            ->andWhere('p.supprime = :supprime')
            ->setParameter('query', '%' . $query . '%')
            ->setParameter('supprime', false)
            ->getQuery()
            ->getResult();
    }
}
