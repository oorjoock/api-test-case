<?php

namespace App\Service;

use App\Entity\Account;
use App\Entity\Transaction;

class IncomeProcessor
{
    public function addIncome(
        Account $accountFrom,
        Account $accountTo,
        string $amount
    )
    {
        $transaction = Transaction::open();

    }
}