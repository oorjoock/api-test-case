<?php

namespace App\Subscriber;

use App\Service\Transaction\TransactionServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestTransactionSubscriber implements EventSubscriberInterface
{
    /**
     * @var TransactionServiceInterface
     */
    private $transactionService;

    /**
     * @param TransactionServiceInterface $transactionService
     */
    public function __construct(TransactionServiceInterface $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => ['startTransaction', 10],
            KernelEvents::RESPONSE   => ['commitTransaction', 10],
            KernelEvents::EXCEPTION  => ['rollbackTransaction', 11],
        ];
    }

    public function startTransaction(): void
    {
        $this
            ->transactionService
            ->start();
    }

    public function commitTransaction(): void
    {
        $this
            ->transactionService
            ->commit();
    }

    public function rollbackTransaction(): void
    {
        $this
            ->transactionService
            ->rollback();
    }
}