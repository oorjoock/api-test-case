<?php

namespace App\Service\Transaction;

interface TransactionServiceInterface
{
    public function start(): void;

    public function commit(): void;

    public function rollback(): void;
}
