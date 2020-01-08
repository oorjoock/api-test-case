<?php

namespace App\Repository;

use App\Entity\Account;
use App\Entity\TransactionEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
    }

    /**
     * @param Account $account
     *
     * @return float
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getBalance(Account $account)
    {
        return (float)$this
            ->_em
            ->createQueryBuilder()
            ->select('SUM(te.amount)')
            ->from(
                Account::class,
                'a'
            )
            ->join(
                TransactionEntry::class,
                'te',
                Join::WITH,
                'te.account = a'
            )
            ->andWhere('te.account = :account')
            ->setParameter(
                'account',
                $account
            )
            ->getQuery()
            ->getSingleScalarResult();
    }

}

