<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
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

    public function save(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Article $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCategorie($value): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.sousCategorie', 'sousCategorie')
            ->join('sousCategorie.categorie', 'categorie')
            ->andWhere('sousCategorie.categorie = :cat')
            ->setParameter('cat', $value)
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }
    public function findAllArticleCategorie($value): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.sousCategorie', 'sousCategorie')
            ->join('sousCategorie.categorie', 'categorie')
            ->andWhere('sousCategorie.categorie = :cat')
            ->setParameter('cat', $value)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findAllAuteurArticle($value): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.auteur', 'categorie')
            ->andWhere('a.auteur = :auteur')
            ->setParameter('auteur', $value)
            ->orderBy('a.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByCategorie4($value): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.sousCategorie', 'sousCategorie')
            ->join('sousCategorie.categorie', 'categorie')
            ->andWhere('sousCategorie.categorie = :cat')
            ->setParameter('cat', $value)
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }
    public function last6Article(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult()
        ;
    }
    public function last6ArticleEachCategorie(): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.sousCategorie', 'sousCategorie')
            ->join('sousCategorie.categorie', 'categorie')
            ->groupBy('sousCategorie.categorie')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult()
        ;
    }
    public function articleAssocier($categorie): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.sousCategorie', 'sousCategorie')
            ->join('sousCategorie.categorie', 'categorie')
            ->andWhere('sousCategorie.categorie = :cat')
            ->setParameter('cat', $categorie)
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }
    public function articleLifestyle($categorie): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.sousCategorie', 'sousCategorie')
            ->join('sousCategorie.categorie', 'categorie')
            ->andWhere('sousCategorie.categorie = :cat')
            ->setParameter('cat', $categorie)
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
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