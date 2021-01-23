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
    public function getArticles($category,$sub_category,$limit,$offset){
        switch ($category) {
            case 'null':
                return $this->createQueryBuilder('a')
                            ->orderBy('a.created_at','desc')
                            ->getQuery()
                            ->setMaxResults($limit)
                            ->setFirstResult($offset)
                            ->getResult();
                break;
            default:
                switch ($sub_category) {
                    case 'all':
                        return $this
                            ->createQueryBuilder('a')
                            ->where('a.category=:category')
                            ->setParameter('category', $category)
                            ->orderBy('a.created_at','desc')
                            ->getQuery()
                            ->setFirstResult($offset)
                            ->setMaxResults($limit)
                            ->getResult();
                        break;
                    default:
                        return $this
                            ->createQueryBuilder('a')
                            ->where('a.category=:category')
                            ->andWhere('a.sub_category=:sub_category')
                            ->setParameter('category', $category)
                            ->setParameter('sub_category',$sub_category)
                            ->orderBy('a.created_at','desc')
                            ->getQuery()
                            ->setFirstResult($offset)
                            ->setMaxResults($limit)
                            ->getResult();
                        break;
                }        
                break;
        } 
    }
    public function countArticles($category,$sub_category){
        switch ($category) {
            case 'null':
                return $this->createQueryBuilder('a') 
                            ->orderBy('a.created_at','desc')
                            ->getQuery()
                            ->getResult();
                break;
            default:
                switch ($sub_category) {
                    case 'all':
                        return $this
                            ->createQueryBuilder('a')
                            ->where('a.category=:category')
                            ->setParameter('category', $category)
                            ->getQuery()
                            ->getResult();
                        break;
                    default:
                        return $this
                            ->createQueryBuilder('a')
                            ->where('a.category=:category')
                            ->andWhere('a.sub_category=:sub_category')
                            ->setParameter('category', $category)
                            ->setParameter('sub_category',$sub_category)
                            ->getQuery()
                            ->getResult();
                        break;
                }        
                break;
        } 
    }
    public function getMostRead($limit){
        return $this->createQueryBuilder('a')
                    ->leftJoin('a.article_stat','stats')
                    ->addSelect('stats')
                    ->orderBy('stats.views','desc')
                    ->getQuery()
                    ->setMaxResults($limit)
                    ->getResult();
    }
    public function searchResult($limit = 10,$offset,$query){
        return $this->createQueryBuilder('a')
                    ->where('a.title LIKE  :query')
                    ->orWhere('a.introduction LIKE :query')
                    ->orWhere('a.article LIKE :query')
                    ->orderBy('a.created_at','desc')
                    ->setParameter('query', '%'.$query.'%')
                    ->getQuery()
                    ->setMaxResults($limit)
                    ->setFirstResult($offset)
                    ->getResult();
    }
    public function countSearchResult($query){
        return $this->createQueryBuilder('a')
                    ->where('a.title LIKE  :query')
                    ->orWhere('a.introduction LIKE :query')
                    ->orWhere('a.article LIKE :query')
                    ->setParameter('query', '%'.$query.'%')
                    ->getQuery()
                    ->getResult();
    }
    // /**
    //  * @return Article[] Returns an array of Article objects
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
