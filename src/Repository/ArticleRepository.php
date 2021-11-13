<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */

    public function findByCategorie($category)
    {
        return $this->createQueryBuilder('q')

            ->from(Article::class, 'a')
            ->Where('a.categorie = :article')
            ->setParameter('article', $category)
//            ->orderBy('a.date', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }



    /**
     * @return Article[]
     */
    public function findAllbyCategory($category): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Article p
            WHERE p.categorie = :categorie'
        )->setParameter('categorie', $category);

        // returns an array of Product objects
        return $query->getResult();
    }

    /**
     * @return Article[]
     */
    public function findNewArticles(): array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Article p
            WHERE NOT p.categorie = :categorie        
            ORDER BY p.date DESC 
            '
        )
        ->setMaxResults(3)
        ->setParameter(":categorie","livres")
        ;

        // returns an array of Product objects
        return $query->getResult();



    }

    /**
     * @return Article []
     *
     */
    public function findTopViewedArticle () {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Article p
            
            ORDER BY p.views DESC 
            '
        )
            ->setMaxResults(1)
        ;

        // returns an array of Product objects
        return $query->getResult();


    }


    /**
     * @return Article[]
     *
     */
    public function  findLatestBookReview(): array {
        $entitymanager = $this->getEntityManager();
        $query = $entitymanager->createQuery(
          'SELECT p
            FROM App\Entity\Article p
            WHERE p.categorie = :categorie
            ORDER BY p.date DESC 
            '

        )
        ->setParameter(":categorie", "Livres" )
        ->setMaxResults(1);

        return $query->getResult();


    }




/*
    public function findByCategory($category){
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQueryBuilder(
            createQueryBuilder('a')
                ->select('*')
                ->from("article, a")
                ->where('a.categorie = :categorie')
                ->setParameter('categorie', $category)
                ->getQuery());

        // returns an array of Product objects
        return $query->getResult();



    }





    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
