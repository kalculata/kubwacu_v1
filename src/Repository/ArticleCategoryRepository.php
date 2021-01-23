<?php
namespace App\Repository;

use App\Entity\ArticleCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArticleCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleCategory[]    findAll()
 * @method ArticleCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleCategory::class);
    }
    public function findAllCategory(){
        return $this->createQueryBuilder('a')
                    ->select('a')
                    ->getQuery()
                    ->getResult();
    }
    public function categoryVerify($category){
        $categorys=  $this->createQueryBuilder('a')
                    ->select('a.name')
                    ->where('a.name= :category')
                    ->setParameter('category', $category)
                    ->getQuery()
                    ->getArrayResult();
        $nbreCategorys = count($categorys);
        return ($nbreCategorys==0)?false:true;
    }
    public function subcategoryVerify($category,$sub_category){
        $subcategorys=  $this->createQueryBuilder('a')
                    ->select('a.sub_category')
                    ->where('a.id= :categoryId')
                    ->setParameter('categoryId', $category)
                    ->getQuery()
                    ->getArrayResult();
        return in_array($sub_category, $subcategorys[0]['sub_category']);
    }
    public function getCategoryName($categoryId){
        return $this->createQueryBuilder('a')
                    ->select('a.name')
                    ->where('a.id=:categoryId')
                    ->setParameter('categoryId', $categoryId)
                    ->getQuery()
                    ->getSingleResult();
    }
    public function getCategoryLogo($categoryId){
        return $this->createQueryBuilder('a')
                    ->select('a.logotype')
                    ->where('a.id=:categoryId')
                    ->setParameter('categoryId', $categoryId)
                    ->getQuery()
                    ->getSingleResult();
    }
    // /**
    //  * @return ArticleCategory[] Returns an array of ArticleCategory objects
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
    public function findOneBySomeField($value): ?ArticleCategory
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
