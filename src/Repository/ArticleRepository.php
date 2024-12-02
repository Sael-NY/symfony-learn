<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function search(string $search) : array
    {
        // On instancie e queryBuilder qui permet d'aller interroger la database quand on passe
        // par le queryBuilder pour faire des requêtes SQL on appelle les variable avec :nomVariable
        return $this->createQueryBuilder('a')
            // Je débute a requête SQL n précisant le 'where' = 1 condition
            ->where('a.title LIKE :search')
            // On donne une seconde condition
            ->orWhere('a.content LIKE :search')
            // On passe le paramètre avec la variable 'search'
            ->setParameter('search', '%'.$search.'%')
            // On construit la requête SQL à partir des données précisées plus haut
            ->getQuery()
            // On récupère les articles filtrès par la datebase
            ->getResult();

    }
    //    /**
    //     * @return Article[] Returns an array of Article objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Article
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
