<?php

namespace App\Repository;

use App\Entity\ArticleStat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArticleStat|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleStat|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleStat[]    findAll()
 * @method ArticleStat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleStatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleStat::class);
    }

    // /**
    //  * @return ArticleStat[] Returns an array of ArticleStat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArticleStat
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
