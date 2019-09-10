<?php

namespace App\Repository;

use App\Entity\Contry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Contry|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contry|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contry[]    findAll()
 * @method Contry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contry::class);
    }

    // /**
    //  * @return Contry[] Returns an array of Contry objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Contry
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
