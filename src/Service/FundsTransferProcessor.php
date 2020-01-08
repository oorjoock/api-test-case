<?php

namespace App\Service;

use App\Entity\Account;
use App\Entity\Transaction;
use App\Entity\User;
use App\Exception\NotEnoughMoneyException;
use Doctrine\ORM\EntityManagerInterface;

class FundsTransferProcessor
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

    /**
     * @param string $sourceUserId
     * @param string $targetUserId
     * @param string $amount
     *
     * @throws NotEnoughMoneyException
     */
    public function transfer(
        string $sourceUserId,
        string $targetUserId,
        string $amount
    )
    {
        $userRepository = $this
            ->entityManager
            ->getRepository(User::class);

        $accountRepository = $this
            ->entityManager
            ->getRepository(Account::class);

        /** @var User $sourceUser */
        $sourceUser = $userRepository->findOneBy(['id' => $sourceUserId]);

        $accountSource = $sourceUser
            ->getAccounts()
            ->first();

        $accountSourceBalance = $accountRepository->getBalance($accountSource);

        if (($accountSourceBalance - $amount) < 0) {
            throw NotEnoughMoneyException::from($accountSource);
        }

        /** @var User $targetUser */
        $targetUser = $userRepository->findOneBy(['id' => $targetUserId]);

        $accountTarget = $targetUser
            ->getAccounts()
            ->first();

        $this->handle(
            $accountSource,
            $accountTarget,
            $amount
        );
    }

    /**
     * @param Account $accountSource
     * @param Account $accountTarget
     * @param string $amount
     */
    private function handle(
        Account $accountSource,
        Account $accountTarget,
        string $amount
    )
    {
        $transaction = Transaction::open();

        $transaction->addEntry(
            $accountSource,
            -$amount
        );

        $transaction->addEntry(
            $accountTarget,
            $amount
        );

        $this
            ->entityManager
            ->persist($transaction);
    }

}

