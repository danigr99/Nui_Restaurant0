<?php

namespace App\Repository;

use App\Entity\ProductoMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductoMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductoMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductoMenu[]    findAll()
 * @method ProductoMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductoMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductoMenu::class);
    }

    // /**
    //  * @return ProductoMenu[] Returns an array of ProductoMenu objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductoMenu
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
