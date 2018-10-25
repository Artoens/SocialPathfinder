<?php

namespace App\Repository;

use App\Entity\MyTable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MyTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method MyTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method MyTable[]    findAll()
 * @method MyTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MyTableRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MyTable::class);
    }

//    /**
//     * @return MyTable[] Returns an array of MyTable objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MyTable
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
