<?php

namespace App\Service\Transaction;

use Doctrine\ORM\EntityManagerInterface;

class DoctrineTransactionService implements TransactionServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function start(): void
    {
        $this
            ->entityManager
            ->getConnection()
            ->beginTransaction();
    }

    /**
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function commit(): void
    {
        $this
            ->entityManager
            ->flush();

        if ($this->entityManager->getConnection()->isTransactionActive()) {
            $this
                ->entityManager
                ->getConnection()
                ->commit();
        }
    }

    /**
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function rollback(): void
    {
        if ($this->entityManager->getConnection()->isTransactionActive()) {
            $this
                ->entityManager
                ->getConnection()
                ->rollBack();
        }
        $this->entityManager->clear();
    }

}
