<?php

namespace App\Exception;

use App\Entity\Account;

class NotEnoughMoneyException extends \Exception
{
    /**
     * @param Account $account
     * @return NotEnoughMoneyException
     */
    public static function from(Account $account)
    {
        return new self(\sprintf(
            'Not enough money on "%s" account',
            $account->getId()
        ));
    }

}
