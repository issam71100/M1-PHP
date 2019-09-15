<?php

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

/**
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, City::class);
    }

    // /**
    //  * @return City[] Returns an array of City objects
    //  */
    public function findCitiesByMonthes($id)
    {
        // Management of Months
        $years_months= [
            1=>"janvier",
            2=>"fevrier",
            3=>"mars",
            4=>"avril",
            5=>"mai",
            6=>"juin",
            7=>"juillet",
            8=>"aout",
            9=>"septembre",
            10=>"octobre",
            11=>"novembre",
            12=>"decembre",
        ];

        return $this->createQueryBuilder('c')
            ->select('c')
            ->leftJoin('c.activities', 'a')
            ->leftJoin('a.months','m')
            ->andWhere('m.name = :name')
            ->setParameter('name', $years_months[$id])
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return City[] Returns an array of City objects
    //  */
    public function findCitiesByActivity($activity_name)
    {
        return $this->createQueryBuilder('c')
            ->select('c')
            ->leftJoin('c.activities', 'a')
            ->andWhere('c.name = :name')
            ->setParameter('name', $activity_name)
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?City
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findOneByName($name): ?City
    {
        try {
            return $this->createQueryBuilder('c')
                ->andWhere('c.name = :name')
                ->setParameter('name', $name)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }
}
