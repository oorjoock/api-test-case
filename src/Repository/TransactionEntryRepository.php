<?php

namespace App\Repository;

use App\Entity\TransactionEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TransactionEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method TransactionEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method TransactionEntry[]    findAll()
 * @method TransactionEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransactionEntry::class);
    }

    // /**
    //  * @return TransactionEntry[] Returns an array of TransactionEntry objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TransactionEntry
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
